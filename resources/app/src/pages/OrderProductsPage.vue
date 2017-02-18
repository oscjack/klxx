<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        products: [],
        loading: false,
        order: {
            id: null,
            customer: null,
            total: null,
            created_at: null
        }
    }
};

const methods = {
    load() {
        this.loading = true;

        this.$http.get('order/products', {params: {
                page: this.currentPage,
                id: this.order.id
            }
        }).then(response => {
            this.products = response.data;
        }).finally(() => {
            this.loading = false;
        });
    },

    printHref() {
        return '/order/info/' + this.order.id;
    }
};

const components = {
    headerBar,
    page,
    segment,
    pagination
};

const mounted = function() {
    this.order = {...this.$route.params};

    this.load();
};

export default {
    name: 'order-products-page',
    data,
    mounted,
    methods,
    components
};
</script>

<template>
<div class="customers-page">
    <header-bar title="货单管理／订购产品列表">
        <div slot="actions">
            <a class="ui print tiny green button" :href="printHref()" target="_blank">
                <i class="icon print"></i>打印
            </a>
        </div>
    </header-bar>

    <page>
        <div class="row">
            <div class="col-md-4">
                <segment>
                    <div class="ui small dividing header">货单信息</div>
                    <div class="ui list">
                        <div class="item">
                            <div class="header">编号</div>
                            #{{ order.id }}
                        </div>

                        <div class="item">
                            <div class="header">客户</div>
                            {{ order.customer }}
                        </div>

                        <div class="item">
                            <div class="header">总金额</div>
                            {{ order.total }}元
                        </div>

                        <div class="item">
                            <div class="header">日期</div>
                            {{ order.created_at }}
                        </div>
                    </div>
                </segment>
            </div>

            <div class="col-md-8">
                <segment :show-loader="loading">
                    <div class="ui small dividing header">订购产品</div>

                    <table class="ui celled table" v-if="products.length > 0">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>名称</th>
                                <th>规格</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th class="right aligned">金额</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="product in products">
                                <td>#{{ product.id }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.model }}</td>
                                <td>{{ product.price }}元</td>
                                <td>{{ product.qty }}</td>
                                <td class="right aligned">{{ product.qty*product.price }}元</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="6" class="right aligned">
                                    <strong>总金额:</strong>
                                    {{ order.total }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="ui error message" v-else>
                        产品数据没有找到。
                    </div>
                </segment>
            </div>
        </div>
    </page>
</div>
</template>

<style lang="less">
.customers-page {
    .print.button {
        &:hover {
            text-decoration: none;
        }
    }
}
</style>
