<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useOrdersStore } from "@/stores/Orders/orders";
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

const ordersStore = useOrdersStore()
const router = useRouter();

const notification = computed(() => ordersStore.notify)
const titleStack = ref(['Admin', 'Orders'])

const form = reactive({

      user_id: '',

      order_type: '',

      status: '',

      total_amount: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await ordersStore.newItem({ ...form })
    router.push('/orders');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.user_id = '';

        form.order_type = '';

        form.status = '';

        form.total_amount = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => ordersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Orders notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    ordersStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Orders"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="User Id"
    >
      <FormControl
        v-model="form.user_id"
        placeholder="Your User Id"
      />
    </FormField>

    <FormField
      label="Order Type"
    >
      <FormControl
        v-model="form.order_type"
        placeholder="Your Order Type"
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
      label="Total Amount"
    >
      <FormControl
        type="number"
        v-model="form.total_amount"
        placeholder="Your Total Amount"
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
