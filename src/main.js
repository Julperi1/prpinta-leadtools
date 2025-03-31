import { createApp } from 'vue';
import 'vuetify/styles';
import vuetify from '@/plugins/vuetify';

import PopupApp from '@/apps/PopupApp.vue';
import PaintCalcApp from '@/apps/PaintCalcApp.vue';
import SitebotApp from '@/apps/SitebotApp.vue';

// Create two separate Vue applications
const popupApp = createApp(PopupApp);
const paintCalcApp = createApp(PaintCalcApp);
const sitebotApp = createApp(SitebotApp);

// Use Vuetify in both applications
popupApp.use(vuetify);
paintCalcApp.use(vuetify);
sitebotApp.use(vuetify);

// Mount both applications to their respective DOM elements
popupApp.mount('#popup-app');
sitebotApp.mount('#sitebot-app');
paintCalcApp.mount('#paintcalc-app');
