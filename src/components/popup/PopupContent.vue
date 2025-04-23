<script setup>
import { ref, onMounted, inject } from 'vue';
const VITE_COMPILANCE_URL = import.meta.env.VITE_COMPILANCE_URL;
import CheckmarkAnimarionSvg from '@/components/CheckmarkAnimarionSvg.vue';

onMounted(() => {
  setTimeout(() => {
    const now = new Date();
    localStorage.setItem('popupLastOpen', now.toISOString());
    isOpen.value = true;
  }, 5000);
});

const isOpen = ref(false);
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
    const response = await submitForm(data.value, 'Popup');
    if (response) {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({
        event: 'leadtools_submit',
        source: 'Popup',
      });

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

function close() {
  for (const key in data.value) {
    data.value[key] = null;
  }

  error.value = null;
  isOpen.value = false;
}
</script>

<template>
  <v-dialog v-model="isOpen" max-width="500">
    <v-card rounded="lg" class="pa-2 lf-backgroung">
      <v-card-title class="d-flex align-center justify-space-between pa-2">
        <b class=""> Projekti suunnitteilla?</b>

        <v-sheet class="bg-transparent">
          <v-icon icon="$close" @click="close"></v-icon>
        </v-sheet>
      </v-card-title>

      <v-sheet class="mb-2 mx-2 bg-transparent">
        Saat meiltä talon maalauksen <b class="text-primary">maalien hinnasta 50% alennusta</b> kun kysyt tarjouksen
        31.4 mennessä!
        Jätä tarjouspyyntö tästä, ja hyödynnä tarjous! Tarjouspyyntö ei sido sinua mihinkään.
      </v-sheet>

      <!-- Form fields -->
      <v-sheet v-if="!submitted" class="mt-2 pa-2 bg-transparent">
        <v-sheet class="d-flex bg-transparent">
          <v-sheet width="50%" class="pr-1 bg-transparent">
            <v-text-field v-model="data.name" label="Nimi / Yritys *" density="compact" variant="solo-filled" flat
              :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" id="prpinta-offer-name" rounded="lg">
            </v-text-field>
          </v-sheet>
          <v-sheet width="50%" class="pl-1 bg-transparent">
            <v-text-field v-model="data.phone" label="Puhelinnumero *" density="compact" variant="solo-filled" flat
              :error-messages="error === 'phone' ? ['Anna oikea puhelnnumero'] : []" id="prpinta-offer-phone"
              rounded="lg">
            </v-text-field>
          </v-sheet>
        </v-sheet>

        <v-text-field v-model="data.email" label="Sähköpostiosoite *" density="compact" variant="solo-filled" flat
          :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-email"
          rounded="lg">
        </v-text-field>

        <v-sheet class="d-flex bg-transparent">
          <v-sheet width="45%" class="pr-2 bg-transparent">
            <v-text-field v-model="data.city" label="Kaupunki *" density="compact" variant="solo-filled" flat
              :error-messages="error === 'city' ? ['Anna oikea puhelnnumero'] : []" rows="4" id="prpinta-offer-city"
              rounded="lg">
            </v-text-field>
          </v-sheet>
          <v-sheet width="55%" class="bg-transparent">
            <v-text-field v-model="data.address" label="Osoite *" density="compact" variant="solo-filled" flat
              :error-messages="error === 'address' ? ['Anna oikea sähköpostiosoite'] : []" id="prpinta-offer-address"
              rounded="lg">
            </v-text-field>
          </v-sheet>
        </v-sheet>

        <v-select v-model="data.service" :items="services" label="Palvelu *" density="compact" variant="solo-filled"
          flat id="prpinta-offer-service" rounded="lg">
        </v-select>

        <v-textarea v-model="data.message" auto-grow label="Viestisi" rows="2" density="compact" variant="solo-filled"
          flat id="prpinta-offer-message" rounded="lg">
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
      <v-sheet v-else class="my-2">
        <v-divider class="mb-6"></v-divider>
        <v-sheet class="d-flex justify-center align-center">
          <CheckmarkAnimarionSvg />
        </v-sheet>
        <v-card-title class="pb-0 text-center">
          Kiitos tarjouspyynnöstä!
        </v-card-title>

        <v-card-text class="text-center pt-2">
          Olemme vastaanottaneet sen ja otamme sinuun yhteyttä 24 tunnin kuluessa.
          <br />
        </v-card-text>
      </v-sheet>

    </v-card>
  </v-dialog>
</template>

<style>
.lf-backgroung {
  background-color: #FFFFFF;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cpolygon fill='%235A6CBE' fill-opacity='0.02' points='120 120 60 120 90 90 120 60 120 0 120 0 60 60 0 0 0 60 30 90 60 120 120 120 '/%3E%3C/svg%3E");
}
</style>