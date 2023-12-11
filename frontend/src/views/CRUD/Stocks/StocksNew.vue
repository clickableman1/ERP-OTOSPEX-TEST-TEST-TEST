<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useStocksStore } from "@/stores/Stocks/stocks";
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

const stocksStore = useStocksStore()
const router = useRouter();

const notification = computed(() => stocksStore.notify)
const titleStack = ref(['Admin', 'Stocks'])

const form = reactive({

      part_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await stocksStore.newItem({ ...form })
    router.push('/stocks');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.part_id = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => stocksStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Stocks notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    stocksStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Stocks</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Stocks"
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
