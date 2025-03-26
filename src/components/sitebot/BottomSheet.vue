<script setup>
import { inject, computed } from 'vue';
const model = defineModel();
const mobile = inject('mobile');

const width = computed(() => {
  return mobile.value ? '' : '380';
});


</script>

<template>
  <v-bottom-sheet v-model="model" eager :scrim="false" :width="width" persistent no-click-animation class="mx-2">
    <slot></slot>
  </v-bottom-sheet>
</template>
