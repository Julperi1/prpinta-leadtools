import { createVuetify } from 'vuetify';
import { VCard } from 'vuetify/components/VCard';
import { VRating } from 'vuetify/components/VRating';
import { VToolbar } from 'vuetify/components/VToolbar';

import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';
import { mdiNumeric1, mdiNumeric2, mdiNumeric3, mdiNumeric4, mdiNumeric5, mdiRefresh, mdiArrowRight, mdiCheck } from '@mdi/js';

const vuetify = createVuetify({
  components: {
    VCard,
    VRating,
    VToolbar,
  },
  icons: {
    defaultSet: 'mdi',
    aliases: {
      ...aliases,
      numeric1: mdiNumeric1,
      numeric2: mdiNumeric2,
      numeric3: mdiNumeric3,
      numeric4: mdiNumeric4,
      numeric5: mdiNumeric5,
      refresh: mdiRefresh,
      arrowRight: mdiArrowRight,
      check: mdiCheck,
    },
    sets: {
      mdi,
    },
  },
});

export default vuetify;
