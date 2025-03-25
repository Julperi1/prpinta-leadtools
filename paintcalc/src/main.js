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
import App from './App.vue';

// Composables
import { createApp } from 'vue';

const app = createApp(App);
app.use(vuetify);
app.mount('#app');
