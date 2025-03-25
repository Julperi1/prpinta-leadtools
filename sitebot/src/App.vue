<script setup>
import { computed, provide } from 'vue';
import SiteBot from '@/components/SiteBot.vue';
import { useDisplay } from 'vuetify';

const mobile = computed(() => {
  return useDisplay().smAndDown;
});

provide('mobile', mobile.value);
</script>
<template>
  <SiteBot />
</template>
