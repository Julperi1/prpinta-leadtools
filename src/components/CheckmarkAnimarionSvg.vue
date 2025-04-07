<template>
    <v-sheet class="d-flex justify-center align-center">
        <!-- SVG for ring and checkmark -->
        <svg class="checkmark-svg" viewBox="0 0 60 60">
            <!-- Animated ring circle -->
            <circle class="ring" cx="30" cy="30" r="25" fill="none" />
            <!-- Checkmark path -->
            <path class="check" fill="none" d="M16,30 L26,40 L44,20" />
        </svg>
    </v-sheet>
</template>

<style scoped>
.checkmark-svg {
    width: 150px;
    height: 150px;
}

/* Style for the ring */
.ring {
    stroke: #4CAF50;
    stroke-width: 4;
    stroke-linecap: round;
    stroke-dasharray: 157;
    /* 2π*25 */
    stroke-dashoffset: 157;
    animation: ring-animation 1s ease-out forwards;
}

/* Style for the checkmark */
.check {
    stroke: #4CAF50;
    stroke-width: 4;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: check-animation .5s ease-out .7s forwards;
}

/* Keyframes for drawing the ring */
@keyframes ring-animation {
    to {
        stroke-dashoffset: 0;
    }
}

/* Keyframes for drawing the checkmark */
@keyframes check-animation {
    to {
        stroke-dashoffset: 0;
    }
}
</style>