<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useService_ordersStore } from "@/stores/Service_orders/service_orders";
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

const service_ordersStore = useService_ordersStore()
const router = useRouter();

const notification = computed(() => service_ordersStore.notify)
const titleStack = ref(['Admin', 'Service_orders'])

const form = reactive({

      service_id: '',

      user_id: '',

      status: '',

      appointment_date: '',

      order_date: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await service_ordersStore.newItem({ ...form })
    router.push('/service_orders');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.service_id = '';

        form.user_id = '';

        form.status = '';

        form.appointment_date = '';

        form.order_date = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => service_ordersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Service_orders notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    service_ordersStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Service_orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Service_orders"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Service Id"
    >
      <FormControl
        v-model="form.service_id"
        placeholder="Your Service Id"
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

    <FormField
      label="Status"
    >
      <FormControl
        v-model="form.status"
        placeholder="Your Status"
      />
    </FormField>

    <FormField
      label="Appointment Date"
    >
      <FormControl
        type="datetime-local"
        v-model="form.appointment_date"
        placeholder="Your Appointment Date"
      />
    </FormField>

    <FormField
      label="Order Date"
    >
      <FormControl
        type="datetime-local"
        v-model="form.order_date"
        placeholder="Your Order Date"
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
