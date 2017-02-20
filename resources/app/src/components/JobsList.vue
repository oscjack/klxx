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
                    年度人工费统计暂没处理，这块有时间再加进去。
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

            <div class="required field">
                <label>日期</label>

                <div class="two fields">
                    <div class="required field">
                        <select v-model="newJob.month">
                            <option value="0">月</option>
                            <option value="1">一月</option>
                            <option value="2">二月</option>
                            <option value="3">三月</option>
                            <option value="4">四月</option>
                            <option value="5">五月</option>
                            <option value="6">六月</option>
                            <option value="7">七月</option>
                            <option value="8">八月</option>
                            <option value="9">九月</option>
                            <option value="10">十月</option>
                            <option value="11">十一月</option>
                            <option value="12">十二月</option>
                          </select>
                    </div>

                    <div class="required field">
                        <select v-model="newJob.day">
                            <option value="0">日</option>
                            <option value="1">1号</option>
                            <option value="2">2号</option>
                            <option value="3">3号</option>
                            <option value="4">4号</option>
                            <option value="5">5号</option>
                            <option value="6">6号</option>
                            <option value="7">7号</option>
                            <option value="8">8号</option>
                            <option value="9">9号</option>
                            <option value="10">10号</option>
                            <option value="11">11号</option>
                            <option value="12">12号</option>
                            <option value="13">13号</option>
                            <option value="14">14号</option>
                            <option value="15">15号</option>
                            <option value="16">16号</option>
                            <option value="17">17号</option>
                            <option value="18">18号</option>
                            <option value="19">19号</option>
                            <option value="20">20号</option>
                            <option value="21">21号</option>
                            <option value="22">22号</option>
                            <option value="23">23号</option>
                            <option value="24">24号</option>
                            <option value="25">25号</option>
                            <option value="26">26号</option>
                            <option value="27">27号</option>
                            <option value="28">28号</option>
                            <option value="29">29号</option>
                            <option value="30">30号</option>
                            <option value="31">31号</option>
                          </select>
                    </div>
                </div>
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

            <div class="required field">
                <label>日期</label>

                <div class="two fields">
                    <div class="required field">
                        <select v-model="currentJob.month">
                            <option value="0">月</option>
                            <option value="1">一月</option>
                            <option value="2">二月</option>
                            <option value="3">三月</option>
                            <option value="4">四月</option>
                            <option value="5">五月</option>
                            <option value="6">六月</option>
                            <option value="7">七月</option>
                            <option value="8">八月</option>
                            <option value="9">九月</option>
                            <option value="10">十月</option>
                            <option value="11">十一月</option>
                            <option value="12">十二月</option>
                          </select>
                    </div>

                    <div class="required field">
                        <select v-model="currentJob.day">
                            <option value="0">日</option>
                            <option value="1">1号</option>
                            <option value="2">2号</option>
                            <option value="3">3号</option>
                            <option value="4">4号</option>
                            <option value="5">5号</option>
                            <option value="6">6号</option>
                            <option value="7">7号</option>
                            <option value="8">8号</option>
                            <option value="9">9号</option>
                            <option value="10">10号</option>
                            <option value="11">11号</option>
                            <option value="12">12号</option>
                            <option value="13">13号</option>
                            <option value="14">14号</option>
                            <option value="15">15号</option>
                            <option value="16">16号</option>
                            <option value="17">17号</option>
                            <option value="18">18号</option>
                            <option value="19">19号</option>
                            <option value="20">20号</option>
                            <option value="21">21号</option>
                            <option value="22">22号</option>
                            <option value="23">23号</option>
                            <option value="24">24号</option>
                            <option value="25">25号</option>
                            <option value="26">26号</option>
                            <option value="27">27号</option>
                            <option value="28">28号</option>
                            <option value="29">29号</option>
                            <option value="30">30号</option>
                            <option value="31">31号</option>
                          </select>
                    </div>
                </div>
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
            month: null,
            day: null
        },

        currentJob: {
            id: 0,
            productId: 0,
            quantity: 1,
            month: null,
            day: null
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
            ...this.currentDate,
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
        this.currentJob.id = job.id;
        this.currentJob.productId = job.product_id;
        this.currentJob.quantity = job.quantity;

        let currentJobDate = this.getDate(job.job_date);
        this.currentJob.month = currentJobDate.month + 1;
        this.currentJob.day = currentJobDate.day;
    },

    updateJob(job) {
        this.editingJob = true;

        this.$http.post('job/update', {
            ...this.currentJob,
            workerId: this.workerId
        }).then(response => {
            if (response.data.success) {
                this.resetEditJob();
                this.loadJobs();
            }
        }).finally(() => {
            this.editingJob = false;
        });
    },

    resetEditJob() {
        this.activeEditJobDialog = false;

        this.currentJob.id = 0;
        this.currentJob.productId = 0;
        this.currentJob.quantity = 1;
        this.currentJob.month = null;
        this.currentJob.day = null;
    },

    resetNewJob() {
        this.activeNewJobDialog = false;
        this.newJob.productId = 0;
        this.newJob.quantity = 1;

        let currentDate = this.getDate();
        this.setNewJobDate(currentDate);
    },

    loadProducts() {
        this.$http.get('products/all').then(response => {
            this.products = response.data;
        });
    },

    getDate(dateString) {
        let d;

        if (dateString) {
            d = new Date(dateString);
        }else {
            d = new Date();
        }

        let month = d.getMonth();
        let day = d.getDate();

        return {
            month,
            day
        };
    },

    setNewJobDate(currentDate) {
        this.newJob.month = currentDate.month + 1;
        this.newJob.day = currentDate.day;
    }
};

const components = {
    segment,
    pagination
};

const mounted = function() {
    this.loadProducts();

    let currentDate = this.getDate();
    this.setNewJobDate(currentDate);
    this.month = currentDate.month + 1;
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
