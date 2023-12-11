<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
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
import Editor from '@tinymce/tinymce-vue'
import { notify } from "@kyvg/vue3-notification";

const servicesStore = useServicesStore()
const router = useRouter();

const notification = computed(() => servicesStore.notify)
const titleStack = ref(['Admin', 'Services'])

const form = reactive({

      name: '',

      description: '',

      price: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await servicesStore.newItem({ ...form })
    router.push('/services');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.name = '';

        form.description = '';

        form.price = '';

}

const cancel = () => {
  router.push('/users')
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

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Services</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Services"
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
        type="reset"
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
