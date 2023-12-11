<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useInvoicesStore } from "@/stores/Invoices/invoices";
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
const invoicesStore = useInvoicesStore()

const titleStack = ref(['Admin', 'Invoices'])
const notification = computed(() => invoicesStore.notify)

const invoicesItem = computed(() => invoicesStore.data);

const form = reactive({

    invoice_number: '',

    issue_date: '',

    due_date: '',

    user_id: '',

    supplier_id: '',

    total_amount: '',

})

const submit = async () => {
  try {

    await invoicesStore.edit({id: route.params.id, data: {...form} })
    router.push('/invoices');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await invoicesStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    invoicesStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.invoice_number = invoicesItem.value.invoice_number

    form.issue_date = invoicesItem.value.issue_date

    form.due_date = invoicesItem.value.due_date

    form.user_id = invoicesItem.value.user_id

    form.supplier_id = invoicesItem.value.supplier_id

    form.total_amount = invoicesItem.value.total_amount

}

watch(() => invoicesStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Invoices notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    invoicesStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/invoices')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Invoices</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Invoices"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Invoice Number"
    >
      <FormControl
        type="number"
        v-model="form.invoice_number"
        placeholder="Your Invoice Number"
      />
    </FormField>

    <FormField
      label="Issue Date"
    >
      <FormControl
        v-model="form.issue_date"
        placeholder="Your Issue Date"
        />
    </FormField>

    <FormField
      label="Due Date"
    >
      <FormControl
        v-model="form.due_date"
        placeholder="Your Due Date"
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
      label="Supplier Id"
    >
      <FormControl
        v-model="form.supplier_id"
        placeholder="Your Supplier Id"
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
