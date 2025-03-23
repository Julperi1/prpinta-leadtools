<script setup>
import { ref, inject, watch } from 'vue';

const back = inject('back');
const url = import.meta.env.VITE_WEBSITE_URL;

const error = ref(null);
const data = ref({ name: null, email: null, phone: null, });

function submit() {
  if (!validateName() || !validateEmail() || !validatePhone()) {
    return;
  }

  console.log('Data:', data.value);
}

function validateName() {
  if (!data.value.name) {
    error.value = 'name';
    return false;
  } else {
    error.value = null;
  }

  return true;
}

function validateEmail() {
  if (!data.value.email) {
    error.value = 'email';
    return false;
  } else {
    error.value = null;
  }

  return true;
}

function validatePhone() {
  if (!data.value.phone) {
    error.value = 'phone';
    return false;
  } else {
    error.value = null;
  }

  return true;
}

// Validate on change
watch(data.value.name, () => {
  validateName();
});

watch(data.value.email, () => {
  validateEmail();
});

watch(data.value.phone, () => {
  validatePhone();
});
</script>

<template>
  <v-sheet class="mt-2 pb-2">
    <v-text-field v-model="data.name" label="Nimi / Yritys" density="compact" variant="outlined"
      :error-messages="error === 'name' ? ['Anna oikea arvo'] : []">
    </v-text-field>

    <v-text-field v-model="data.email" label="Sähköpostiosoite" type="email" density="compact" variant="outlined"
      :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []">
    </v-text-field>

    <v-text-field v-model="data.phone" label="Puhelinnumero" density="compact" variant="outlined"
      :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []">
    </v-text-field>

    <v-btn @click="submit" color="primary" block flat>Lähetä</v-btn>
  </v-sheet>
</template>
