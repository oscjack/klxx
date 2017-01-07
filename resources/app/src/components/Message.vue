<script>
    import { mapState, mapMutations } from 'vuex';

    const computed = {
        type() {
            if (this.message) {
                return this.message.type;
            }
        },

        icon() {
            if (this.message) {
                if (this.message.type == 'success') {
                    return 'check circle outline';
                }else if (this.message.type == 'error') {
                    return 'alarm outline';
                }else {
                    return 'talk outline';
                }
            }
        },

        ...mapState([
            'message'
        ])
    };

    const methods = {
        close() {
            this.resetMessage();
        },

        ...mapMutations([
             'resetMessage'
        ])
    };

    export default {
        'name': 'message',
        computed,
        methods
    };
</script>

<template>
<transition
name="message-transition"
mode="out-in"
enter-active-class="animated fadeInUp"
leave-active-class="animated fadeOutDown">
    <div class="klxx-message" v-if="message">
        <div class="ui icon message text-center" :class="type">
            <i class="close icon" @click="close()"></i>
            <i class="icon" :class="icon"></i>
            {{ message.text }}
        </div>
    </div>
</transition>
</template>

<style lang="less">
.klxx-message {
    position: fixed;
    padding: 0 0 0 240px;
    width: 100%;
    bottom:0;
    right:0;

    .ui.message {
        border-radius: 0;
        border-left:0;
        border-right:0;
    }
}
</style>
