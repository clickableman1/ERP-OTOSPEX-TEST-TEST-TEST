<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useServicesStore } from "@/stores/Services/services";
import SectionMain from '@/components/SectionMain.vue'
import SectionTitleBar from '@/components/SectionTitleBar.vue'
import CardBox from '@/components/CardBox.vue'
import FormCheckRadioPicker from '@/components/FormCheckRadioPicker.vue'
import FormFilePicker from '@/components/FormFilePicker.vue'
import SectionHeroBar from '@/components/SectionHeroBar.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const servicesStore = useServicesStore()

const titleStack = ref(['Admin', 'Services'])
const notification = computed(() => servicesStore.notify)

const servicesItem = computed(() => servicesStore.data);

const form = reactive({

    name: '',

    description: '',

    price: '',

})

const submit = async () => {
  try {

    await servicesStore.edit({id: route.params.id, data: {...form} })
    router.push('/services');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await servicesStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    servicesStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.name = servicesItem.value.name

    form.description = servicesItem.value.description

    form.price = servicesItem.value.price

}

watch(() => servicesStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Services notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    servicesStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/services')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Services</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Services"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Name"
    >
      <FormControl
        v-model="form.name"
        placeholder="Your Name"
        />
    </FormField>

    <FormField
      label="Description"
    >
      <FormControl
        v-model="form.description"
        placeholder="Your Description"
        />
    </FormField>

    <FormField
      label="Price"
    >
      <FormControl
        type="number"
        v-model="form.price"
        placeholder="Your Price"
      />
    </FormField>

    <BaseDivider />

    <BaseButtons>
      <BaseButton
        type="submit"
        color="info"
        label="Submit"
      />
      <BaseButton
        type="button"
        color="info"
        outline
        label="Reset"
        @click="reset"
      />
      <BaseButton
        type="cancel"
        color="danger"
        outline
        label="Cancel"
        @click="cancel"
      />
    </BaseButtons>
  </CardBox>
</SectionMain>

</template>
