<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        products: [],
        currentPage: 1,
        totalPages: 1,
        loading: false
    }
};

const methods = {
    remove(product) {
        this.loading = true;

        this.$http.post('product/remove', {
            id: product.id
        }).then(response => {
            if (response.data.success) {
                this.load();
            }
        }).finally(() => {
            this.loading = false;
        });
    },

    load() {
        this.loading = true;

        this.$http.get('products', {params: {
                page: this.currentPage
            }
        }).then(response => {
            let res = response.data;

            this.products = res.data;
            this.currentPage = res.current_page;
            this.totalPages = Math.ceil(res.total/res.per_page);
        }).finally(() => {
            this.loading = false;
        });
    },

    activePage(page) {
        this.currentPage = page;
        this.load();
    },

    setStockState(qty) {
        if (qty < 5) {
            return 'text-danger';
        }
    }
};

const components = {
    headerBar,
    page,
    segment,
    pagination
};

const mounted = function() {
    this.load();
};

export default {
    name: 'customers-page',
    data,
    mounted,
    methods,
    components
};
</script>

<template>
<div class="customers-page">
    <header-bar title="产品管理">
        <div slot="actions">
            <router-link to="/product/add">
                <button class="basic ui tiny green button">
                    <i class="icon add"></i>添加
                </button>
            </router-link>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="loading">
            <table class="ui celled table" v-if="products.length > 0">
                <thead>
                    <tr>
                        <th>名字</th>
                        <th>价格</th>
                        <th>规格</th>
                        <th>库存</th>
                        <th>描述</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="product in products">
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}元</td>
                        <td>{{ product.model }}</td>
                        <td :class="setStockState(product.stock_qty)">{{ product.stock_qty}}</td>
                        <td>{{ product.description }}</td>

                        <td class="center aligned">
                            <router-link :to="{ name: 'edit-product', params: product}">
                                <button class="ui tiny circular green icon button">
                                    <i class="icon edit"></i>
                                </button>
                            </router-link>

                            <button class="ui tiny circular red icon button" @click="remove(product)">
                                <i class="icon remove"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="ui info message" v-else>
                暂无任何产品数据。
            </div>

             <pagination :total="totalPages" v-on:active="activePage" visible="10"></pagination>
        </segment>
    </page>
</div>
</template>
