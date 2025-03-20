<script setup>
import { ref, inject } from 'vue';

const mobile = inject('mobile');

const open = ref({
  minimized: true,
  small: false,
  full: false,
});

</script>

<template>
  <v-bottom-sheet v-model="open.minimized" :scrim="false" persistent no-click-animation class="mx-2 elevation-0"
    rounded="lg">
    <v-card>
      <v-sheet rounded height="5" class="mt-1 mx-2 mb-2 bg-grey-lighten-2"></v-sheet>
    </v-card>

  </v-bottom-sheet>

  <v-bottom-sheet v-model="open.small" width="300" rounded :scrim="false" persistent no-click-animation>
    <v-card>
      wqe
    </v-card>
  </v-bottom-sheet>

  <v-bottom-sheet v-model="open.full" width="300" :scrim="false" persistent no-click-animation>
    <v-card>
      wqeqweqweqwe
    </v-card>
  </v-bottom-sheet>
</template>
<style scoped>
* {
  box-shadow: none !important;
  background-color: red !important;
}
</style>
