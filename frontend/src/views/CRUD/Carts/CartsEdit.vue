<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCartsStore } from "@/stores/Carts/carts";
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
const cartsStore = useCartsStore()

const titleStack = ref(['Admin', 'Carts'])
const notification = computed(() => cartsStore.notify)

const cartsItem = computed(() => cartsStore.data);

const form = reactive({

})

const submit = async () => {
  try {

    await cartsStore.edit({id: route.params.id, data: {...form} })
    router.push('/carts');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await cartsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    cartsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

}

watch(() => cartsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Carts notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    cartsStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/carts')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Carts</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Carts"
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
