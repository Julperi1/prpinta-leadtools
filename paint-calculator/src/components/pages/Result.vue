<script setup>
import { inject } from 'vue';

const price = inject('computedPrice');
</script>

<template>
  <div>
    <div class="d-flex jusitfy-center flex-column align-center">
      <v-card-title class="text-center mt-4 mb-4">
        Hinta-arviosi on laskettu!
      </v-card-title>

      <v-card max-width="320" color="success" flat class="mb-2">
        <v-card-title class="text-center mt-2 mb-2 text-h5">
          {{ price ? parseInt(price * 0.8) : 'virhe' }} € - {{ price ? parseInt(price * 1.2) : 'virhe' }} €
        </v-card-title>
      </v-card>

      <v-card-subtitle class="text-center mb-5">
        <b>Hintahaarukka on vain arvio</b>
      </v-card-subtitle>
    </div>
  </div>
</template>
