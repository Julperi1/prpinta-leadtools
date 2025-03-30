import vuetify from '@/plugins/vuetify';
import 'vuetify/styles';

import PaintCalcApp from '@/apps/PaintCalcApp.vue';
import SitebotApp from '@/apps/SitebotApp.vue';

import { createApp } from 'vue';

const paintCalcApp = createApp(PaintCalcApp);
paintCalcApp.use(vuetify);
paintCalcApp.mount('#paintcalc-app');

const sitebotApp = createApp(SitebotApp);
sitebotApp.use(vuetify);
sitebotApp.mount('#sitebot-app');
