<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const reputation_historyStore = useReputation_historyStore()

const titleStack = ref(['Admin', 'Reputation_history'])
const notification = computed(() => reputation_historyStore.notify)

        const optionsUser_id = computed(() => reputation_historyStore.searchResultUser_id);

const reputation_historyItem = computed(() => reputation_historyStore.data);

const form = reactive({

      user_id: '',

    action: '',

    reputation_change: '',

})

const submit = async () => {
  try {

            form.user_id = form.user_id?.id;

    await reputation_historyStore.edit({id: route.params.id, data: {...form} })
    router.push('/reputation_history');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

  await searchUser_id();

    await reputation_historyStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    reputation_historyStore.showNotification(e, 'error');
  }
})

    async function searchUser_id(val) {
      await reputation_historyStore.searchUser_id(val);
    }

const formatData = () => {

    form.user_id = dataFormatter.usersOneListFormatterEdit(reputation_historyItem.value.user_id)

    form.action = reputation_historyItem.value.action

    form.reputation_change = reputation_historyItem.value.reputation_change

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/reputation_history')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Reputation_history</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Reputation_history"
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
