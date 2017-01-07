<script>
import Vue from 'vue';
import { mapMutations, mapState } from 'vuex';

import 'assets/css/lato.css';
import 'assets/css/icon.css';
import 'assets/css/dashboard.less';

import sidebar from 'components/Sidebar';
import message from 'components/Message';

const props = [
    'token',
    'admin'
];

const methods = {
    ...mapMutations([
         'setToken',
         'setAdmin',
         'setMessage'
    ]),

    setHttpClient() {
        Vue.http.interceptors.push((request, next) => {
            if (request.method == 'POST') {
                request.body._token = this.token;
            }

            next((response) => {
                let type = null;
                let text = null;

                if ( ! response.ok) {
                    type = 'error';
                    text = '服务器处理错误...';
                }else if (! response.data.success) {
                    type = 'error';
                    text = response.data.feedback;
                }else {
                    type = 'success';
                    text = response.data.feedback;
                }

                if (type && text) {
                    this.setMessage({
                        type,
                        text
                    });
                }
            });
        });
    }
};

const created = function() {
    this.setToken(this.token);
    this.setAdmin(this.admin);
    this.setHttpClient();
};

const mounted = function() {
    this.$router.push('dashboard');
};

export default {
    name: 'app',
    props,
    created,
    mounted,
    methods,
    components: {
        sidebar,
        message
    }
};
</script>

<template>
<div id="klxx-app" class="container-fluid">
    <sidebar></sidebar>

    <transition
        name="router-transition"
        mode="out-in"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut">
        <router-view keep-alived></router-view>
    </transition>

    <message></message>
</div>
</template>

<style lang="less">
#klxx-app {
    .page {
        padding: 76px 0 20px 240px;
        width: 100%;

        .content {
            padding: 2rem 30px 30px;

            .ui.segment {
                .ui.info.message {
                    margin-bottom:0;
                }
            }
        }

        .md-radio-label {
            font-size: 13px;
        }

        .md-theme-default a:not(.md-button) {
            color: #FFFFFF;
        }

        select {
            height: 40px;

            &:focus {
                outline:none;
            }
        }
    }
}
</style>
