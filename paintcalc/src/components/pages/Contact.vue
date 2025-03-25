<script setup>
import { ref } from 'vue';

const error = ref(null);
const data = ref({ name: null, email: null, phone: null, });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title class="text-center mt-4 mb-4">
      Täytä lomake niin näet hinta arvion heti!
    </v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center">
      <v-sheet>
        <v-text-field v-model="data.name" label="Nimi / Yritys" width="250" density="compact"
          :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" variant="solo-filled" flat>
        </v-text-field>

        <v-text-field v-model="data.email" label="Sähköpostiosoite" width="250" type="email" density="compact"
          :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" variant="solo-filled" flat>
        </v-text-field>

        <v-text-field v-model="data.phone" label="Puhelinnumero" width="250" density="compact"
          :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" variant="solo-filled" flat>
        </v-text-field>
      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
