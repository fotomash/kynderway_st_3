require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import MapSearch from './components/MapSearch.vue';
import VacationCareSearch from './components/VacationCareSearch.vue';

const app = createApp({});
app.component('map-search', MapSearch);
app.component('vacation-care-search', VacationCareSearch);
app.mount('#app');
