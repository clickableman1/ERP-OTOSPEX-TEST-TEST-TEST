<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const stocksStore = useStocksStore()

const titleStack = ref(['Admin', 'Stocks'])
const notification = computed(() => stocksStore.notify)

const stocksItem = computed(() => stocksStore.data);

const form = reactive({

    part_id: '',

})

const submit = async () => {
  try {

    await stocksStore.edit({id: route.params.id, data: {...form} })
    router.push('/stocks');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await stocksStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    stocksStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.part_id = stocksItem.value.part_id

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/stocks')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Stocks</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Stocks"
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
