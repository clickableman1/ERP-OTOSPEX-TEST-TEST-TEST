<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCustomersStore } from "@/stores/Customers/customers";
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
const customersStore = useCustomersStore()

const titleStack = ref(['Admin', 'Customers'])
const notification = computed(() => customersStore.notify)

const customersItem = computed(() => customersStore.data);

const form = reactive({

    name: '',

    user_id: '',

})

const submit = async () => {
  try {

    await customersStore.edit({id: route.params.id, data: {...form} })
    router.push('/customers');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await customersStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    customersStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.name = customersItem.value.name

    form.user_id = customersItem.value.user_id

}

watch(() => customersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Customers notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    customersStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/customers')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Customers</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Customers"
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
      label="User Id"
    >
      <FormControl
        v-model="form.user_id"
        placeholder="Your User Id"
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
