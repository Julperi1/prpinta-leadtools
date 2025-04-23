<script setup>
import { ref, inject, watch } from 'vue';
import CheckmarkAnimarionSvg from '@/components/CheckmarkAnimarionSvg.vue';

const VITE_COMPILANCE_URL = import.meta.env.VITE_COMPILANCE_URL;
const submitForm = inject('submitForm');

const loading = ref(false);
const error = ref(null);
const submitted = ref(false);
const data = ref({
  name: null,
  email: null,
  phone: null,
  message: null,
  city: null,
  compilance: false,
});

async function submit() {
  try {
    if (loading.value) return;
    loading.value = true;
    error.value = null;
    submitted.value = false;

    const fields = ['name', 'email', 'phone', 'city', 'compilance'];
    for (const key of fields) if (!validate(key)) return;

    console.log(data.value);
    const response = await submitForm(data.value, 'Sivubotti - yhteydenottopyyntö');
    if (response) {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({
        event: 'leadtools_submit',
        source: 'Sivubotti - yhteydenottopyyntö',
      });

      submitted.value = true;
    }
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
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
  <v-sheet v-if="!submitted" class="mt-1 pb-1">
    <v-text-field v-model="data.name" label="Nimi / Yritys *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" @update:modelValue="validate('name')"
      id="prpinta-contact-name" rounded="lg">
    </v-text-field>

    <v-text-field v-model="data.email" label="Sähköpostiosoite *" type="email" density="compact" variant="solo-filled"
      flat :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-contact-email"
      @update:modelValue="validate('email')" rounded="lg">
    </v-text-field>

    <v-text-field v-model="data.phone" label="Puhelinnumero *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" @update:modelValue="validate('phone')"
      id="prpinta-contact-phone" rounded="lg">
    </v-text-field>

    <v-text-field v-model="data.city" label="Kaupunki *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'city' ? ['Anna oikea puhelnnumero'] : []" rows="4" id="prpinta-contact-city"
      rounded="lg">
    </v-text-field>

    <v-textarea v-model="data.message" auto-grow label="Mitä pyyntösi koskee?" density="compact" variant="solo-filled"
      flat rows="4" id="prpinta-contact-message" rounded="lg">
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
  <v-sheet v-else>
    <v-sheet class="d-flex justify-center align-center">
      <CheckmarkAnimarionSvg />
    </v-sheet>
    <v-card-title class="pb-0 text-center">
      Kiitos yhteydenottopyynnöstäsi!
    </v-card-title>

    <v-card-text class="text-center pt-2">
      Olemme vastaanottaneet sen ja otamme sinuun yhteyttä 24 tunnin kuluessa.
      <br />
    </v-card-text>
  </v-sheet>
</template>
