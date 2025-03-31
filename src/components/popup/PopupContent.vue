<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const isOpen = ref(true);
let timeoutId = null;

// Timing constants
const ONE_WEEK_MS = 7 * 24 * 60 * 60 * 1000;
const DELAY_MS = 15000;

const checkPopupConditions = () => {
  const lastShown = localStorage.getItem('popupLastShown');
  const now = Date.now();

  // Check if popup was shown in the last week
  if (lastShown && (now - parseInt(lastShown)) < ONE_WEEK_MS) return;

  // Get or create scheduled time
  let scheduledTime = localStorage.getItem('popupScheduledTime');
  if (!scheduledTime) {
    scheduledTime = now + DELAY_MS;
    localStorage.setItem('popupScheduledTime', scheduledTime);
  }

  const remainingTime = scheduledTime - now;

  if (remainingTime <= 0) {
    showPopup();
  } else {
    timeoutId = setTimeout(showPopup, remainingTime);
  }
};

const showPopup = () => {
  isOpen.value = true;
  localStorage.setItem('popupLastShown', Date.now().toString());
  localStorage.removeItem('popupScheduledTime');
};

const closePopup = () => {
  isOpen.value = false;
};

const handleStorageEvent = (event) => {
  if (event.key === 'popupLastShown') {
    // Another tab has shown the popup
    clearTimeout(timeoutId);
    isOpen.value = false;
  } else if (event.key === 'popupScheduledTime') {
    // Schedule updated in another tab
    clearTimeout(timeoutId);
    checkPopupConditions();
  }
};

onMounted(() => {
  checkPopupConditions();
  window.addEventListener('storage', handleStorageEvent);
});

onUnmounted(() => {
  clearTimeout(timeoutId);
  window.removeEventListener('storage', handleStorageEvent);
});

function submit() {
  // TODO
}
</script>

<template>
  <v-dialog v-model="isOpen" max-width="500" style="user-select: none;">
    <v-card rounded="lg" class="pa-2">
      <v-card-title class="d-flex align-center justify-space-between">
        Special Offer!

        <v-sheet>
          <v-icon icon="$close" @click="closePopup"></v-icon>
        </v-sheet>
      </v-card-title>
      <v-card-text>
        Here's a weekly exclusive offer just for you!
      </v-card-text>
      <v-card @click="submit()" class="py-1 text-button text-center rounded-lg" color="primary" flat>
        Lähetä <v-icon icon="$send"></v-icon>
      </v-card>
    </v-card>
  </v-dialog>
</template>