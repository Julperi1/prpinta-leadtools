<script setup>
import { ref, inject } from 'vue';

const back = inject('back');
const url = import.meta.env.VITE_WEBSITE_URL;

const paintServices = ref([
  { name: 'Ulkomaalaus', link: `${url}/ulkomaalaus` },
  { name: 'Sisämaalaus', link: `${url}/sisamaalaus` },
  { name: 'Sokkelin maalaus', link: `${url}/sokkelin-maalaus` },
  { name: 'Terassin käsittely', link: `${url}/terassin-kasittely` },
]);

const roofingServices = ref([
  { name: 'Tiilikaton pinnoitus', link: `${url}/tiilikaton-pinnoitus` },
  { name: 'Tiilikaton puhdistus', link: `${url}/tiilikaton-puhdistus` },
  { name: 'Peltikaton maalaus', link: `${url}/peltikaton-maalaus` },
]);

function open(link) {
  window.open(link, '_blank');
}
</script>

<template>
  <v-card @click="back" color="primary" variant="tonal">
    <v-card-text class="d-flex align-center pa-2">
      <v-icon>mdi-arrow-left</v-icon>
      <b>Takaisin</b>
    </v-card-text>
  </v-card>

  <v-sheet>
    <v-card-title class="pl-2 mt-2">
      Maalauspalvelut
      <v-icon>mdi-format-paint</v-icon>
    </v-card-title>

    <v-card v-for="service in paintServices" @click="open(service.link)" class="mb-2 " flat color="primary">
      <v-card-text class="d-flex align-center justify-space-between pa-2">
        <b> {{ service.name }}</b>
        <v-icon>mdi-arrow-right</v-icon>
      </v-card-text>
    </v-card>

    <v-card-title class="pb-0 pl-2">
      Kattoplavelut
      <v-icon>mdi-home-roof</v-icon>
    </v-card-title>

    <v-card v-for="service in roofingServices" @click="open(service.link)" class="mt-2" flat color="primary">
      <v-card-text class="d-flex align-center justify-space-between pa-2">
        <b> {{ service.name }}</b>
        <v-icon>mdi-arrow-right</v-icon>
      </v-card-text>
    </v-card>
  </v-sheet>
</template>
