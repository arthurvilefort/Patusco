import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import '@mdi/font/css/materialdesignicons.css'; // Importação dos ícones


const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'light', // Use 'light' para o tema padrão
        themes: {
          light: {
            dark: false,
            colors: {
              background: '#FFFFFF',
              surface: '#FFFFFF',
              primary: '#1976D2',
              secondary: '#424242',
              error: '#FF5252',
              info: '#2196F3',
              success: '#4CAF50',
              warning: '#FB8C00',
            },
          },
        },
      },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
});

export default vuetify;
