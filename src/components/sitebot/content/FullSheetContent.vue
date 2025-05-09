<script setup>
import { inject, provide, ref } from 'vue';

import ContactWindow from '@/components/sitebot/content/windows/ContactWindow.vue';
import ServicesWindow from '@/components/sitebot/content/windows/ServicesWindow.vue';
import OfferWindow from '@/components/sitebot/content/windows/OfferWindow.vue';

const image = inject('image');
const closeFull = inject('closeFull');
const view = ref('menu');

const offerWindow = ref(null);
const contactWindow = ref(null);
const servicesWindow = ref(null);

function back() {
  view.value = 'menu';
}

function redirectToCalc() {
  window.location.href = '/hintalaskuri';
}

function reset() {
  offerWindow.value.reset();
  contactWindow.value.reset();

  view.value = 'menu';
}

provide('back', back);
</script>
<template>
  <v-card class="rounded-t-lg" elevation="0">
    <!-- Toolbar -->
    <v-toolbar flat class="py-1 pl-3 pr-4 bg-white">
      <v-avatar rounded="lg" size="50" :image="image" />
      <v-card-title>
        <span v-if="view === 'menu'">Valitse alta</span>
        <span v-else-if="view === 'offer'">Tarjouspyyntö</span>
        <span v-else-if="view === 'contact'">Yhteydenottopyyntö</span>
        <span v-else-if="view === 'services'">Palvelumme</span>
      </v-card-title>

      <v-spacer></v-spacer>

      <button @click="reset" class="my-2">
        <v-icon :color="view === 'menu' ? 'grey-lighten-2' : 'primary'" icon="$refresh"></v-icon>
      </button>
      <button @click="closeFull" class="mx-2 my-2">
        <v-icon color="primary" icon="$close"></v-icon>
      </button>
    </v-toolbar>

    <v-sheet height="1" class="bg-grey-lighten-2"></v-sheet>

    <!-- Content -->
    <v-sheet class="pa-4 overflow-y-hidden">
      <v-window v-model="view" direction="vertical" disabled>
        <v-window-item value="menu" eager>
          <v-sheet class="d-flex flex-column ga-2">

            <!-- Open offer form-->
            <v-card @click="view = 'offer'" class="py-2" color="primary" rounded="lg" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Tarjouspyyntö
                <v-icon icon="$clipboard"></v-icon>
              </v-card-title>
            </v-card>

            <!-- Open contact form-->
            <v-card @click="view = 'contact'" class="py-2" color="primary" rounded="lg" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Yhteydenottopyyntö
                <v-icon icon="$accountBox"></v-icon>
              </v-card-title>
            </v-card>

            <!-- Open price calculator page-->
            <v-card @click="redirectToCalc" class="py-2" color="primary" rounded="lg" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Hintalaskuri
                <v-icon icon="$calculator"></v-icon>
              </v-card-title>
            </v-card>

            <!-- Open services page-->
            <v-card @click="view = 'services'" class="py-2" color="primary" rounded="lg" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Palvelumme
                <v-icon icon="$formatList"></v-icon>
              </v-card-title>
            </v-card>
          </v-sheet>

        </v-window-item>

        <v-window-item value="offer" eager>
          <OfferWindow ref="offerWindow" />
        </v-window-item>

        <v-window-item value="contact" eager>
          <ContactWindow ref="contactWindow" />
        </v-window-item>

        <v-window-item value="services" eager>
          <ServicesWindow ref="servicesWindow" />
        </v-window-item>
      </v-window>
    </v-sheet>
  </v-card>
</template>
