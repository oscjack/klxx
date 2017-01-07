<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/page';
import segment from 'components/Segment';
import customerForm from 'components/CustomerForm';

const data = () => {
    return {
        saving: false,

        customer: {
            name: null,
            description: null,
            telephone: null,
            address: null,
            email_address: null
        }
    };
};

const methods = {
    save() {
        this.saving = true;

        let promise = this.$http.post(
            '/customer/save',
            this.customer
        );

        promise.then(response => {
            if (response.data.success) {
                this.$router.go(-1);
            }
        }).finally(() => {
            this.saving = false;
        });
    }
};

const components = {
    headerBar,
    page,
    segment,
    customerForm
};

export default {
    name: 'add-customer-page',
    data,
    methods,
    components
}
</script>

<template>
<div class="add-customer-page">
    <header-bar title="客户管理／添加客户">
        <div slot="actions">
            <button class="basic ui tiny green button" @click="save()">
                <i class="icon save"></i>保存
            </button>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="saving">
            <customer-form v-model="customer"></customer-form>
        </segment>
    </page>
</div>
</template>
