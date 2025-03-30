<script setup>
import { provide } from 'vue';
import Calculator from '@/components/paintcalc/Calculator.vue';

async function submitForm(payloadData, source) {
  const payload = {
    name: payloadData?.name || null,
    email: payloadData?.email || null,
    phone: payloadData?.phone || null,
    city: payloadData?.city || null,
    address: payloadData?.address || null,
    message: payloadData?.message || null,
    service: payloadData?.service || null,
    source: source,
  };

  // Append any additional fields from the payloadData
  if (payloadData?.additionals) {
    // Add additional fields to the message
    payload.message += '\n\nLisätietoja:\n';
    payloadData.additionals?.forEach((item) => {
      // Add as new row to message
      payload.message += `${item.name}: ${item.value}\n`;
    });
  }

  try {
    const response = await fetch(prpinta_ajax.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        action: 'handle_vue_leads',
        security: prpinta_ajax.nonce,
        payload: JSON.stringify(payload),
      }),
    });

    if (response.ok) {
      return true;
    } else {
      console.error('Error:', response.statusText);
      return false;
    }
  } catch (error) {
    console.error('Error:', error);
    return false;
  }
}

provide('submitForm', submitForm);
</script>

<template>
  <span class="calculator-global">
    <Calculator />
  </span>
</template>
