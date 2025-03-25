import { createVuetify } from 'vuetify';
import { VCard } from 'vuetify/components/VCard';
import { VRating } from 'vuetify/components/VRating';
import { VToolbar } from 'vuetify/components/VToolbar';

import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';
import { mdiFormatListCheckbox, mdiCalculator, mdiRefresh, mdiArrowRight, mdiCheck, mdiAccountBoxOutline, mdiClipboardOutline, mdiClose, mdiArrowLeft, mdiFormatPaint, mdiHomeRoof } from '@mdi/js';

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
      close: mdiClose,
      formatList: mdiFormatListCheckbox,
      calculator: mdiCalculator,
      accountBox: mdiAccountBoxOutline,
      clipboard: mdiClipboardOutline,
      refresh: mdiRefresh,
      arrowRight: mdiArrowRight,
      arrowLeft: mdiArrowLeft,
      check: mdiCheck,
      paint: mdiFormatPaint,
      roof: mdiHomeRoof,
    },
    sets: {
      mdi,
    },
  },
});

export default vuetify;
