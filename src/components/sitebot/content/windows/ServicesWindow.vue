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
  <v-card @click="back" color="primary" class="d-flex align-center" variant="tonal" rounded="lg" height="40">
    <v-icon class="ml-2" icon="$arrowLeft"></v-icon>
    <b>Takaisin</b>
  </v-card>

  <v-sheet>
    <v-card-title class="pl-2 mt-2">
      Maalauspalvelut
      <v-icon icon="$paint"></v-icon>
    </v-card-title>

    <v-card v-for="service in paintServices" @click="open(service.link)" rounded="lg"
      class="mb-2 d-flex align-center justify-space-between px-2" height="40" flat color="primary">
      <b> {{ service.name }}</b>
      <v-icon icon="$arrowRight"></v-icon>
    </v-card>

    <v-card-title class="pb-2 pl-2">
      Kattoplavelut
      <v-icon icon="$roof"></v-icon>
    </v-card-title>

    <v-card v-for="service in roofingServices" @click="open(service.link)" rounded="lg"
      class="mb-2 d-flex align-center justify-space-between px-2" height="40" flat color="primary">
      <b> {{ service.name }}</b>
      <v-icon icon="$arrowRight"></v-icon>
    </v-card>
  </v-sheet>
</template>
