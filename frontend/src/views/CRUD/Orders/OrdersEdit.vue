<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const ordersStore = useOrdersStore()

const titleStack = ref(['Admin', 'Orders'])
const notification = computed(() => ordersStore.notify)

const ordersItem = computed(() => ordersStore.data);

const form = reactive({

    user_id: '',

    order_type: '',

    status: '',

    total_amount: '',

})

const submit = async () => {
  try {

    await ordersStore.edit({id: route.params.id, data: {...form} })
    router.push('/orders');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await ordersStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    ordersStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.user_id = ordersItem.value.user_id

    form.order_type = ordersItem.value.order_type

    form.status = ordersItem.value.status

    form.total_amount = ordersItem.value.total_amount

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/orders')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Orders</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Orders"
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
