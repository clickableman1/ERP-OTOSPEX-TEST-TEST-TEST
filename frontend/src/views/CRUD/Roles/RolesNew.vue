<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useRolesStore } from "@/stores/Roles/roles";
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

const rolesStore = useRolesStore()
const router = useRouter();

const notification = computed(() => rolesStore.notify)
const titleStack = ref(['Admin', 'Roles'])

const form = reactive({

      name: '',

      slug: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await rolesStore.newItem({ ...form })
    router.push('/roles');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.name = '';

        form.slug = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => rolesStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Roles notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    rolesStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Roles</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Roles"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Name"
    >
      <FormControl
        v-model="form.name"
        placeholder="Your Name"
      />
    </FormField>

    <FormField
      label="Slug"
    >
      <FormControl
        v-model="form.slug"
        placeholder="Your Slug"
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
