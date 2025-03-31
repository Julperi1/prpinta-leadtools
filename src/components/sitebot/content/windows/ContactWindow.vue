<script setup>
import { ref, inject, watch } from 'vue';

const submitForm = inject('submitForm');
const error = ref(null);
const submitted = ref(false);
const data = ref({
  name: null,
  email: null,
  phone: null,
  message: null,
  city: null,
});

async function submit() {
  try {
    const fields = ['name', 'email', 'phone', 'city'];
    for (const key of fields) if (!validate(key)) return;

    console.log(data.value);
    const response = await submitForm(data.value, 'Sivubotti - yhteydenottopyyntö');
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

    <v-card flat rounded="lg" class="text-button d-flex align-center justify-center" @click="submit" color="primary"
      height="40" block>
      Lähetä
    </v-card>
  </v-sheet>
</template>
