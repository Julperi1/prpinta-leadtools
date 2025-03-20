<script setup>
import { inject } from 'vue';

const closeSmall = inject('closeSmall');
const clickSmall = inject('clickSmall');
</script>
<template>
  <v-card class="overflow-visible rounded-t-lg" elevation="0" @click="clickSmall">
    <v-sheet rounded="lg" class="position-absolute bottom-0 left-0" height="70" width="70">
      <v-avatar class="ma-1" rounded="lg" size="62"
        image="https://prpintakasittely.fi/wp-content/uploads/2023/07/eeee-1024x1024.jpg"></v-avatar>
    </v-sheet>

    <v-card-title class="ml-16 d-flex align-center justify-space-between">
      Kirjoita tähän jotain?
      <button @click.stop="closeSmall">
        <v-icon>mdi-close</v-icon>
      </button>
    </v-card-title>

  </v-card>
</template>
