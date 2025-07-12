require('./bootstrap');
require('alpinejs');

import { createApp } from 'vue';
import MapSearch from './components/MapSearch.vue';

const app = createApp({});
app.component('map-search', MapSearch);
app.mount('#app');
