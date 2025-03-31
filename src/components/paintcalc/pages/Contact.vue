<script setup>
import { ref, inject } from 'vue';

const mobile = inject('mobile');
const error = ref(null);
const data = ref({ name: null, email: null, phone: null, });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title class="text-center mt-4 mb-4">
      Täytä lomake niin näet <br v-if="mobile.value"> hinta-arvion heti!
    </v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center">
      <v-sheet>
        <v-text-field v-model="data.name" label="Nimi / Yritys" width="250" density="compact"
          :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" variant="solo-filled" flat
          id="prpinta-calc-name">
        </v-text-field>

        <v-text-field v-model="data.email" label="Sähköpostiosoite" width="250" type="email" density="compact"
          :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" variant="solo-filled" flat
          id="prpinta-calc-email">
        </v-text-field>

        <v-text-field v-model="data.phone" label="Puhelinnumero" width="250" density="compact"
          :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" variant="solo-filled" flat
          id="prpinta-calc-phone">
        </v-text-field>
      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
