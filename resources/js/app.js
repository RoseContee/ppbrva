import './bootstrap';
import Alpine from 'alpinejs';
import * as Vue from 'vue/dist/vue.esm-bundler';
import Chart from 'chart.js/auto';
import { DateRangePicker, Datepicker } from 'flowbite-datepicker';
import Choices from 'choices.js';

window.Alpine = Alpine;
Alpine.start();
window.Vue = Vue;
window.Chart = Chart;
window.DateRangePicker = DateRangePicker;
window.Datepicker = Datepicker;
window.Choices = Choices;
