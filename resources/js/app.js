require('./bootstrap');
import {createApp} from 'vue'
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { TailwindPagination } from 'laravel-vue-pagination';
import CurrencyComponent from './components/CurrencyComponent.vue'

createApp(CurrencyComponent).mount("#app")