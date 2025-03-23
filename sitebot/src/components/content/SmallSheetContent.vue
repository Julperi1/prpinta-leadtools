<script setup>
import { inject, ref, onMounted } from 'vue';

onMounted(() => {
  setTimeout(() => {
    initNotification();
  }, 10000); // Start notification after 1s
});

const closeSmall = inject('closeSmall');
const clickSmall = inject('clickSmall');

const notification = ref(false);
const notificationData = ref({
  title: 'Maalaus suunnitelmissa?',
  subtitle: 'Hintalaskuri, yhteydenotot ja lisätietoja',
  currentTitle: '',
  currentSubtitle: '',
});

// Function to close small sheet
function clickSmallAndCloseNoti() {
  clickSmall();
  notification.value = false;
}

// Initialize notification and start letter animation
function initNotification() {
  notification.value = true;
  animateText(notificationData.value.title, 'currentTitle', 15, () => {
    animateText(notificationData.value.subtitle, 'currentSubtitle', 30);
  });
}

// Function to animate text letter by letter
function animateText(fullText, key, speed = 100, callback = null) {
  notificationData.value[key] = ''; // Reset text
  let index = 0;

  const interval = setInterval(() => {
    if (index < fullText.length) {
      notificationData.value[key] += fullText[index];
      index++;
    } else {
      clearInterval(interval);
      if (callback) callback(); // Call next animation when done
    }
  }, speed);
}
</script>

<template>
  <!-- Notification card -->
  <v-card v-show="notification" @click="clickSmallAndCloseNoti" class="rounded-bs-0 position-absolute" elevation="0"
    style="bottom:70px;left:70px">
    <v-sheet class="d-flex align-center justify-space-between bg-primary rounded-be-lg rounded-te-lg rounded-ts-lg">
      <v-card-title class="py-0 px-4 align-center justify-space-between" style="width: 270px;">
        {{ notificationData.currentTitle ? notificationData.currentTitle : 'M' }}
        <v-card-subtitle class="px-0 pb-1 text-caption">
          {{ notificationData.currentSubtitle }}
        </v-card-subtitle>
      </v-card-title>
    </v-sheet>
  </v-card>

  <!-- Small sheet content -->
  <v-card class="overflow-visible rounded-t-lg" tile elevation="0" @click="clickSmallAndCloseNoti">
    <v-sheet rounded="lg" class="position-absolute bottom-0 left-0" height="70" width="70">
      <v-avatar class="ma-1" rounded="lg" size="62"
        image="https://prpintakasittely.fi/wp-content/uploads/2023/07/eeee-1024x1024.jpg"></v-avatar>
    </v-sheet>

    <v-sheet class="d-flex align-center justify-space-between" rounded>
      <v-card-title class="ml-16 py-0 pr-0 align-center justify-space-between">
        Aloita klikkaamalla tästä!

        <v-card-subtitle class="pl-0 pb-1 text-caption">
          Yhteydenotot ja tietoja palveluistamme
        </v-card-subtitle>
      </v-card-title>

      <button class="mr-4" @click.stop="closeSmall">
        <v-icon>mdi-close</v-icon>
      </button>
    </v-sheet>
  </v-card>
</template>
