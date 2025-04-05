<script setup>
import { provide } from 'vue';
import PopupContent from '@/components/popup/PopupContent.vue';

async function submitForm(payloadData, source) {
  const payload = {
    name: payloadData?.name || null,
    email: payloadData?.email || null,
    phone: payloadData?.phone || null,
    city: payloadData?.city || null,
    address: payloadData?.address || null,
    message: payloadData?.message || '',
    service: payloadData?.service || null,
    source: source,
  };

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
  <PopupContent />
</template>