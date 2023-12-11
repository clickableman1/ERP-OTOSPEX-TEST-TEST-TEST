<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePermissionsStore } from "@/stores/Permissions/permissions";
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
const permissionsStore = usePermissionsStore()

const titleStack = ref(['Admin', 'Permissions'])
const notification = computed(() => permissionsStore.notify)

const permissionsItem = computed(() => permissionsStore.data);

const form = reactive({

    name: '',

    slug: '',

})

const submit = async () => {
  try {

    await permissionsStore.edit({id: route.params.id, data: {...form} })
    router.push('/permissions');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await permissionsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    permissionsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.name = permissionsItem.value.name

    form.slug = permissionsItem.value.slug

}

watch(() => permissionsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Permissions notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    permissionsStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/permissions')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Permissions</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Permissions"
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
