<script setup>
import { ref, onMounted, reactive } from 'vue'
import axios from 'axios';
import {
  mdiInformation,
} from '@mdi/js'

import SectionMain from '@/components/SectionMain.vue'
import SectionTitleBar from '@/components/SectionTitleBar.vue'
import SectionHeroBar from '@/components/SectionHeroBar.vue'
import CardBoxWidget from '@/components/CardBoxWidget.vue'

const titleStack = ref(['Admin', 'Dashboard'])

const counts = reactive({
  users: 0,suppliers: 0,invoices: 0,settings: 0,orders: 0,order_details: 0,purchase_orders: 0,sale_orders: 0,parts: 0,stocks: 0,services: 0,service_orders: 0,vehicle_part_services: 0,warehouses: 0,carts: 0,cart_items: 0,notifications: 0,reputation_history: 0,inventory_history: 0,customers: 0,roles: 0,permissions: 0,user_role: 0,role_permission: 0,
})

onMounted(() => {
  const fetchData = async () => {
    const { data: { count: users } } = await axios.get('/users/count');
    const { data: { count: suppliers } } = await axios.get('/suppliers/count');
    const { data: { count: invoices } } = await axios.get('/invoices/count');
    const { data: { count: settings } } = await axios.get('/settings/count');
    const { data: { count: orders } } = await axios.get('/orders/count');
    const { data: { count: order_details } } = await axios.get('/order_details/count');
    const { data: { count: purchase_orders } } = await axios.get('/purchase_orders/count');
    const { data: { count: sale_orders } } = await axios.get('/sale_orders/count');
    const { data: { count: parts } } = await axios.get('/parts/count');
    const { data: { count: stocks } } = await axios.get('/stocks/count');
    const { data: { count: services } } = await axios.get('/services/count');
    const { data: { count: service_orders } } = await axios.get('/service_orders/count');
    const { data: { count: vehicle_part_services } } = await axios.get('/vehicle_part_services/count');
    const { data: { count: warehouses } } = await axios.get('/warehouses/count');
    const { data: { count: carts } } = await axios.get('/carts/count');
    const { data: { count: cart_items } } = await axios.get('/cart_items/count');
    const { data: { count: notifications } } = await axios.get('/notifications/count');
    const { data: { count: reputation_history } } = await axios.get('/reputation_history/count');
    const { data: { count: inventory_history } } = await axios.get('/inventory_history/count');
    const { data: { count: customers } } = await axios.get('/customers/count');
    const { data: { count: roles } } = await axios.get('/roles/count');
    const { data: { count: permissions } } = await axios.get('/permissions/count');
    const { data: { count: user_role } } = await axios.get('/user_role/count');
    const { data: { count: role_permission } } = await axios.get('/role_permission/count');

    counts.users = users;
    counts.suppliers = suppliers;
    counts.invoices = invoices;
    counts.settings = settings;
    counts.orders = orders;
    counts.order_details = order_details;
    counts.purchase_orders = purchase_orders;
    counts.sale_orders = sale_orders;
    counts.parts = parts;
    counts.stocks = stocks;
    counts.services = services;
    counts.service_orders = service_orders;
    counts.vehicle_part_services = vehicle_part_services;
    counts.warehouses = warehouses;
    counts.carts = carts;
    counts.cart_items = cart_items;
    counts.notifications = notifications;
    counts.reputation_history = reputation_history;
    counts.inventory_history = inventory_history;
    counts.customers = customers;
    counts.roles = roles;
    counts.permissions = permissions;
    counts.user_role = user_role;
    counts.role_permission = role_permission;

  };
  fetchData();
})

</script>

<template>
  <SectionTitleBar :title-stack="titleStack" />
  <SectionHeroBar>Dashboard</SectionHeroBar>
  <SectionMain>
    <p class="text-2xl text-pavitra-900">
      Welcome, Admin
    </p>
  </SectionMain>
  <SectionMain class="flex flex-wrap">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6 w-full">

      <a href="#/users">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.users"
        label="Users"
          /></a><a href="#/suppliers">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.suppliers"
        label="Suppliers"
          /></a><a href="#/invoices">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.invoices"
        label="Invoices"
          /></a><a href="#/settings">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.settings"
        label="Settings"
          /></a><a href="#/orders">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.orders"
        label="Orders"
          /></a><a href="#/order_details">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.order_details"
        label="Order_details"
          /></a><a href="#/purchase_orders">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.purchase_orders"
        label="Purchase_orders"
          /></a><a href="#/sale_orders">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.sale_orders"
        label="Sale_orders"
          /></a><a href="#/parts">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.parts"
        label="Parts"
          /></a><a href="#/stocks">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.stocks"
        label="Stocks"
          /></a><a href="#/services">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.services"
        label="Services"
          /></a><a href="#/service_orders">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.service_orders"
        label="Service_orders"
          /></a><a href="#/vehicle_part_services">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.vehicle_part_services"
        label="Vehicle_part_services"
          /></a><a href="#/warehouses">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.warehouses"
        label="Warehouses"
          /></a><a href="#/carts">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.carts"
        label="Carts"
          /></a><a href="#/cart_items">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.cart_items"
        label="Cart_items"
          /></a><a href="#/notifications">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.notifications"
        label="Notifications"
          /></a><a href="#/reputation_history">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.reputation_history"
        label="Reputation_history"
          /></a><a href="#/inventory_history">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.inventory_history"
        label="Inventory_history"
          /></a><a href="#/customers">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.customers"
        label="Customers"
          /></a><a href="#/roles">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.roles"
        label="Roles"
          /></a><a href="#/permissions">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.permissions"
        label="Permissions"
          /></a><a href="#/user_role">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.user_role"
        label="User_role"
          /></a><a href="#/role_permission">
        <CardBoxWidget
        color="text-blue-500"
        :icon="mdiInformation"
        :number="counts.role_permission"
        label="Role_permission"
          /></a>

    </div>
  </SectionMain>
</template>
