<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useRole_permissionStore } from "@/stores/Role_permission/role_permission";
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

const role_permissionStore = useRole_permissionStore()
const router = useRouter();

const notification = computed(() => role_permissionStore.notify)
const titleStack = ref(['Admin', 'Role_permission'])

const form = reactive({

      role_id: '',

      permission_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await role_permissionStore.newItem({ ...form })
    router.push('/role_permission');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.role_id = '';

        form.permission_id = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => role_permissionStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Role_permission notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    role_permissionStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Role_permission</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Role_permission"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Role Id"
    >
      <FormControl
        v-model="form.role_id"
        placeholder="Your Role Id"
      />
    </FormField>

    <FormField
      label="Permission Id"
    >
      <FormControl
        v-model="form.permission_id"
        placeholder="Your Permission Id"
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
