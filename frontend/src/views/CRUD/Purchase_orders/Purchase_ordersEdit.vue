<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const purchase_ordersStore = usePurchase_ordersStore()

const titleStack = ref(['Admin', 'Purchase_orders'])
const notification = computed(() => purchase_ordersStore.notify)

const purchase_ordersItem = computed(() => purchase_ordersStore.data);

const form = reactive({

    order_id: '',

    supplier_id: '',

    invoice_id: '',

})

const submit = async () => {
  try {

    await purchase_ordersStore.edit({id: route.params.id, data: {...form} })
    router.push('/purchase_orders');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await purchase_ordersStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    purchase_ordersStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.order_id = purchase_ordersItem.value.order_id

    form.supplier_id = purchase_ordersItem.value.supplier_id

    form.invoice_id = purchase_ordersItem.value.invoice_id

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/purchase_orders')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Purchase_orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Purchase_orders"
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
