<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useUser_roleStore } from "@/stores/User_role/user_role";
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
const user_roleStore = useUser_roleStore()

const titleStack = ref(['Admin', 'User_role'])
const notification = computed(() => user_roleStore.notify)

const user_roleItem = computed(() => user_roleStore.data);

const form = reactive({

    user_id: '',

    role_id: '',

})

const submit = async () => {
  try {

    await user_roleStore.edit({id: route.params.id, data: {...form} })
    router.push('/user_role');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await user_roleStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    user_roleStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.user_id = user_roleItem.value.user_id

    form.role_id = user_roleItem.value.role_id

}

watch(() => user_roleStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "User_role notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    user_roleStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/user_role')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit User_role</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit User_role"
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
      label="Role Id"
    >
      <FormControl
        v-model="form.role_id"
        placeholder="Your Role Id"
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
