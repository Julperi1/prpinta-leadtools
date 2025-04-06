<script setup>
import { ref, inject } from 'vue';

const VITE_COMPILANCE_URL = import.meta.env.VITE_COMPILANCE_URL;
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
  compilance: false,
});

async function submit() {
  try {
    const fields = ['name', 'email', 'phone', 'city', 'address', 'service', 'compilance'];
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
  <v-sheet class="mt-1 pb-1">

    <v-sheet class="d-flex">
      <v-sheet width="50%" class="pr-1">
        <v-text-field v-model="data.name" label="Nimi / Yritys *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" id="prpinta-offer-name" rounded="lg">
        </v-text-field>
      </v-sheet>
      <v-sheet width="50%" class="pl-1">
        <v-text-field v-model="data.phone" label="Puhelinnumero *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" id="prpinta-offer-phone" rounded="lg">
        </v-text-field>
      </v-sheet>
    </v-sheet>

    <v-text-field v-model="data.email" label="Sähköpostiosoite *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-email" rounded="lg">
    </v-text-field>

    <v-sheet class="d-flex">
      <v-sheet width="45%" class="pr-2">
        <v-text-field v-model="data.city" label="Kaupunki *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'city' ? ['Anna oikea puhelnnumero'] : []" rows="4" id="prpinta-offer-city"
          rounded="lg">
        </v-text-field>
      </v-sheet>
      <v-sheet width="55%">
        <v-text-field v-model="data.address" label="Osoite *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'address' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-address"
          rounded="lg">
        </v-text-field>
      </v-sheet>
    </v-sheet>

    <v-select v-model="data.service" :items="services" label="Palvelu *" density="compact" variant="solo-filled" flat
      id="prpinta-offer-service" rounded="lg">
    </v-select>

    <v-textarea v-model="data.message" auto-grow label="Viestisi" rows="2" density="compact" variant="solo-filled" flat
      id="prpinta-offer-message" rounded="lg">
    </v-textarea>

    <v-checkbox v-model="data.compilance" density="compact" class="ma-0 pa-0"
      :error-messages="error === 'compilance' ? ['Pakollinen valinta'] : []">
      <template v-slot:label>
        <v-card-text class="text-body-2 pa-0">
          Hyväksyn
          <a :href="VITE_COMPILANCE_URL">
            tietosuojakäytännön
          </a>
        </v-card-text>
      </template>
    </v-checkbox>

    <v-card flat rounded="lg" class="text-button d-flex align-center justify-center" @click="submit" color="primary"
      height="40" block>
      Lähetä
    </v-card>
  </v-sheet>
</template>
