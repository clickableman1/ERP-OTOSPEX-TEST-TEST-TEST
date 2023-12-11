<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const sale_ordersStore = useSale_ordersStore()

const titleStack = ref(['Admin', 'Sale_orders'])
const notification = computed(() => sale_ordersStore.notify)

const sale_ordersItem = computed(() => sale_ordersStore.data);

const form = reactive({

    order_id: '',

    invoice_id: '',

})

const submit = async () => {
  try {

    await sale_ordersStore.edit({id: route.params.id, data: {...form} })
    router.push('/sale_orders');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await sale_ordersStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    sale_ordersStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.order_id = sale_ordersItem.value.order_id

    form.invoice_id = sale_ordersItem.value.invoice_id

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/sale_orders')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Sale_orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Sale_orders"
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
