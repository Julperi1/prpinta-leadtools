<script setup>
import { computed, provide } from 'vue';
import SiteBot from '@/components/sitebot/SiteBot.vue';
import { useDisplay } from 'vuetify';

const mobile = computed(() => {
  return useDisplay().smAndDown;
});

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
  if (payloadData?.additionals && Array.isArray(payloadData.additionals)) {
    payloadData.additionals.forEach((item) => {
      payload[item.name] = item.value;
    });
  }

  try {
    const response = await fetch(solarvoima_ajax.ajax_url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        action: 'handle_vue_leads',
        security: solarvoima_ajax.nonce,
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
provide('mobile', mobile.value);
</script>
<template>
  <SiteBot />
</template>
