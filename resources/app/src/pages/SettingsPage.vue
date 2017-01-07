<script>
import forEach from 'lodash/forEach';
import headerBar from 'components/HeaderBar';
import page from 'pages/page';
import segment from 'components/Segment';

const data = () => {
    return {
        saving: false,
        loading: false,

        settings: [],

        brandName: null,
        brandTitle: null,
        mobilePhone1: null,
        mobilePhone2: null,
        mobilePhone3: null,
        fixedPhone1: null,
        fixedPhone2: null,
        bankAccount1: {name: null, number: null},
        bankAccount2: {name: null, number: null},
        customerMessage: null,
        saledMessage: null
    };
};

const methods = {
    save() {
        this.saving = true;

        let promise = this.$http.post(
            '/setting/save',
            {
                'BRAND_NAME': this.brandName,
                'BRAND_TITLE': this.brandTitle,
                'MOBILE_PHONES': [
                    this.mobilePhone1,
                    this.mobilePhone2,
                    this.mobilePhone3
                ],
                'FIXED_PHONES': [
                    this.fixedPhone1,
                    this.fixedPhone2
                ],
                'BANK_ACCOUNTS': [
                    this.bankAccount1,
                    this.bankAccount2
                ],
                'CUSTOMER_MESSAGE': this.customerMessage,
                'SALED_MESSAGE': this.saledMessage
            }
        );

        promise.then(response => {
            if (response.data.success) {
                // this.$router.go(-1);
            }
        }).finally(() => {
            this.saving = false;
        });
    },

    load() {
        this.loading = true;

        this.$http.get('settings').then(response => {
            this.settings = response.data;

            forEach(this.settings, (item) => {
                switch (item.key) {
                    case 'BRAND_NAME':
                        this.brandName = item.value;
                        break;

                    case 'BRAND_TITLE':
                        this.brandTitle = item.value;
                        break;

                    case 'MOBILE_PHONES':
                        forEach(item.value, (phone, index) => {
                            if (index == 0) {
                                this.mobilePhone1 = phone;
                            }else if (index == 1) {
                                this.mobilePhone2 = phone;
                            }else if (index == 2) {
                                this.mobilePhone3 = phone;
                            }
                        });
                        break;

                    case 'FIXED_PHONES':
                        forEach(item.value, (phone, index) => {
                            if (index == 0) {
                                this.fixedPhone1 = phone;
                            }else if (index == 1) {
                                this.fixedPhone2 = phone;
                            }
                        });
                        break;

                    case 'BANK_ACCOUNTS':
                        forEach(item.value, (account, index) => {
                            if (index == 0) {
                                this.bankAccount1 = account;
                            }else if (index == 1) {
                                this.bankAccount2 = account;
                            }
                        });
                        break;

                    case 'CUSTOMER_MESSAGE':
                        this.customerMessage = item.value;
                        break;

                    case 'SALED_MESSAGE':
                        this.saledMessage = item.value;
                        break;

                }
            });
        }).finally(() => {
            this.loading = false;
        });
    }
};

const components = {
    headerBar,
    page,
    segment
};

const mounted = function() {
    this.load();
};

export default {
    name: 'settings-page',
    data,
    mounted,
    methods,
    components
}
</script>

<template>
<div class="settings-page">
    <header-bar title="系统设置">
        <div slot="actions">
            <button class="basic ui tiny green button" @click="save()">
                <i class="icon save"></i>保存
            </button>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="saving || loading">
            <form class="ui form">
                <div class="two fields">
                    <div class="field">
                        <label>品牌名称</label>

                        <input type="text" v-model="brandName" />
                    </div>

                    <div class="field">
                        <label>品牌描述</label>

                        <input type="text" v-model="brandTitle" />
                    </div>
                </div>

                <div class="three fields">
                    <div class="field">
                        <label>手机1</label>
                        <input type="text" v-model="mobilePhone1" />
                    </div>
                    <div class="field">
                        <label>手机2</label>
                        <input type="text" v-model="mobilePhone2" />
                    </div>
                    <div class="field">
                        <label>手机3</label>
                        <input type="text" v-model="mobilePhone3" />
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label>固话1</label>
                        <input type="text" v-model="fixedPhone1" />
                    </div>
                    <div class="field">
                        <label>固化2</label>
                        <input type="text" v-model="fixedPhone2" />
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label>{{ bankAccount1.name }}</label>
                        <input type="text" v-model="bankAccount1.number" />
                    </div>

                    <div class="field">
                        <label>{{ bankAccount2.name }}</label>
                        <input type="text" v-model="bankAccount2.number" />
                    </div>
                </div>

                <div class="field">
                    <label>祝贺语</label>

                    <textarea v-model="customerMessage"></textarea>
                </div>

                <div class="field">
                    <label>售后</label>

                    <textarea v-model="saledMessage"></textarea>
                </div>
            </form>
        </segment>
    </page>
</div>
</template>
