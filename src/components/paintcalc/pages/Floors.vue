<script setup>
import { ref } from 'vue';

const error = ref(false);
const data = ref({ floors: null });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title style="font-size:20px !important" class="text-center mt-4">Anna kerrosten määrä</v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center" height="150">
      <v-sheet>
        <v-btn-toggle v-model="data.floors" divided base-color="grey-lighten-3" color="green" mandatory rounded="lg">
          <v-btn value="1.0" size="large">1</v-btn>
          <v-btn value="1.5" size="large">1½</v-btn>
          <v-btn value="2.0" size="large">2</v-btn>
        </v-btn-toggle>

        <v-card-text v-if="error" class="text-error text-center text-caption py-0">
          Kerrosten määrä puuttuu
        </v-card-text>
        <v-card-text v-else class="text-grey-darken-1 text-caption py-0 pt-1">
          Valitse määrä klikkaamalla
        </v-card-text>
      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
