<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePartsStore } from "@/stores/Parts/parts";
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
const partsStore = usePartsStore()

const titleStack = ref(['Admin', 'Parts'])
const notification = computed(() => partsStore.notify)

const partsItem = computed(() => partsStore.data);

const form = reactive({

    name: '',

    description: '',

    barcode: '',

    category: '',

    price: '',

    weight: '',

    dimensions: '',

      quantity_in_stock: '',

      minimum_stock_level: '',

    manufacturer_id: '',

    supplier_id: '',

})

const submit = async () => {
  try {

    await partsStore.edit({id: route.params.id, data: {...form} })
    router.push('/parts');
  } catch (e) {
    console.log(e);
  }
}

onBeforeMount(async () => {
  try {

    await partsStore.fetch(route.params.id)
    formatData();
  } catch (e) {
    console.log(e)
    partsStore.showNotification(e, 'error');
  }
})

const formatData = () => {

    form.name = partsItem.value.name

    form.description = partsItem.value.description

    form.barcode = partsItem.value.barcode

    form.category = partsItem.value.category

    form.price = partsItem.value.price

    form.weight = partsItem.value.weight

    form.dimensions = partsItem.value.dimensions

    form.quantity_in_stock = partsItem.value.quantity_in_stock

    form.minimum_stock_level = partsItem.value.minimum_stock_level

    form.manufacturer_id = partsItem.value.manufacturer_id

    form.supplier_id = partsItem.value.supplier_id

}

watch(() => partsStore.notify.showNotification, (newValue, oldValue) => {
  if(newValue){
    notify({
      title: "Parts notification",
      text: notification.value.textNotification,
      type: notification.value.typeNotification,
    });
    partsStore.hideNotification()
  }
});

const reset = () => {
  formatData();
}

const cancel = () => {
  router.push('/parts')
}

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Edit Parts</SectionHeroBar>

  <SectionMain>
    <CardBox
      title="Edit Parts"
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
      label="Description"
    >
      <FormControl
        v-model="form.description"
        placeholder="Your Description"
        />
    </FormField>

    <FormField
      label="Barcode"
    >
      <FormControl
        v-model="form.barcode"
        placeholder="Your Barcode"
        />
    </FormField>

    <FormField
      label="Category"
    >
      <FormControl
        v-model="form.category"
        placeholder="Your Category"
        />
    </FormField>

    <FormField
      label="Price"
    >
      <FormControl
        type="number"
        v-model="form.price"
        placeholder="Your Price"
      />
    </FormField>

    <FormField
      label="Weight"
    >
      <FormControl
        type="number"
        v-model="form.weight"
        placeholder="Your Weight"
      />
    </FormField>

    <FormField
      label="Dimensions"
    >
      <FormControl
        v-model="form.dimensions"
        placeholder="Your Dimensions"
        />
    </FormField>

    <FormField
      label="Quantity In Stock"
    >
      <FormControl
        type="number"
        v-model="form.quantity_in_stock"
        placeholder="Your Quantity In Stock"
      />
    </FormField>

    <FormField
      label="Minimum Stock Level"
    >
      <FormControl
        type="number"
        v-model="form.minimum_stock_level"
        placeholder="Your Minimum Stock Level"
      />
    </FormField>

    <FormField
      label="Manufacturer Id"
    >
      <FormControl
        v-model="form.manufacturer_id"
        placeholder="Your Manufacturer Id"
        />
    </FormField>

    <FormField
      label="Supplier Id"
    >
      <FormControl
        v-model="form.supplier_id"
        placeholder="Your Supplier Id"
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
