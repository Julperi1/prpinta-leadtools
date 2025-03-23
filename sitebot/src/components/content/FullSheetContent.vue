<script setup>
import { inject, provide, ref } from 'vue';

import ContactWindow from '@/components/content/windows/ContactWindow.vue';
import ServicesWindow from '@/components/content/windows/ServicesWindow.vue';

const closeFull = inject('closeFull');
const view = ref('menu');

function back() {
  view.value = 'menu';
}

provide('back', back);
</script>
<template>
  <v-card class="rounded-t-lg" elevation="0">
    <!-- Toolbar -->
    <v-toolbar flat class="pa-1 pl-3 bg-white">
      <v-avatar rounded="lg" size="50"
        image="https://prpintakasittely.fi/wp-content/uploads/2023/07/eeee-1024x1024.jpg">
      </v-avatar>
      <v-card-title>Tähän jotain tekstiä</v-card-title>
      <v-spacer></v-spacer>
      <button @click="closeFull" class="pa-2 ma-2">
        <v-icon color="primary">mdi-close</v-icon>
      </button>
    </v-toolbar>

    <v-divider></v-divider>

    <!-- Content -->
    <v-sheet class="pa-4 overflow-y-scroll" max-height="500">
      <v-window v-model="view" direction="vertical">
        <v-window-item value="menu">
          <v-sheet class="d-flex flex-column ga-2">

            <!-- Open offer form-->
            <v-card @click="view = 'offer'" class="py-2" color="primary" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Tarjouspyyntö
                <v-icon>mdi-clipboard-outline</v-icon>
              </v-card-title>
            </v-card>

            <!-- Open contact form-->
            <v-card @click="view = 'contact'" class="py-2" color="primary" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Yhteydenottopyyntö
                <v-icon>mdi-account-box-outline</v-icon>
              </v-card-title>
            </v-card>

            <!-- Open price calculator page-->
            <v-card class="py-2" color="primary" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Maalauksen hintalaskuriin
                <v-icon>mdi-calculator</v-icon>
              </v-card-title>
            </v-card>

            <!-- Open services page-->
            <v-card @click="view = 'services'" class="py-2" color="primary" flat>
              <v-card-title class="d-flex align-center justify-space-between">
                Palvelumme
                <v-icon>mdi-format-list-checkbox </v-icon>
              </v-card-title>
            </v-card>
          </v-sheet>

        </v-window-item>

        <v-window-item value="offer">

        </v-window-item>

        <v-window-item value="contact">
          <ContactWindow />
        </v-window-item>

        <v-window-item value="services">
          <ServicesWindow />
        </v-window-item>
      </v-window>
    </v-sheet>
  </v-card>
</template>
