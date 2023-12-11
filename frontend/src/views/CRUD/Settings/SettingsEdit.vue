<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const settingsStore = useSettingsStore()

const titleStack = ref(['Admin', 'Settings'])
const notification = computed(() => settingsStore.notify)

const settingsItem = computed(() => settingsStore.data);

const form = reactive({

    user_id: '',

    language_id: '',

    currency: '',

})

const submit = async () => {
  try {

    await settingsStore.edit({id: route.params.id, data: {...form} })
    router.push('/settings');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await settingsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    settingsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.user_id = settingsItem.value.user_id

    form.language_id = settingsItem.value.language_id

    form.currency = settingsItem.value.currency

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/settings')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Settings</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Settings"
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
