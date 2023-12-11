<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
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
import Editor from '@tinymce/tinymce-vue'
import { notify } from "@kyvg/vue3-notification";

const cart_itemsStore = useCart_itemsStore()
const router = useRouter();

const notification = computed(() => cart_itemsStore.notify)
const titleStack = ref(['Admin', 'Cart_items'])

const form = reactive({

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await cart_itemsStore.newItem({ ...form })
    router.push('/cart_items');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

}

const cancel = () => {
  router.push('/users')
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

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Cart_items</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Cart_items"
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
