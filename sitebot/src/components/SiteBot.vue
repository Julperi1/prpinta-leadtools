<script setup>
import { ref, provide } from 'vue';
import BottomSheet from '@/components/BottomSheet.vue';

const minimized = ref(false);
const small = ref(true);
const full = ref(false);

function closeFull() {
  minimized.value = false;
  full.value = false;
  small.value = true;
}

function closeSmall() {
  small.value = false;
  full.value = false;
  minimized.value = true;
}

function clickSmall() {
  small.value = false;
  minimized.value = false;
  full.value = true;
}

function clickMinimized() {
  minimized.value = false;
  small.value = false;
  full.value = true;
}


// Transparent Drag Image and startY
const transparentImage = ref(null);
const startY = ref(0);

/**
 * Initialize the transparent image
 * @param event
 */
function handleDragStart(event) {
  event.dataTransfer.setDragImage(transparentImage.value, 0, 0);
  startY.value = event.clientY;
}

/**
 * Handle the drag end event
 * @param event
 */
function handleDragEnd(event) {
  const endY = event.clientY;
  if (endY < startY.value) {
    clickMinimized();
  } else {
    console.log('Item was dragged downwards');
  }
}

provide('clickSmall', clickSmall);
provide('closeFull', closeFull);
provide('closeSmall', closeSmall);
</script>

<template>
  <!-- Bottom Sheets -->
  <BottomSheet v-model="minimized" @click="clickMinimized" draggable="true" @dragstart="handleDragStart"
    @dragend="handleDragEnd">
    <v-card class="rounded-t-lg cursor-grab">
      <v-sheet rounded height="7" class="mt-2 mx-3 mb-4 bg-grey-lighten-2"></v-sheet>
    </v-card>
  </BottomSheet>

  <!-- Small Bottom Sheet -->
  <BottomSheet v-model="small" class="cursor-pointer">
    <SmallSheetContent />
  </BottomSheet>

  <!-- Full Bottom Sheet -->
  <BottomSheet v-model="full">
    <FullSheetContent />
  </BottomSheet>

  <!-- Transparent Drag Image -->
  <div ref="transparentImage" class="transparent-image"></div>
</template>

<style>
.v-bottom-sheet>.v-bottom-sheet__content.v-overlay__content {
  border-radius: 10px 10px 0 0 !important;
}
</style>
