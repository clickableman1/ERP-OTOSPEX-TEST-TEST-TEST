<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useSuppliersStore } from "@/stores/Suppliers/suppliers";
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
const suppliersStore = useSuppliersStore()

const titleStack = ref(['Admin', 'Suppliers'])
const notification = computed(() => suppliersStore.notify)

const suppliersItem = computed(() => suppliersStore.data);

const form = reactive({

    name: '',

    location: '',

    email: '',

    country_of_origin: '',

    phone: '',

      year_established: '',

    website: '',

})

const submit = async () => {
  try {

    await suppliersStore.edit({id: route.params.id, data: {...form} })
    router.push('/suppliers');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await suppliersStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    suppliersStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.name = suppliersItem.value.name

    form.location = suppliersItem.value.location

    form.email = suppliersItem.value.email

    form.country_of_origin = suppliersItem.value.country_of_origin

    form.phone = suppliersItem.value.phone

    form.year_established = suppliersItem.value.year_established

    form.website = suppliersItem.value.website

}

watch(() => suppliersStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Suppliers notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    suppliersStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/suppliers')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Suppliers</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Suppliers"
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
      label="Location"
    >
      <FormControl
        v-model="form.location"
        placeholder="Your Location"
        />
    </FormField>

    <FormField
      label="Email"
    >
      <FormControl
        v-model="form.email"
        placeholder="Your Email"
        />
    </FormField>

    <FormField
      label="Country Of Origin"
    >
      <FormControl
        v-model="form.country_of_origin"
        placeholder="Your Country Of Origin"
        />
    </FormField>

    <FormField
      label="Phone"
    >
      <FormControl
        v-model="form.phone"
        placeholder="Your Phone"
        />
    </FormField>

    <FormField
      label="Year Established"
    >
      <FormControl
        type="number"
        v-model="form.year_established"
        placeholder="Your Year Established"
      />
    </FormField>

    <FormField
      label="Website"
    >
      <FormControl
        v-model="form.website"
        placeholder="Your Website"
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
