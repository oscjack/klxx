<script>
import {  mapState } from 'vuex';

const data = () => {
    return {
        menus: [
            {icon: 'home', link: '/dashboard', text: '首页', actived: false},
            {icon: 'tags', link: '/products', text: '产品', actived: false},
            {icon: 'users', link: '/customers', text: '客户', actived: false},
            {icon: 'file text', link: '/orders', text: '货单', actived: false},
            {icon: 'yen', link: '/invoices', text: '账单', actived: false},
            {icon: 'user', link: '/workers', text: '员工', actived: false},
            {icon: 'setting', link: '/settings', text: '设置', actived: false}
        ]
    };
};

const computed = {
    ...mapState({
        admin: state => state.admin,
        token: state => state.token
    })
};

const methods = {
    active(menu) {
        this.menus.forEach(function(item) {
            item.actived = false;
        });

        menu.actived = true;
    },

    getState(menu) {
        if (menu.actived) {
            return 'actived';
        }

        return '';
    }
};

export default {
    name: 'sidebar',
    data,
    computed,
    methods
};
</script>

<template>
    <div class="klxx-sidebar">
        <div class="section top">
            <div class="row flexbox">
                <div class="col-md-8">
                    <div class="logo">
                        <a href="/">
                            <img src="/static/img/logo.png" />
                        </a>
                    </div>
                </div>

                <div class="col-md-4 text-right middle aligned">
                    <form action="/logout" method="post">
                        <button type="submit">
                            <i class="sign out icon"></i>退出
                        </button>

                        <input type="hidden" name="_token" :value="token" />
                    </form>
                </div>
            </div>
        </div>

        <div class="ui divider"></div>

        <div class="section menus">
            <div class="ui middle aligned list">
                <div class="item" v-for="menu of menus" :class="getState(menu)">
                    <i class="icon" :class="menu.icon"></i>
                    <div class="content">
                        <div class="header" @click="active(menu)">
                            <router-link :to="menu.link">{{ menu.text }}</router-link>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bottom">
            <div class="ui divider"></div>

            <div class="section">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <i class="user icon"></i>
                        管理员：{{ admin }}
                    </div>

                    <div class="col-md-6 text-right middle aligned">
                        <router-link to="/password/reset">
                            <i class="edit icon"></i>修改密码
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="less">
    .klxx-sidebar {
        position:fixed;
        width: 240px;
        z-index: 999;
        top: 0;
        left: 0;
        bottom: 0;
        height: 100%;
        background-color: #31373d;
        transition: background-color 200ms ease;
        overflow: hidden;
        color:#d3dbe2;
        font-size:13px;

        i.icon {
            font-size: 16px;
        }

        .ui.list .list > .item > i.icon, .ui.list > .item > i.icon {
            padding-right:0;
        }

        .ui.list .list > .item a.header, .ui.list > .item a.header {
            color: #d3dbe2 !important;
        }

        .ui.list .list > .item a.header, .ui.list > .item {
            &:hover, &.actived {
                a.header {
                    color: #FFFFFF !important;
                }

                a {
                    color: #FFFFFF !important;
                }

                .icon {
                    color: #FFFFFF !important;
                }
            }
        }

        a {
            color:#d3dbe2 !important;

            &:hover {
                color: #FFFFFF !important;
                text-decoration: none !important;
            }
        }

        form {
            button {
                border:0;
                background:none;
                outline:none;
                padding:0;
                margin:0;

                &:hover {
                    color:#FFFFFF;
                }
            }
        }

        .section {
            padding: 10px 10px 0 10px;

            &.top {
                img {
                    max-width: 100%;
                }
            }

            &.menus {
                .item {
                    padding-left: 20px;
                    min-height: 36px;
                }
            }
        }

        .bottom {
            position:absolute;
            left:0;
            bottom:0;
            width:100%;
            .col-md-6:first-child {
                padding-right:0;
            }
            padding-bottom:20px;
        }

        .section.top {
            img {
                max-width: 100%;
            }
        }
    }
</style>
