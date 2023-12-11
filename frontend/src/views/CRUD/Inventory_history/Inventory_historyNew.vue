<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useInventory_historyStore } from "@/stores/Inventory_history/inventory_history";
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

const inventory_historyStore = useInventory_historyStore()
const router = useRouter();

const notification = computed(() => inventory_historyStore.notify)
const titleStack = ref(['Admin', 'Inventory_history'])

const form = reactive({

      part_id: '',

      transaction_type: '',

      transaction_date: '',

      quantity_change: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await inventory_historyStore.newItem({ ...form })
    router.push('/inventory_history');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.part_id = '';

        form.transaction_type = '';

        form.transaction_date = '';

        form.quantity_change = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => inventory_historyStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Inventory_history notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    inventory_historyStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Inventory_history</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Inventory_history"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Part Id"
    >
      <FormControl
        v-model="form.part_id"
        placeholder="Your Part Id"
      />
    </FormField>

    <FormField
      label="Transaction Type"
    >
      <FormControl
        v-model="form.transaction_type"
        placeholder="Your Transaction Type"
      />
    </FormField>

    <FormField
      label="Transaction Date"
    >
      <FormControl
        v-model="form.transaction_date"
        placeholder="Your Transaction Date"
      />
    </FormField>

    <FormField
      label="Quantity Change"
    >
      <FormControl
        v-model="form.quantity_change"
        placeholder="Your Quantity Change"
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
