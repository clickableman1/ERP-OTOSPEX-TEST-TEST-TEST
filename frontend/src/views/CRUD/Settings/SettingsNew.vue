<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useSettingsStore } from "@/stores/Settings/settings";
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

const settingsStore = useSettingsStore()
const router = useRouter();

const notification = computed(() => settingsStore.notify)
const titleStack = ref(['Admin', 'Settings'])

const form = reactive({

      user_id: '',

      language_id: '',

      currency: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await settingsStore.newItem({ ...form })
    router.push('/settings');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.user_id = '';

        form.language_id = '';

        form.currency = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => settingsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Settings notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    settingsStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Settings</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Settings"
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
      label="Language Id"
    >
      <FormControl
        v-model="form.language_id"
        placeholder="Your Language Id"
      />
    </FormField>

    <FormField
      label="Currency"
    >
      <FormControl
        v-model="form.currency"
        placeholder="Your Currency"
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
