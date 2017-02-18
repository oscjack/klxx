<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import productForm from 'components/ProductForm';

const data = () => {
    return {
        saving: false,

        product: {
            name: null,
            model: null,
            price: null,
            stock_qty: null,
            description: null
        }
    };
};

const methods = {
    save() {
        this.saving = true;

        let promise = this.$http.post(
            '/product/save',
            this.product
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
    productForm
};

export default {
    name: 'add-product-page',
    data,
    methods,
    components
}
</script>

<template>
<div class="add-product-page">
    <header-bar title="产品管理／添加产品">
        <div slot="actions">
            <button class="ui tiny green button" @click="save()">
                <i class="icon save"></i>保存
            </button>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="saving">
            <product-form v-model="product"></product-form>
        </segment>
    </page>
</div>
</template>
