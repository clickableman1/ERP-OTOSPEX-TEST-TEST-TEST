<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useReputation_historyStore } from "@/stores/Reputation_history/reputation_history";
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

const reputation_historyStore = useReputation_historyStore()
const router = useRouter();

const notification = computed(() => reputation_historyStore.notify)
const titleStack = ref(['Admin', 'Reputation_history'])

        const optionsUser_id = computed(() => reputation_historyStore.searchResultUser_id);

const form = reactive({

      user_id: '',

      action: '',

      reputation_change: '',

})

onBeforeMount(async () => {

  await searchUser_id();

})

const submit = async () => {
  try {

            form.user_id = form.user_id.id;

    await reputation_historyStore.newItem({ ...form })
    router.push('/reputation_history');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.user_id = '';

        form.action = '';

        form.reputation_change = '';

}

const cancel = () => {
  router.push('/users')
}

    async function searchUser_id(val) {
      await reputation_historyStore.searchUser_id(val);
    }

watch(() => reputation_historyStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Reputation_history notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    reputation_historyStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Reputation_history</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Reputation_history"
      form
      @submit.prevent="submit"
    >

  <FormField
      label="User Id"
    >
        <v-select
          v-model="form.user_id"
          :options="optionsUser_id"
          @input="searchUser_id($event.target.value)"
        />
  </FormField>

    <FormField
      label="Action"
    >
      <FormControl
        v-model="form.action"
        placeholder="Your Action"
      />
    </FormField>

    <FormField
      label="Reputation Change"
    >
      <FormControl
        v-model="form.reputation_change"
        placeholder="Your Reputation Change"
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
