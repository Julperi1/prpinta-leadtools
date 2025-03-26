<script setup>
import { ref, inject, watch } from 'vue';

const url = import.meta.env.VITE_WEBSITE_URL;

const error = ref(null);
const data = ref({ name: null, email: null, phone: null, message: null, city: null });

function submit() {
  if (!validate('name') || !validate('email') || !validate('phone') || !validate('message') || !validate('city')) {
    return;
  }

  console.log('Data:', data.value);
}

function validate(key) {
  if (!data.value[key]) {
    error.value = key;
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
    <v-text-field v-model="data.name" label="Nimi / Yritys *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" @update:modelValue="validate('name')">
    </v-text-field>

    <v-text-field v-model="data.email" label="Sähköpostiosoite *" type="email" density="compact" variant="solo-filled"
      flat :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []"
      @update:modelValue="validate('email')">
    </v-text-field>

    <v-text-field v-model="data.phone" label="Puhelinnumero *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" @update:modelValue="validate('phone')">
    </v-text-field>

    <v-text-field v-model="data.city" label="Kaupunki *" density="compact" variant="solo-filled" flat
      :error-messages="error === 'city' ? ['Anna oikea puhelnnumero'] : []" rows="4">
    </v-text-field>

    <v-textarea v-model="data.message" auto-grow label="Mitä pyyntösi koskee?" density="compact" variant="solo-filled"
      flat rows="4">
    </v-textarea>

    <v-btn @click="submit" color="primary" block flat>Lähetä</v-btn>
  </v-sheet>
</template>
