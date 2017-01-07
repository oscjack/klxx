import Vue from 'vue';
import Vuex from 'vuex';
import delay from 'lodash/delay';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        token: null,
        admin: null,
        message: null
    },

    mutations: {
        setToken: (state, token) => {
            state.token = token;
        },

        setAdmin: (state, admin) => {
            state.admin = admin;
        },

        setMessage: (state, message) => {
            state.message = message;

            delay(() => {
                state.message = null;
            }, 4000);
        },

        resetMessage: (state) => {
            state.message = null;
        }
    },

    actions: {

    },

    modules: {

    }
});

export default store
