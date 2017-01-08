<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        orders: [],
        currentPage: 1,
        totalPages: 1,
        loadingList: false,
        loadingDetail: false,

        filterCustomerId: 0,
        customers: [],

        statuses: [
            {name: '无', value: 'none'},
            {name: '待付款', value: 'pending'},
            {name: '已付款', value: 'paid'},
            {name: '发货中', value: 'sending'},
            {name: '已签收', value: 'received'}
        ],
        filterStatus: 'none'
    }
};

const methods = {
    remove(order) {
        this.loading = true;

        this.$http.post('order/remove', {
            id: order.id
        }).then(response => {
            if (response.data.success) {
                this.load();
            }
        }).finally(() => {
            this.loading = false;
        });
    },

    loadCustomers() {
        this.$http.get('customers/all').then(response => {
            this.customers = response.data;
        });
    },

    load() {
        this.loadingList = true;

        this.$http.get('orders', {
            params: {
                page: this.currentPage,
                customer_id: this.filterCustomerId,
                status: this.filterStatus
            }
        }).then(response => {
            let res = response.data;

            this.orders = res.data;
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

    statusText(status) {
        let statusText = '';

        switch (status) {
            case 'pending':
                statusText = '待付款';
                break;
            case 'paid':
                statusText = '已付款';
                break;
            case 'sending':
                statusText = '发货中';
                break;
            case 'received':
                statusText = '已签收';
                break;
        }

        return statusText;
    },

    getInfoHref(order) {
        return '/order/info/' + order.id;
    },

    getStatusColor(status) {
        let color='';

        switch (status) {
            case 'pending':
                color= 'text-danger';
                break;
            case 'paid':
                color= 'text-success';
                break;
            case 'sending':
                color = 'text-info';
                break;
            case 'received':
                color = 'text-primary';
                break;
        }

        return color;
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
    name: 'orders-page',
    data,
    watch,
    mounted,
    methods,
    components
};
</script>

<template>
<div class="orders-page">
    <header-bar title="货单管理">
        <div slot="actions">
            <router-link to="/order/add">
                <button class="basic ui tiny green button">
                    <i class="icon add"></i>添加
                </button>
            </router-link>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="loadingList" class="clearfix">
            <div class="ui dividing header">货单列表</div>

            <table class="ui celled table" v-if="orders.length > 0">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>客户</th>
                        <th>总金额</th>
                        <th>已付款</th>
                        <th>状态</th>
                        <th>日期</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="order in orders">
                        <td>#{{ order.id }}</td>
                        <td>{{ order.customer }}</td>
                        <td>{{ order.total }}元</td>
                        <td>{{ order.paid }}元</td>
                        <td :class="getStatusColor(order.status)">{{ statusText(order.status) }}</td>
                        <td>{{ order.created_at }}</td>

                        <td class="center aligned">
                            <router-link :to="{ name: 'order-products', params: order}">
                                <button class="ui tiny circular green icon button">
                                    <i class="icon list"></i>明细
                                </button>
                            </router-link>

                            <router-link :to="{ name: 'edit-order', params: order}">
                                <button class="ui tiny circular teal icon button">
                                    <i class="icon edit"></i>编辑
                                </button>
                            </router-link>

                            <button
                                class="ui tiny circular red icon button"
                                @click="remove(order)">
                                <i class="icon remove"></i>删除
                            </button>

                            <a class="ui tiny blue print circular icon button" :href="getInfoHref(order)" target="_blank">
                                <i class="icon print"></i>打印
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="ui info message" v-else>
                暂无任何货单数据。
            </div>

            <div class="filters">
                <div class="row">
                    <div class="col-md-6">
                        <label>客户: </label>

                        <select v-model="filterCustomerId">
                            <option value="0">无</option>
                            <option v-bind:value="customer.id" v-for="customer of customers">
                                {{ customer.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
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
        .orders-page {
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
                    right:0;
                    width: 600px;
                    height:40px;

                    .row {
                        margin-top: 5px;
                    }

                    label {
                        font-weight: bold;
                    }

                    select {
                        width: 80%;
                        height: 30px;
                    }
                }
            }
        }
    }
</style>
