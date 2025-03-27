<script setup>
import { ref, inject } from 'vue';

const submitForm = inject('submitForm');
const services = ref([
  'Ulkomaalaus', 'Sisämaalaus',
  'Sokkelin maalaus', 'Terassin käsittely',
  'Tiilikaton pinnoitus', 'Tiilikaton puhdistus',
  'Peltikaton maalaus', 'Muu (kirjoita viestiin)',
]);

const submitted = ref(false);
const error = ref(null);
const data = ref({
  name: null,
  email: null,
  phone: null,
  city: null,
  address: null,
  service: null,
  message: null,
});

async function submit() {
  try {
    const fields = ['name', 'email', 'phone', 'city', 'address', 'service'];
    for (const key of fields) if (!validate(key)) return;

    console.log(data.value);
    const response = await submitForm(data.value, 'Sivubotti - tarjouspyyntö');
    if (response) {
      submitted.value = true;
    }
  } catch (error) {
    console.error(error);
  }
}

function validate(key) {
  if (!data.value[key]) {
    error.value = key;
    console.log('error', key);
    return false;
  } else {
    error.value = null;
  }

  return true;
}

defineExpose({
  reset() {
    for (const key in data.value) {
      data.value[key] = null;
    }

    error.value = null;
  },
});
</script>

<template>
  <v-sheet class="mt-2 pb-2">

    <v-sheet class="d-flex">
      <v-sheet width="50%" class="pr-1">
        <v-text-field v-model="data.name" label="Nimi / Yritys *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" id="prpinta-offer-name">
        </v-text-field>
      </v-sheet>
      <v-sheet width="50%" class="pl-1">
        <v-text-field v-model="data.phone" label="Puhelinnumero *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" id="prpinta-offer-phone">
        </v-text-field>
      </v-sheet>
    </v-sheet>

    <v-text-field v-model="data.email" label="Sähköpostiosoite *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-email">
    </v-text-field>

    <v-sheet class="d-flex">
      <v-sheet width="45%" class="pr-2">
        <v-text-field v-model="data.city" label="Kaupunki *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'city' ? ['Anna oikea puhelnnumero'] : []" rows="4" id="prpinta-offer-city">
        </v-text-field>
      </v-sheet>
      <v-sheet width="55%">
        <v-text-field v-model="data.address" label="Osoite *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'address' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-address">
        </v-text-field>
      </v-sheet>
    </v-sheet>

    <v-select v-model="data.service" :items="services" label="Palvelu *" density="compact" variant="solo-filled" flat
      id="prpinta-offer-service">
    </v-select>

    <v-textarea v-model="data.message" auto-grow label="Viestisi" rows="2" density="compact" variant="solo-filled" flat
      id="prpinta-offer-message">
    </v-textarea>

    <v-btn @click="submit" color="primary" block flat>Lähetä</v-btn>
  </v-sheet>
</template>
