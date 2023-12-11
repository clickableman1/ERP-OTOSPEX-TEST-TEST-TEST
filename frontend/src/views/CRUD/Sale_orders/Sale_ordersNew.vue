<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useSale_ordersStore } from "@/stores/Sale_orders/sale_orders";
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

const sale_ordersStore = useSale_ordersStore()
const router = useRouter();

const notification = computed(() => sale_ordersStore.notify)
const titleStack = ref(['Admin', 'Sale_orders'])

const form = reactive({

      order_id: '',

      invoice_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await sale_ordersStore.newItem({ ...form })
    router.push('/sale_orders');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.order_id = '';

        form.invoice_id = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => sale_ordersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Sale_orders notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    sale_ordersStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Sale_orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Sale_orders"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Order Id"
    >
      <FormControl
        v-model="form.order_id"
        placeholder="Your Order Id"
      />
    </FormField>

    <FormField
      label="Invoice Id"
    >
      <FormControl
        v-model="form.invoice_id"
        placeholder="Your Invoice Id"
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
