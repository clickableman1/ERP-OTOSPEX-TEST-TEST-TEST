<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useNotificationsStore } from "@/stores/Notifications/notifications";
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

const notificationsStore = useNotificationsStore()
const router = useRouter();

const notification = computed(() => notificationsStore.notify)
const titleStack = ref(['Admin', 'Notifications'])

const form = reactive({

      user_id: '',

      content: '',

      status: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await notificationsStore.newItem({ ...form })
    router.push('/notifications');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.user_id = '';

        form.content = '';

        form.status = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => notificationsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Notifications notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    notificationsStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Notifications</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Notifications"
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
      label="Content"
    >
      <FormControl
        v-model="form.content"
        placeholder="Your Content"
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
