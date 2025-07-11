require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import MapSearch from './components/MapSearch.vue';
import CreditSystem from './components/CreditSystem.vue';

const app = createApp({});
app.component('map-search', MapSearch);
app.component('credit-system', CreditSystem);
app.mount('#app');
