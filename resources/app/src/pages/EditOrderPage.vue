<script>
import findIndex from 'lodash/findIndex';
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        saving: false,

        order: {
            id: null,
            customer_id: null,
            paid: 0,
            description: null,
            status: null
        },

        orderProducts: [],

        currentProductPage: 1,
        loadingProducts: false,
        totalProductPages: null,
        products: [],

        customers: []
    };
};

const methods = {
    save() {
        this.saving = true;

        let promise = this.$http.post(
            '/order/save',
            {
                id: this.order.id,
                customer_id: this.order.customer_id,
                paid: this.order.paid,
                status: this.order.status,
                description: this.order.description,
                products: this.orderProducts
            }
        );

        promise.then(response => {
            if (response.data.success) {
                this.$router.go(-1);
            }
        }).finally(() => {
            this.saving = false;
        });
    },

    loadCustomers() {
        this.$http.get('customers/all').then(response => {
            this.customers = response.data;

            this.order = {...this.$route.params};

            this.loadOrderProducts();
        });
    },

    loadProducts() {
        this.loadingProducts = true;

        this.$http.get('products', {
            params: {
                page: this.currentProductPage
            }
        }).then(response => {
            let res = response.data;

            this.products = res.data;
            this.currentProductPage = res.current_page;
            this.totalProductPages = Math.ceil(res.total/res.per_page);
        }).finally(() => {
            this.loadingProducts = false;
        });
    },

    loadOrderProducts() {
        this.$http.get('order/products', {
            params: {
                id: this.order.id
            }
        }).then(response => {
            this.orderProducts = response.data;
        });
    },

    getAmount(product) {
        return product.qty * product.price;
    },

    removeOrderProduct(product) {
        let foundedIndex = findIndex(this.orderProducts, function(p) {
            return p.id == product.id;
        });

        if (foundedIndex !== -1) {
            this.orderProducts.splice(foundedIndex, 1);
        }
    },

    isAddedProduct(product) {
        let foundedIndex = findIndex(this.orderProducts, function(p) {
            return p.id == product.id;
        });

        if (foundedIndex == -1) {
            return false;
        }

        return true;
    },

    setStockState(qty) {
        if (qty < 5) {
            return 'text-danger';
        }
    },

    addProduct(product) {
        if ( ! this.isAddedProduct(product)) {
            this.$set(product, 'qty', 1);

            this.orderProducts.push(product);
        }
    },

    activeProductPage(page) {
        this.currentProductPage = page;

        this.loadProducts();
    }
};

const mounted = function() {
    this.loadCustomers();

    this.loadProducts();
};

const components = {
    headerBar,
    page,
    segment,
    pagination
};

export default {
    name: 'edit-order-page',
    data,
    methods,
    mounted,
    components
}
</script>

<template>
<div class="add-customer-page">
    <header-bar title="货单管理／编辑货单">
        <div slot="actions">
            <button class="basic ui tiny green button" @click="save()">
                <i class="icon save"></i>保存
            </button>
        </div>
    </header-bar>

    <page>
        <div class="order-form row">
            <div class="ui order form">
                <div class="col-md-6">
                    <segment :show-loader="saving">
                        <div class="ui dividing small header">货单信息</div>

                        <div class="required field">
                            <label>状态</label>

                            <div class="status">
                                <md-radio
                                    v-model="order.status"
                                    md-value="pending"
                                    class="md-primary">
                                    待付款
                                </md-radio>
                                <md-radio
                                    v-model="order.status"
                                    md-value="paid"
                                    class="md-primary">
                                    已付款
                                </md-radio>
                                <md-radio
                                    v-model="order.status"
                                    md-value="sending"
                                    class="md-primary">
                                    发货中
                                </md-radio>
                                <md-radio
                                    v-model="order.status"
                                    md-value="received"
                                    class="md-primary">
                                    已签收
                                </md-radio>
                            </div>
                        </div>

                        <div class="required field">
                            <label>客户</label>

                            <select v-model="order.customer_id">
                                <option v-bind:value="customer.id" v-for="customer of customers">
                                    {{ customer.name }}
                                </option>
                            </select>
                        </div>

                        <div class="required field">
                            <label>已付款数额</label>

                            <input type="text" v-model="order.paid" />
                        </div>

                        <div class="field">
                            <label>备注(选填)</label>

                            <textarea v-model="order.description"></textarea>
                        </div>

                        <div class="order-products" v-if="orderProducts.length > 0">
                            <div class="ui tiny dividing header">产品</div>

                            <table class="ui celled table" >
                                <thead>
                                    <tr>
                                        <th>名称</th>
                                        <th>规格</th>
                                        <th>单价</th>
                                        <th>数量</th>
                                        <th>金额</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="orderProduct in orderProducts">
                                        <td>{{ orderProduct.name }}</td>
                                        <td>{{ orderProduct.model }}</td>
                                        <td>{{ orderProduct.price }}元</td>
                                        <td class="product-qty text-center">
                                            <input type="text" v-model="orderProduct.qty" />
                                        </td>
                                        <td class="product-amount">{{ getAmount(orderProduct) }}元</td>
                                        <td class="center aligned">
                                            <button
                                                class="ui tiny circular red icon button"
                                                @click="removeOrderProduct(orderProduct)">
                                                <i class="icon remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </segment>
                </div>

                <div class="col-md-6">
                    <segment :show-loader="loadingProducts">
                        <div class="ui small dividing header">选择产品</div>

                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th>名字</th>
                                    <th>价格</th>
                                    <th>规格</th>
                                    <th>库存</th>
                                    <th>操作</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="product in products" :class="{positive: isAddedProduct(product)}">
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.price }}元</td>
                                    <td>{{ product.model }}</td>
                                    <td
                                        v-if="product.stock_qty"
                                        :class="setStockState(product.stock_qty)">
                                        {{ product.stock_qty}}件
                                    </td>
                                    <td v-else></td>
                                    <td class="center aligned">
                                        <button
                                            class="ui tiny circular green icon button"
                                            :class="{disabled: isAddedProduct(product)}"
                                            @click="addProduct(product)">
                                            <i class="icon add"></i>添加到货单
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :total="totalProductPages" v-on:active="activeProductPage" visible="10"></pagination>
                    </segment>
                </div>
            </div>
        </div>
    </page>
</div>
</template>

<style lang="less">
    .order-form {
        .order-customer,
        .order-products {
            margin-top: 15px;
        }

        .choose-customer {
            .md-radio {
                margin: 0;
            }
        }

        .product-qty {
            width: 80px;
        }

        .product-amount {
            width: 80px;
        }
    }
</style>
