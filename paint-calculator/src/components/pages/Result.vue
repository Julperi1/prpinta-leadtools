<script setup>
import { inject } from 'vue';

const price = inject('computedPrice');
</script>

<template>
  <div>
    <v-card-title class="text-center mt-4 mb-4">
      Hinta-arviosi on laskettu!
    </v-card-title>

    <v-card-title class="text-center mt-4 mb-4 text-h4">
      {{ price ? parseInt(price * 0.8) : 'virhe' }} € - {{ price ? parseInt(price * 1.2) : 'virhe' }} €
    </v-card-title>
    <v-card-subtitle class="text-center">
      <b>Hintahaarukka on vain arvio</b>
    </v-card-subtitle>
  </div>
</template>
