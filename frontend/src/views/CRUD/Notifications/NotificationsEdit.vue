<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const notificationsStore = useNotificationsStore()

const titleStack = ref(['Admin', 'Notifications'])
const notification = computed(() => notificationsStore.notify)

const notificationsItem = computed(() => notificationsStore.data);

const form = reactive({

    user_id: '',

    content: '',

    status: '',

})

const submit = async () => {
  try {

    await notificationsStore.edit({id: route.params.id, data: {...form} })
    router.push('/notifications');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await notificationsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    notificationsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.user_id = notificationsItem.value.user_id

    form.content = notificationsItem.value.content

    form.status = notificationsItem.value.status

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/notifications')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Notifications</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Notifications"
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
