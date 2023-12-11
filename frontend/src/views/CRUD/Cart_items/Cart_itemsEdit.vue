<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useCart_itemsStore } from "@/stores/Cart_items/cart_items";
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
const cart_itemsStore = useCart_itemsStore()

const titleStack = ref(['Admin', 'Cart_items'])
const notification = computed(() => cart_itemsStore.notify)

const cart_itemsItem = computed(() => cart_itemsStore.data);

const form = reactive({

})

const submit = async () => {
  try {

    await cart_itemsStore.edit({id: route.params.id, data: {...form} })
    router.push('/cart_items');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await cart_itemsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    cart_itemsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

}

watch(() => cart_itemsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Cart_items notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    cart_itemsStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/cart_items')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Cart_items</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Cart_items"
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
