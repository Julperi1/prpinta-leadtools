<script setup>
import { ref, inject } from 'vue';
const VITE_COMPILANCE_URL = import.meta.env.VITE_COMPILANCE_URL;

const mobile = inject('mobile');
const error = ref(null);
const data = ref({ name: null, email: null, phone: null, compilance: false });

defineExpose({ error, data });
</script>
<template>
  <v-sheet>
    <v-card-title class="text-center mt-4 mb-4">
      Täytä lomake niin näet <br v-if="mobile.value"> hinta-arvion heti!
    </v-card-title>
    <v-sheet class="d-flex flex-column align-center justify-center">
      <v-sheet>
        <v-text-field v-model="data.name" label="Nimi / Yritys" width="250" density="compact" rounded="lg"
          :error-messages="error === 'name' ? ['Anna oikea arvo'] : []" variant="solo-filled" flat
          id="prpinta-calc-name">
        </v-text-field>

        <v-text-field v-model="data.email" label="Sähköpostiosoite" width="250" type="email" density="compact"
          :error-messages="error === 'email' ? ['Anna oikea sähköpostiosoite'] : []" variant="solo-filled" flat
          id="prpinta-calc-email" rounded="lg">
        </v-text-field>

        <v-text-field v-model="data.phone" label="Puhelinnumero" width="250" density="compact"
          :error-messages="error === 'phone' ? ['Anna oikea puhelinnumero'] : []" variant="solo-filled" flat
          id="prpinta-calc-phone" rounded="lg">
        </v-text-field>

        <div class="d-flex flex-column align-center justify-center">
          <v-checkbox v-model="data.compilance" density="compact" class="pa-0"
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
        </div>

      </v-sheet>
    </v-sheet>
  </v-sheet>
</template>
