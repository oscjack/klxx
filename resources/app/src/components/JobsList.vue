<template>
<div class="jobs-list">
    <segment class="clearfix" :class="{loading: processing}">
        <div class="ui dividing clearfix header">人工费 <small style="color:#99A9BF" v-if="workerName">{{workerName}}</small>
            <button class="pull-right ui green tiny button" :class="{disabled: !workerId}" @click="activeNewJobDialog = true">
                <i class="icon add"></i>添加
            </button>
        </div>

        <el-tabs v-model="activeTab">
            <el-tab-pane label="月度" name="month-list">
                <div class="toolbar">
                    <el-radio-group v-model="month" v-on:change="changeMonth">
                        <el-radio :label="1">1月</el-radio>
                        <el-radio :label="2">2月</el-radio>
                        <el-radio :label="3">3月</el-radio>
                        <el-radio :label="4">4月</el-radio>
                        <el-radio :label="5">5月</el-radio>
                        <el-radio :label="6">6月</el-radio>
                        <el-radio :label="7">7月</el-radio>
                        <el-radio :label="8">8月</el-radio>
                        <el-radio :label="9">9月</el-radio>
                        <el-radio :label="10">10月</el-radio>
                        <el-radio :label="11">11月</el-radio>
                        <el-radio :label="12">12月</el-radio>
                    </el-radio-group>
                </div>

                <table class="ui celled selectable table" v-if="jobs.length > 0">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>产品</th>
                            <th>工费</th>
                            <th>数量</th>
                            <th>总计</th>
                            <th>操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="job in jobs">
                            <td>{{ job.job_date }}</td>
                            <td>{{ job.name }}</td>
                            <td>{{ job.fee }}元</td>
                            <td>{{ job.quantity }}</td>
                            <td>{{ job.amount }}元</td>

                            <td class="center aligned">
                                <button class="ui tiny circular teal icon button" @click="editJob(job)">
                                    <i class="icon edit"></i>编辑
                                </button>

                                <button class="ui tiny circular red icon button" @click="removeJob(job)">
                                    <i class="icon remove"></i>删除
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot class="full-width">
                         <tr>
                             <th colspan="5"></th>
                             <th>总加工费: <strong>{{ totalAmount }}元</strong></th>
                         </tr>
                    </tfoot>
                </table>

                <div class="ui info message" v-else>
                    点击左边员工获取其人工费列表
                </div>
            </el-tab-pane>

            <el-tab-pane label="年度" name="year-list">
                <table class="ui celled selectable table" v-if="summary.length > 0">
                    <thead>
                        <tr>
                            <th>月份</th>
                            <th>总计</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="item in summary">
                            <td>{{ item.month }}</td>
                            <td>{{ item.amount }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="ui info message" v-else>
                    月度人工费统计暂没处理，这块有时间再加进去。
                </div>
            </el-tab-pane>
        </el-tabs>
    </segment>

    <el-dialog title="添加人工" v-model="activeNewJobDialog">
        <div class="ui worker form">
            <div class="required field">
                <label>产品</label>

                <select v-model="newJob.productId">
                    <option value="0">选择产品</option>
                    <option v-bind:value="product.id" v-for="product of products">
                        {{ product.name }}
                    </option>
                </select>
            </div>

            <div class="required field">
                <label>数量</label>
                <input type="text" v-model="newJob.quantity" placeholder="输入数量" />
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button class="ui fluid green button" :class="{loading: addingJob}" @click="addJob()">保存</button>
        </span>
    </el-dialog>

    <el-dialog title="编辑人工" v-model="activeEditJobDialog">
        <div class="ui worker form">
            <div class="required field">
                <label>产品</label>

                <select v-model="currentJob.productId">
                    <option value="0">选择产品</option>
                    <option v-bind:value="product.id" v-for="product of products">
                        {{ product.name }}
                    </option>
                </select>
            </div>

            <div class="required field">
                <label>数量</label>
                <input type="text" v-model="currentJob.quantity" placeholder="输入数量" />
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button class="ui fluid green button" :class="{loading: editingJob}" @click="updateJob()">保存</button>
        </span>
    </el-dialog>
</div>
</template>

<script>
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const props = ['workerId', 'workerName'];

const data = () => {
    return {
        activeTab: 'month-list',
        activeNewJobDialog: false,
        activeEditJobDialog: false,

        jobs: [],
        summary: [],
        month: null,

        products: [],
        newJob: {
            productId: 0,
            quantity: 1,
            date: null
        },

        currentJob: {
            productId: 0,
            quantity: 1,
            date: null
        },

        addingJob: false,
        editingJob: false,
        processing: false
    }
};

const computed = {
    totalAmount() {
        let amount = 0;

        if (this.jobs.length) {
            for (let job of this.jobs) {
                amount += job.amount;
            }
        }

        return amount;
    }
};

const watch = {
    workerId(id) {
        if (id) {
            this.loadJobs();
        }else {
            this.jobs = [];
            this.summary = [];
        }
    }
};

const methods = {
    changeMonth() {
        if (this.workerId) {
            this.loadJobs();
        }
    },

    loadJobs() {
        this.processing = true;

        this.$http.get('jobs', {
            params: {
                month: this.month,
                workerId: this.workerId
            }
        }).then(response => {
            let res = response.data;

            if (res) {
                this.jobs = res;
            }else {
                this.jobs = [];
            }
        }).finally(() => {
            this.processing = false;
        });
    },

    addJob() {
        this.addingJob = true;

        this.$http.post('job/add', {
            ...this.newJob,
            workerId: this.workerId
        }).then(response => {
            if (response.data.success) {
                this.resetNewJob();
                this.loadJobs();
            }
        }).finally(() => {
            this.addingJob = false;
        });
    },

    removeJob(job) {
        this.processing = true;

        this.$http.post('job/remove', {
            id: job.id
        }).then(response => {
            if (response.data.success) {
                this.loadJobs();
            }
        }).finally(() => {
            this.processing = false;
        });
    },

    editJob(job) {
        this.activeEditJobDialog = true;
        this.currentJob.productId = job.product_id;
        this.currentJob.quantity = job.quantity;
        this.currentJob.date = job.job_date;
    },

    updateJob(job) {

    },

    resetEditJob() {
        this.activeEditJobDialog = false;
        this.currentJob.productId = 0;
        this.currentJob.quantity = 1;
        this.currentJob.date = null;
    },

    resetNewJob() {
        this.activeNewJobDialog = false;
        this.newJob.productId = 0;
        this.newJob.quantity = 1;
        this.newJob.date = null;
    },

    loadProducts() {
        this.$http.get('products/all').then(response => {
            this.products = response.data;
        });
    }
};

const components = {
    segment,
    pagination
};

const mounted = function() {
    this.loadProducts();

    let d = new Date();
    let month = d.getMonth();

    this.month = month + 1;
};

export default {
    name: 'jobs-list',
    props,
    data,
    computed,
    methods,
    watch,
    components,
    mounted
};
</script>

<style lang="less">
    .jobs-list {
        .toolbar {
            padding: 5px;
            font-size:12px;
        }
    }
</style>
