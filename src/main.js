import { createApp } from 'vue';
import 'vuetify/styles';
import vuetify from '@/plugins/vuetify';

import PaintCalcApp from '@/apps/PaintCalcApp.vue';
import SitebotApp from '@/apps/SitebotApp.vue';

// Create two separate Vue applications
const paintCalcApp = createApp(PaintCalcApp);
const sitebotApp = createApp(SitebotApp);

// Use Vuetify in both applications
paintCalcApp.use(vuetify);
sitebotApp.use(vuetify);

// Mount both applications to their respective DOM elements
sitebotApp.mount('#sitebot-app');
paintCalcApp.mount('#paintcalc-app');
