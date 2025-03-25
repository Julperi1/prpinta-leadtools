import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';
import { mdiFormatListCheckbox, mdiCalculator, mdiRefresh, mdiArrowRight, mdiCheck, mdiAccountBoxOutline, mdiClipboardOutline, mdiClose, mdiArrowLeft, mdiFormatPaint, mdiHomeRoof } from '@mdi/js';

const vuetify = createVuetify({
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
