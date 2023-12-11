<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useWarehousesStore } from "@/stores/Warehouses/warehouses";
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

const warehousesStore = useWarehousesStore()
const router = useRouter();

const notification = computed(() => warehousesStore.notify)
const titleStack = ref(['Admin', 'Warehouses'])

const form = reactive({

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await warehousesStore.newItem({ ...form })
    router.push('/warehouses');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

}

const cancel = () => {
  router.push('/users')
}

watch(() => warehousesStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Warehouses notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    warehousesStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Warehouses</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Warehouses"
      form
      @submit.prevent="submit"
    >

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
