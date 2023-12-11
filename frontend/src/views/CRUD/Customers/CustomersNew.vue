<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
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
import Editor from '@tinymce/tinymce-vue'
import { notify } from "@kyvg/vue3-notification";

const customersStore = useCustomersStore()
const router = useRouter();

const notification = computed(() => customersStore.notify)
const titleStack = ref(['Admin', 'Customers'])

const form = reactive({

      name: '',

      user_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await customersStore.newItem({ ...form })
    router.push('/customers');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.name = '';

        form.user_id = '';

}

const cancel = () => {
  router.push('/users')
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

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Customers</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Customers"
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
