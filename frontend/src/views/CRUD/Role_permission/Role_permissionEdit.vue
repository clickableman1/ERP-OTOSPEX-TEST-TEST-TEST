<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
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
import { notify } from "@kyvg/vue3-notification";
import Editor from '@tinymce/tinymce-vue';
import dataFormatter from '@/helpers/dataFormatter';

const router = useRouter();
const route = useRoute();
const role_permissionStore = useRole_permissionStore()

const titleStack = ref(['Admin', 'Role_permission'])
const notification = computed(() => role_permissionStore.notify)

const role_permissionItem = computed(() => role_permissionStore.data);

const form = reactive({

    role_id: '',

    permission_id: '',

})

const submit = async () => {
  try {

    await role_permissionStore.edit({id: route.params.id, data: {...form} })
    router.push('/role_permission');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await role_permissionStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    role_permissionStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.role_id = role_permissionItem.value.role_id

    form.permission_id = role_permissionItem.value.permission_id

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

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/role_permission')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Role_permission</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Role_permission"
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
