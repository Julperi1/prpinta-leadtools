<script setup>
import { ref } from 'vue';

const error = ref(false);
const data = ref({ walls: null });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title class="text-center mt-4">Huonojen seinien määrä</v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center" height="150">
      <v-sheet>
        <v-btn-toggle v-model="data.walls" divided base-color="grey-lighten-3" color="green" mandatory>
          <v-btn value="0" size="large">0</v-btn>
          <v-btn value="1-2" size="large">1-2</v-btn>
          <v-btn value="3-4" size="large">3-4</v-btn>
        </v-btn-toggle>

        <v-card-text v-if="error" class="text-error text-center text-caption py-0">
          Kerrosten määrä puuttuu
        </v-card-text>
        <v-card-text v-else class="text-grey-darken-1 text-caption py-0 pt-1">
          Maalipinta hilseilee ja/tai hometta
        </v-card-text>
      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
