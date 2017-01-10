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

        statuses: [
            {name: '全部', value: 'none'},
            {name: '有欠款', value: 'pending'},
            {name: '已结清', value: 'paid'}
        ],
        filterStatus: 'none'
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

    activePage(page) {
        this.currentPage = page;
        this.load();
    },

    getInfoHref(customerId) {
        return '/invoice/info/' + customerId;
    },

    getStatusColor(invoice) {
        let debt = nvoice.total - invoice.paid;

        if (debt > 0) {
            return 'text-danger';
        }

        if (debt == 0) {
            return 'text-success';
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
        <segment :show-loader="loadingList" class="clearfix">
            <div class="ui dividing header">账单列表</div>

            <table class="ui celled table" v-if="orders.length > 0">
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
                    <tr v-for="invoice in invoices" :class="getStatusColor(invoice)">
                        <td>{{ invoice.customer }}</td>
                        <td>{{ invoice.total }}元</td>
                        <td>{{ invoice.paid }}元</td>
                        <td>{{ invoice.total - invoice.paid }}元</td>

                        <td class="center aligned">
                            <router-link :to="{ name: 'order-products', params: order}">
                                <button class="ui tiny circular green icon button">
                                    <i class="icon list"></i>明细
                                </button>
                            </router-link>

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
                        <label>客户: </label>

                        <select v-model="filterCustomerId">
                            <option value="0">全部</option>
                            <option v-bind:value="customer.id" v-for="customer of customers">
                                {{ customer.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-5 text-right">
                        <label>状态: </label>

                        <select v-model="filterStatus">
                            <option v-bind:value="status.value" v-for="status of statuses">
                                {{ status.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

             <pagination :total="totalPages" v-on:active="activePage" visible="10"></pagination>
        </segment>
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
                    top:0;
                    right:15px;
                    width: 500px;
                    height:40px;

                    .row {
                        margin-top: 5px;
                    }

                    label {
                        font-weight: bold;
                    }

                    select {
                        width: 150px;
                        height: 30px;
                    }
                }
            }
        }
    }
</style>
