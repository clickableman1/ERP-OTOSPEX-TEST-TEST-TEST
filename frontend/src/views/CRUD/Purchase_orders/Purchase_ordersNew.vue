<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { usePurchase_ordersStore } from "@/stores/Purchase_orders/purchase_orders";
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

const purchase_ordersStore = usePurchase_ordersStore()
const router = useRouter();

const notification = computed(() => purchase_ordersStore.notify)
const titleStack = ref(['Admin', 'Purchase_orders'])

const form = reactive({

      order_id: '',

      supplier_id: '',

      invoice_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await purchase_ordersStore.newItem({ ...form })
    router.push('/purchase_orders');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.order_id = '';

        form.supplier_id = '';

        form.invoice_id = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => purchase_ordersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Purchase_orders notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    purchase_ordersStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Purchase_orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Purchase_orders"
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
      label="Supplier Id"
    >
      <FormControl
        v-model="form.supplier_id"
        placeholder="Your Supplier Id"
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
