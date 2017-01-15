<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        invoices: [],
        currentPage: 1,
        totalPages: 1,
        loadingList: false,
        loadingDetail: false,

        filterCustomerId: 0,
        customers: [],
        activedCustomerId: null,

        orders: [],
        currentOrderPage: 1,
        totalOrderPages: 1,

        statuses: [
            {name: '有欠款', value: 'pending'},
            {name: '已结清', value: 'paid'}
        ],
        filterStatus: 0
    }
};

const methods = {
    loadCustomers() {
        this.$http.get('customers/all').then(response => {
            this.customers = response.data;
        });
    },

    load() {
        this.loadingList = true;

        this.$http.get('invoices', {
            params: {
                page: this.currentPage,
                customer_id: this.filterCustomerId,
                status: this.filterStatus
            }
        }).then(response => {
            let res = response.data;

            this.invoices = res.data;
            this.currentPage = res.current_page;
            this.totalPages = Math.ceil(res.total/res.per_page);
        }).finally(() => {
            this.loadingList = false;
        });
    },

    loadDetail(customerId) {
        this.loadingDetail = true;
        this.activedCustomerId = customerId;

        this.$http.get('invoice/orders', {
            params: {
                page: this.currentOrderPage,
                customer_id: customerId,
            }
        }).then(response => {
            let res = response.data;

            this.orders = res.data;
            this.currentOrderPage = res.current_page;
            this.totalOrderPages = Math.ceil(res.total/res.per_page);
        }).finally(() => {
            this.loadingDetail = false;
        });
    },

    activePage(page) {
        this.currentPage = page;
        this.load();
    },

    activeOrderPage(page) {
        this.currentOrderPage = page;
        this.loadDetail(this.activedCustomerId);
    },

    getInfoHref(customerId) {
        return '/invoice/info/' + customerId;
    },

    getStatusColor(invoice) {
        let debt = invoice.total_sales - invoice.total_paid;

        if (debt > 0) {
            return 'negative';
        }

        if (debt == 0) {
            return 'positive';
        }
    }
};

const watch = {
    filterCustomerId(){
        this.load();
    },

    filterStatus() {
        this.load();
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
    this.loadCustomers();
};

export default {
    name: 'invoices-page',
    data,
    watch,
    mounted,
    methods,
    components
};
</script>

<template>
<div class="invoice-page">
    <header-bar title="账单统计"></header-bar>

    <page>
        <div class="row">
            <div class="col-md-6">
                <segment :show-loader="loadingList" class="clearfix">
                    <div class="ui dividing header">账单列表</div>

                    <table class="ui celled table" v-if="invoices.length > 0">
                        <thead>
                            <tr>
                                <th>客户</th>
                                <th>应收</th>
                                <th>实收</th>
                                <th>欠款</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                class="invoice-item"
                                v-for="invoice in invoices"
                                :class="getStatusColor(invoice)"
                                @click="loadDetail(invoice.customer_id)">
                                <td>{{ invoice.customer }}</td>
                                <td>{{ invoice.total_sales }}元</td>
                                <td>{{ invoice.total_paid }}元</td>
                                <td>{{ invoice.total_sales - invoice.total_paid }}元</td>

                                <td class="center aligned">
                                    <a class="ui tiny blue print circular icon button" :href="getInfoHref(invoice.customer_id)" target="_blank">
                                        <i class="icon print"></i>打印
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="ui info message" v-else>
                        暂无任何账单数据。
                    </div>

                    <div class="filters">
                        <div class="row">
                            <div class="col-md-7 text-right">
                                <select v-model="filterCustomerId">
                                    <option value="0">全部客户</option>
                                    <option v-bind:value="customer.id" v-for="customer of customers">
                                        {{ customer.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5 text-right">
                                <select v-model="filterStatus">
                                    <option value="0">全部状态</option>
                                    <option v-bind:value="status.value" v-for="status of statuses">
                                        {{ status.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                     <pagination :total="totalPages" v-on:active="activePage" visible="10"></pagination>
                </segment>
            </div>

            <div class="col-md-6">
                <segment :show-loader="loadingDetail" class="clearfix">
                    <div class="ui dividing header">货单列表</div>

                    <table class="ui celled table" v-if="orders.length > 0">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>客户</th>
                                <th>金额</th>
                                <th>已付</th>
                                <th>欠款</th>
                                <th>日期</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="order in orders">
                                <td>#{{ order.id }}</td>
                                <td>{{ order.customer }}</td>
                                <td>{{ order.total }}元</td>
                                <td>{{ order.paid }}元</td>
                                <td :class="{'text-danger': order.total - order.paid > 0}">{{ order.total - order.paid}}元</td>
                                <td width="120">{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="ui info message" v-else>
                        点击左边账单行，相关的货单列表会显示在这儿。
                    </div>

                    <pagination :total="totalOrderPages" v-on:active="activeOrderPage" visible="10"></pagination>
                </segment>
            </div>
        </div>
    </page>
</div>
</template>

<style lang="less">
    #klxx-app{
        .invoice-page {
            a.print.button {
                &:hover {
                    text-decoration: none;
                }
            }

            .segment {
                position: relative;

                .filters {
                    position: absolute;
                    top:5px;
                    right:15px;
                    width: 300px;
                    height:40px;

                    .row {
                        margin-top: 5px;
                    }

                    label {
                        font-weight: bold;
                    }

                    select {
                        width: 100px;
                        height: 25px;
                    }
                }
            }

            .invoice-item {
                cursor: pointer;
            }
        }
    }
</style>
