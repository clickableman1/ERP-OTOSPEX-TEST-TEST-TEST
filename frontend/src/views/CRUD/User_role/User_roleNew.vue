<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
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
import Editor from '@tinymce/tinymce-vue'
import { notify } from "@kyvg/vue3-notification";

const user_roleStore = useUser_roleStore()
const router = useRouter();

const notification = computed(() => user_roleStore.notify)
const titleStack = ref(['Admin', 'User_role'])

const form = reactive({

      user_id: '',

      role_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await user_roleStore.newItem({ ...form })
    router.push('/user_role');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.user_id = '';

        form.role_id = '';

}

const cancel = () => {
  router.push('/users')
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

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New User_role</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New User_role"
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
