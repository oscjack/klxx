import Vue from 'vue';
import App from './App';

import VueResource from 'vue-resource';
import VueMaterial from 'vue-material';
import 'vue-material/dist/components/mdCore/index.css';
import 'vue-material/dist/components/mdRadio/index.css';
import 'vue-material/dist/components/mdCheckbox/index.css';

//element ui
import ElementUI from 'element-ui'
import locale from 'element-ui/src/locale/lang/en'

Vue.use(ElementUI, { locale })

import store from './store';
import router from './router';

Vue.use(VueResource);
Vue.http.options.emulateJSON = true;

Vue.use(VueMaterial.MdCore);
Vue.use(VueMaterial.MdRadio);
Vue.use(VueMaterial.MdCheckbox);

Vue.material.registerTheme('default', {
    primary: 'green',
    accent: 'red',
    warn: 'red',
});

/* eslint-disable no-new */
new Vue({
    el: '#app-mount',
    store,
    router,
    components: {
        App
    }
})
