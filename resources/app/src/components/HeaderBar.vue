<script>
const props = ['title'];

const methods = {
    back() {
        this.$router.go(-1);
    }
};

export default {
    name: 'header-bar',
    props,
    methods
}
</script>

<template>
    <div class="klxx-headerbar">
        <div class="content">
            <div class="row flexbox">
                <div class="col-md-8 text-left middle aligned">
                    <div class="ui header" slot="title">
                        <i class="icon tag"></i> {{ title }}
                    </div>
                </div>

                <div class="col-md-4 middle aligned text-right actions">
                    <button class="basic ui tiny button" @click="back()">
                        <i class="icon reply"></i>返回
                    </button>

                    <slot name="actions"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="less">
    .klxx-headerbar {
        position: fixed;
        left: 0;
        top:0;
        padding-left:240px;
        background:#FFFFFF;
        box-sizing: border-box;
        height: 56px;
        width: 100%;
        z-index: 198;
        box-shadow: 0 1px 0 rgba(0,0,0,0.07);
        margin-bottom: 20px;

        .content {
            padding: 0 30px;

            .row {
                height: 56px;

                .actions {
                    padding-right: 26px;

                    div {
                        display:inline-block;
                    }
                }
            }
        }
    }
</style>
