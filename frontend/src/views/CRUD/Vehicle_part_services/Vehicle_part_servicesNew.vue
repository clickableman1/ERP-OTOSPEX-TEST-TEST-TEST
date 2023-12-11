<script setup>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useVehicle_part_servicesStore } from "@/stores/Vehicle_part_services/vehicle_part_services";
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

const vehicle_part_servicesStore = useVehicle_part_servicesStore()
const router = useRouter();

const notification = computed(() => vehicle_part_servicesStore.notify)
const titleStack = ref(['Admin', 'Vehicle_part_services'])

const form = reactive({

      service_id: '',

      part_id: '',

})

onBeforeMount(async () => {

})

const submit = async () => {
  try {

    await vehicle_part_servicesStore.newItem({ ...form })
    router.push('/vehicle_part_services');
  } catch (e) {
    console.log(e);
  }
}

const reset = () => {

        form.service_id = '';

        form.part_id = '';

}

const cancel = () => {
  router.push('/users')
}

watch(() => vehicle_part_servicesStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Vehicle_part_services notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    vehicle_part_servicesStore.hideNotification()
  }
});

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>New Vehicle_part_services</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="New Vehicle_part_services"
      form
      @submit.prevent="submit"
    >

    <FormField
      label="Service Id"
    >
      <FormControl
        v-model="form.service_id"
        placeholder="Your Service Id"
      />
    </FormField>

    <FormField
      label="Part Id"
    >
      <FormControl
        v-model="form.part_id"
        placeholder="Your Part Id"
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
