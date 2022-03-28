
import CountryFlag from 'vue-country-flag';
import vSelect from 'vue-select';
import IndexField from './components/IndexField.vue';
import DetailField from './components/DetailField.vue';
import FormField from './components/FormField.vue';
import Params from './params.js';
import 'vue-select/dist/vue-select.css';


Nova.booting((Vue, router) => {

    
    Vue.component('index-language-menu-switcher-nova', IndexField);
    Vue.component('detail-language-menu-switcher-nova', DetailField);
    Vue.component('form-language-menu-switcher-nova', FormField);
    Vue.component('country-flag', CountryFlag);
    Vue.component('v-select', vSelect);


    (new Params()).appendParamsToAxios();
})
