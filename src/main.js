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
sitebotApp.mount('#sitebot-app');
paintCalcApp.mount('#paintcalc-app');

// We only need to mount the popup app when the popup has not been opened or it has been a week since the last open
const lastOpen = localStorage.getItem('popupLastOpen');
const now = new Date();
const lastOpenDate = lastOpen ? new Date(lastOpen) : null;
const oneWeekAgo = new Date(now);
oneWeekAgo.setDate(now.getDate() - 7);
if (!lastOpen || lastOpenDate < oneWeekAgo) {
    popupApp.mount('#popup-app');
}
