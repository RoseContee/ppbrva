import './bootstrap';
import Alpine from 'alpinejs';
import * as Vue from 'vue/dist/vue.esm-bundler';
import $ from 'jquery';
import select2 from 'select2';
import Datepicker from 'flowbite-datepicker/Datepicker';

window.Alpine = Alpine;
Alpine.start();

window.Vue = Vue;
window.$ = $;
select2();
window.Datepicker = Datepicker;
