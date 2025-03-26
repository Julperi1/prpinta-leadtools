<script setup>
import Calculator from '@/components/paintcalc/Calculator.vue';
</script>

<template>
  <span class="calculator-global">
    <Calculator />
  </span>
</template>
<style>
.calculator-global * {
  user-select: none !important;
}
</style>
