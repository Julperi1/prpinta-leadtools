<script setup>
import { ref } from 'vue';

const error = ref(false);
const data = ref({ squares: null });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title class="text-center mt-4">Anna kohteen pohjaneliöt</v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center" height="150">
      <v-sheet>
        <v-text-field v-model="data.squares" label="Neliöt" width="250" persistent-hint hint="Alimman kerroksen neliöt"
          :error-messages="error ? ['Anna oikea arvo'] : []" density="comfortable" type="number" hide-spin-buttons
          variant="solo-filled" flat id="prpinta-squares">
          <template v-slot:append-inner>
            m²
          </template>
        </v-text-field>
      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
