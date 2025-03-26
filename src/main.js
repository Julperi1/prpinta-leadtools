/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
// import { registerPlugins } from '@/plugins'
import vuetify from '@/plugins/vuetify';
import 'vuetify/styles';

// Components
import PaintCalcApp from '@/apps/PaintCalcApp.vue';
import SitebotApp from '@/apps/SitebotApp.vue';

// Composables
import { createApp } from 'vue';

const paintCalcApp = createApp(PaintCalcApp);
paintCalcApp.use(vuetify);
paintCalcApp.mount('#paintcalc-app');

const sitebotApp = createApp(SitebotApp);
sitebotApp.use(vuetify);
sitebotApp.mount('#sitebot-app');
