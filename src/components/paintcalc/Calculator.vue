<script setup>
import { ref, computed, provide, inject } from 'vue';
import { useDisplay } from 'vuetify';
import Squares from '@/components/paintcalc/pages/Squares.vue';
import Contact from '@/components/paintcalc/pages/Contact.vue';
import Floors from '@/components/paintcalc/pages/Floors.vue';
import Walls from '@/components/paintcalc/pages/Walls.vue';
import Result from '@/components/paintcalc/pages/Result.vue';

const submitForm = inject('submitForm');
const step1Component = ref(null);
const step2Component = ref(null);
const step3Component = ref(null);
const step4Component = ref(null);
const currentStep = ref(1);
const loading = ref(false);
const submitted = ref(false);

const mobile = computed(() => {
  return useDisplay().smAndDown;
});

const stepLineStyles = computed(() => {
  return {
    top: 'calc(50% - 3px)',
    zIndex: 1,
    borderImage: `linear-gradient(to right, #5a6cbe 0%, #5a6cbe
      ${(currentStep.value - 1) * 25}%, lightgrey ${(currentStep.value - 1) * 25}%, grey 100%) 1`,
  };
});

const computedPrice = computed(() => {
  const data = {
    squares: step1Component.value?.data.squares,
    floors: step2Component.value?.data.floors,
    walls: step3Component.value?.data.walls,
  };

  if (!data.squares || !data.floors || !data.walls) {
    return null;
  }

  let price = 0;

  /**
   * For squares:
   * 10 - 200: 48 € / m²
   * 201 - 500: 42 € / m²
   * 501 - 1000: 38 € / m²
   */
  if (data.squares < 200) {
    price = 48 * data.squares;
  } else if (data.squares < 500) {
    price = 42 * data.squares;
  } else {
    price = 38 * data.squares;
  }

  /**
   * For floors:
   * 1.0: price * 1
   * 1.5: price * 1.2
   * 2.0: price * 1.3
   */
  if (data.floors == '1.5') {
    price *= 1.2;
  } else if (data.floors == '2.0') {
    price *= 1.3;
  }

  /**
   * For walls:
   * 0: price * 1
   * 1-2: price * 1.2
   * 3-4: price * 1.5
   */
  if (data.walls == '1-2') {
    price *= 1.2;
  } else if (data.walls == '3-4') {
    price *= 1.5;
  }

  return parseInt(price);
});

/**
 * Calculate the needed margins for a step
 *
 * @param step step for calculation
 */
function stepMargin(step) {
  if (step == 1) {
    return mobile.value.value ? 'mr-3' : 'mr-12';
  } else if (step == 5) {
    return mobile.value.value ? 'ml-3' : 'ml-12';
  }

  return mobile.value.value ? 'mx-3' : 'mx-12';
}

/**
 * Return the color for a step
 *
 * @param step step
 */
function stepColor(step) {
  if (step == currentStep.value) {
    return step == 5 ? 'green' : 'primary';
  }

  return 'white';
}

/**
 * Try to go to the next step
 * If the current step is not valid, show an error
 *
 * @returns void
 */
function tryNextStep() {
  try {
    if (currentStep.value == 1) {
      if (!step1Component.value?.data.squares || step1Component.value?.data.squares < 10) {
        step1Component.value.error = true;
        return;
      }
    }

    if (currentStep.value == 2) {
      if (!step2Component.value?.data.floors) {
        step2Component.value.error = true;
        return;
      }
    }

    if (currentStep.value == 3) {
      if (!step3Component.value?.data.walls) {
        step3Component.value.error = true;
        return;
      }
    }

    step1Component.value.error = false;
    step2Component.value.error = false;
    step3Component.value.error = false;

    currentStep.value += 1;
  } catch (error) {
    console.log(error);
  }
}

/**
 * Submit the form and show the price
 *
 * @returns void
 */
async function submit() {
  try {
    // Set the loading state
    loading.value = true;

    // Validate the name
    if (!step4Component.value?.data.name || step4Component.value?.data.name?.length < 2) {
      step4Component.value.error = 'name';
      return;
    }

    // Validate the email
    if (!step4Component.value?.data.email || step4Component.value?.data?.email?.length < 5 ||
      !step4Component.value?.data.email.includes('.') || !step4Component.value?.data?.email.includes('@')) {
      step4Component.value.error = 'email';
      return;
    }

    // Validate the phone
    if (!step4Component.value?.data.phone || step4Component.value?.data?.phone?.length < 5) {
      step4Component.value.error = 'phone';
      return;
    }

    // Reset the error
    step4Component.value.error = null;

    // Prepare the payload
    const payload = {
      name: step4Component.value?.data.name,
      email: step4Component.value?.data.email,
      phone: step4Component.value?.data.phone,
      additionals: [
        { name: 'Pohjaneliöt', value: step1Component.value?.data.squares },
        { name: 'Kerroksien määrä', value: step2Component.value?.data.floors },
        { name: 'Huonokuntoisten seinien määrä', value: step3Component.value?.data.walls },
        { name: 'Laskurissa laskettu hinta', value: `${computedPrice.value ? parseInt(computedPrice.value * 0.8) : 'virhe'}€ - ${computedPrice.value ? parseInt(computedPrice.value * 1.2) : 'virhe'}€` },
      ],
    };

    const response = await submitForm(payload, 'Maalauslaskuri');
    if (response) {
      submitted.value = true;
    }

    // Handle the response
    if (response) {
      console.log('Success');
      console.log(response);

      currentStep.value += 1;
    }
  } catch (error) {
    console.log(error);
  } finally {
    loading.value = false;
  }
}

/**
 * Reset the calculator to the initial state
 *
 * @returns void
 */
function reset() {
  try {
    currentStep.value = 1;
    step1Component.value.error = false;
    step2Component.value.error = false;
    step3Component.value.error = false;
    step4Component.value.error = null;

    step1Component.value.data.squares = null;
    step2Component.value.data.floors = null;
    step3Component.value.data.walls = null;
    step4Component.value.data.name = null;
    step4Component.value.data.email = null;
    step4Component.value.data.phone = null;

  } catch (error) {
    console.log(error);
  }
}

provide('mobile', mobile);
provide('computedPrice', computedPrice);
</script>
<template>
  <v-sheet>
    <!-- Steps -->
    <v-sheet class="bg-grey-lighten-4 d-flex align-center justify-center">
      <v-sheet class="bg-transparent lf-steps d-flex py-2 position-relative">
        <v-card icon v-for="step in 5" :key="step" style="z-index: 2" :class="stepMargin(step)" :color="stepColor(step)"
          flat class="pa-1">
          <v-icon size="xx-large" :icon="step == 5 ? '$check' : `$numeric${step}`"> </v-icon>
        </v-card>

        <v-divider class="position-absolute opacity-90" width="100%" thickness="5" :style="stepLineStyles"></v-divider>
      </v-sheet>

    </v-sheet>

    <!-- Calculator steps pages -->
    <div>
      <Squares v-show="currentStep == 1" ref="step1Component" />
      <Floors v-show="currentStep == 2" ref="step2Component" />
      <Walls v-show="currentStep == 3" ref="step3Component" />
      <Contact v-show="currentStep == 4" ref="step4Component" />
      <Result v-show="currentStep == 5" />
    </div>


    <v-sheet class="d-flex justify-center">
      <v-card v-if="currentStep == 4" @click="submit()" :loading="loading" rounded="lg"
        :color="loading ? 'grey-darken-2' : 'green'" flat class="pa-1 px-4 text-button">
        <v-icon class="mr-2" icon="$check"></v-icon>
        Katso hinta
      </v-card>

      <v-card v-else-if="currentStep !== 5" @click="tryNextStep()" rounded="lg" color="primary" flat
        class="pa-1 px-4 text-button">
        Seuraava
        <v-icon icon="$arrowRight"></v-icon>
      </v-card>
    </v-sheet>

    <v-sheet class="mt-4 d-flex justify-center">
      <v-card v-if="currentStep !== 4" @click="reset()" rounded="lg" color="error" flat size="small" variant="text"
        class="text-button px-2">
        <v-icon icon="$refresh"></v-icon>
        Aloita alusta
      </v-card>
    </v-sheet>

    <v-sheet height="1" class="mt-4"></v-sheet>
  </v-sheet>
</template>
