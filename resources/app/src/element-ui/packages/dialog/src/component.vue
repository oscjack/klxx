<template>
<transition name="dialog-fade">
    <div class="el-dialog__wrapper" v-show="visible" @click.self="handleWrapperClick">
        <div class="el-dialog" :class="[sizeClass, customClass]" ref="dialog" :style="style">
            <div class="el-dialog__header">
                <slot name="title">
                    <span class="el-dialog__title">{{title}}</span>
                </slot>
                <div class="el-dialog__headerbtn">
                    <i v-if="showClose" class="el-dialog__close el-icon el-icon-close" @click='close()'></i>
                </div>
            </div>
            <div class="el-dialog__body" v-if="rendered">
                <slot></slot>
            </div>
            <div class="el-dialog__footer" v-if="$slots.footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</transition>
</template>

<script>
import Popup from 'element-ui/src/utils/popup';

export default {
    name: 'ElDialog',

    mixins: [Popup],

    props: {
        title: {
            type: String,
            default: ''
        },

        modal: {
            type: Boolean,
            default: true
        },

        lockScroll: {
            type: Boolean,
            default: true
        },

        closeOnClickModal: {
            type: Boolean,
            default: true
        },

        closeOnPressEscape: {
            type: Boolean,
            default: true
        },

        showClose: {
            type: Boolean,
            default: true
        },

        size: {
            type: String,
            default: 'small'
        },

        customClass: {
            type: String,
            default: ''
        },

        top: {
            type: String,
            default: '15%'
        }
    },
    data() {
        return {
            visible: false
        };
    },

    watch: {
        value(val) {
            this.visible = val;
        },
        visible(val) {
            this.$emit('input', val);
            if (val) {
                this.$emit('open');
                this.$nextTick(() => {
                    this.$refs.dialog.scrollTop = 0;
                });
            } else {
                this.$emit('close');
            }
        }
    },

    computed: {
        sizeClass() {
            return `el-dialog--${ this.size }`;
        },
        style() {
            return this.size === 'full' ? {} : {
                'margin-bottom': '50px',
                'top': this.top
            };
        }
    },

    methods: {
        handleWrapperClick() {
            if (this.closeOnClickModal) {
                this.close();
            }
        }
    },

    mounted() {
        if (this.value) {
            this.rendered = true;
            this.open();
        }
    }
};
</script>

<style>
@charset "UTF-8";
.v-modal-enter {
    animation: v-modal-in .2s ease
}

.v-modal-leave {
    animation: v-modal-out .2s ease forwards
}

@keyframes v-modal-in {
    0% {
        opacity: 0
    }
}

@keyframes v-modal-out {
    100% {
        opacity: 0
    }
}

.v-modal {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: .5;
    background: #000
}

.el-dialog {
    position: absolute;
    left: 50%;
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    background: #fff;
    border-radius: 2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
    box-sizing: border-box
}

.el-dialog--tiny {
    width: 30%
}

.el-dialog--small {
    width: 50%
}

.el-dialog--large {
    width: 90%
}

.el-dialog--full {
    width: 100%;
    top: 0;
    height: 100%;
    overflow: auto
}

.el-dialog__wrapper {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    position: fixed;
    overflow: auto;
    margin: 0
}

.el-dialog__header {
    padding: 20px 20px 0
}

.el-dialog__close {
    cursor: pointer;
    color: #bfcbd9
}

.el-dialog__close:hover {
    color: #20a0ff
}

.el-dialog__title {
    line-height: 1;
    font-size: 16px;
    font-weight: 700;
    color: #1f2d3d
}

.el-dialog__body {
    padding: 30px 20px;
    color: #48576a;
    font-size: 14px
}

.el-dialog__headerbtn {
    float: right
}

.el-dialog__footer {
    padding: 10px 20px 15px;
    text-align: right;
    box-sizing: border-box
}

.dialog-fade-enter-active {
    animation: dialog-fade-in .3s
}

.dialog-fade-leave-active {
    animation: dialog-fade-out .3s
}

@keyframes dialog-fade-in {
    0% {
        transform: translate3d(0, -20px, 0);
        opacity: 0
    }
    100% {
        transform: translate3d(0, 0, 0);
        opacity: 1
    }
}

@keyframes dialog-fade-out {
    0% {
        transform: translate3d(0, 0, 0);
        opacity: 1
    }
    100% {
        transform: translate3d(0, -20px, 0);
        opacity: 0
    }
}
</style>
