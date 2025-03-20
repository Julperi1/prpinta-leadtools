<script setup>
import { inject } from 'vue';

const closeFull = inject('closeFull');
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
      <button @click="closeFull" class="pa-2 ma-2 bg-grey-lighten-4 rounded-pill">
        <v-icon>mdi-close</v-icon>
      </button>
    </v-toolbar>

    <v-divider></v-divider>

    <!-- Content -->
    <v-sheet class="d-flex flex-column ga-2 pa-2 overflow-y-scroll" max-height="700">
      <v-card class="pa-12" variant="tonal">

      </v-card>

      <v-card class="pa-12" variant="tonal">

      </v-card>

      <v-card class="pa-12" variant="tonal">

      </v-card> <v-card class="pa-12" variant="tonal">

      </v-card>

      <v-card class="pa-12" variant="tonal">

      </v-card>

    </v-sheet>

  </v-card>
</template>
