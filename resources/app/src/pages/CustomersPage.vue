<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/page';
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        customers: [],
        currentPage: 1,
        totalPages: 1,
        loading: false
    }
};

const methods = {
    remove(customer) {
        this.loading = true;

        this.$http.post('customer/remove', {
            id: customer.id
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

        this.$http.get('customers', {params: {
                page: this.currentPage
            }
        }).then(response => {
            let res = response.data;

            this.customers = res.data;
            this.currentPage = res.current_page;
            this.totalPages = Math.ceil(res.total/res.per_page);
        }).finally(() => {
            this.loading = false;
        });
    },

    activePage(page) {
        this.currentPage = page;
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
    <header-bar title="客户管理">
        <div slot="actions">
            <router-link to="/customer/add">
                <button class="basic ui tiny green button">
                    <i class="icon add"></i>添加
                </button>
            </router-link>
        </div>
    </header-bar>

    <page>
        <segment :show-loader="loading">
            <table class="ui celled table" v-if="customers.length > 0">
                <thead>
                    <tr>
                        <th>名字</th>
                        <th>描述</th>
                        <th>电话</th>
                        <th>联系地址</th>
                        <th>邮箱地址</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="customer in customers">
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.description }}</td>
                        <td>{{ customer.telephone }}</td>
                        <td>{{ customer.address }}</td>
                        <td>{{ customer.email_address }}</td>
                        <td class="center aligned">
                            <router-link :to="{ name: 'edit-customer', params: customer}">
                                <button class="ui tiny circular green icon button">
                                    <i class="icon edit"></i>
                                </button>
                            </router-link>

                            <button class="ui tiny circular red icon button" @click="remove(customer)">
                                <i class="icon remove"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="ui info message" v-else>
                暂无任何客户数据。
            </div>

             <pagination :total="totalPages" v-on:active="activePage" visible="10"></pagination>
        </segment>
    </page>
</div>
</template>
