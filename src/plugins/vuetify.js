import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';
import { mdiNumeric1, mdiNumeric2, mdiNumeric3, mdiNumeric4, mdiNumeric5, mdiRefresh, mdiArrowRight, mdiCheck, mdiFormatListCheckbox, mdiCalculator, mdiAccountBoxOutline, mdiClipboardOutline, mdiArrowLeft, mdiFormatPaint, mdiHomeRoof, mdiClose } from '@mdi/js';

const vuetify = createVuetify({
  theme: {
    defaultTheme: 'custom',
    themes: {
      custom: {
        colors: {
          primary: '#5a6cbe',
        }
      },
    },
  },
  icons: {
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
      close: mdiClose,
      formatList: mdiFormatListCheckbox,
      calculator: mdiCalculator,
      accountBox: mdiAccountBoxOutline,
      clipboard: mdiClipboardOutline,
      arrowLeft: mdiArrowLeft,
      paint: mdiFormatPaint,
      roof: mdiHomeRoof,
    },
    sets: {
      mdi,
    },
  },
});

export default vuetify;
