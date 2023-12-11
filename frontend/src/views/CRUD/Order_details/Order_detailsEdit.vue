<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useOrder_detailsStore } from "@/stores/Order_details/order_details";
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
const order_detailsStore = useOrder_detailsStore()

const titleStack = ref(['Admin', 'Order_details'])
const notification = computed(() => order_detailsStore.notify)

const order_detailsItem = computed(() => order_detailsStore.data);

const form = reactive({

    order_id: '',

    part_id: '',

      quantity: '',

    unit_price: '',

    subtotal: '',

})

const submit = async () => {
  try {

    await order_detailsStore.edit({id: route.params.id, data: {...form} })
    router.push('/order_details');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await order_detailsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    order_detailsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.order_id = order_detailsItem.value.order_id

    form.part_id = order_detailsItem.value.part_id

    form.quantity = order_detailsItem.value.quantity

    form.unit_price = order_detailsItem.value.unit_price

    form.subtotal = order_detailsItem.value.subtotal

}

watch(() => order_detailsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Order_details notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    order_detailsStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/order_details')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Order_details</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Order_details"
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
      label="Part Id"
    >
      <FormControl
        v-model="form.part_id"
        placeholder="Your Part Id"
        />
    </FormField>

    <FormField
      label="Quantity"
    >
      <FormControl
        type="number"
        v-model="form.quantity"
        placeholder="Your Quantity"
      />
    </FormField>

    <FormField
      label="Unit Price"
    >
      <FormControl
        type="number"
        v-model="form.unit_price"
        placeholder="Your Unit Price"
      />
    </FormField>

    <FormField
      label="Subtotal"
    >
      <FormControl
        type="number"
        v-model="form.subtotal"
        placeholder="Your Subtotal"
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
