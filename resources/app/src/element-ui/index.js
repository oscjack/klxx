import Icon from './packages/icon';
import Message from './packages/message';
import Dialog from './packages/dialog';
import Tabs from './packages/tabs';
import TabPane from './packages/tab-pane';
import Radio from './packages/radio';
import RadioGroup from './packages/radio-group';
import RadioButton from './packages/radio-button';

import locale from 'element-ui/src/locale';

const components = [
    Icon,
    Message,
    Dialog,
    Tabs,
    TabPane,
    Radio,
    RadioGroup,
    RadioButton
];

const install = function(Vue, opts = {}) {
    /* istanbul ignore if */
    if (install.installed) return;
    locale.use(opts.locale);
    locale.i18n(opts.i18n);

    components.map(component => {
        Vue.component(component.name, component);
    });

    // Vue.use(Loading.directive);
    //
    // Vue.prototype.$loading = Loading.service;
    // Vue.prototype.$msgbox = MessageBox;
    // Vue.prototype.$alert = MessageBox.alert;
    // Vue.prototype.$confirm = MessageBox.confirm;
    // Vue.prototype.$prompt = MessageBox.prompt;
    // Vue.prototype.$notify = Notification;
    Vue.prototype.$message = Message;
    Vue.message = Message;
};

module.exports = {
    version: '1.1.6',
    locale: locale.use,
    i18n: locale.i18n,
    install
};
