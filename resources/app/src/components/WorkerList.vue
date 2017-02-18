<template>
<div class="worker-list">
    <segment :show-loader="loadingWorkerList" class="clearfix">
        <div class="ui dividing clearfix header">员工列表
            <button class="pull-right ui green tiny button" @click="activeNewWorkerDialog = true">
                <i class="icon add"></i>添加
            </button>
        </div>

        <table class="ui celled selectable table" v-if="workers.length > 0">
            <thead>
                <tr>
                    <th>名字</th>
                    <th>工种</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="worker in workers" @click="activeWorker(worker)" :class="{positive: worker.id == activedWorkerId}">
                    <td>{{ worker.name }}</td>
                    <td>{{ worker.type }}</td>

                    <td class="center aligned">
                        <button class="ui tiny circular teal icon button" @click="edit(worker)">
                            <i class="icon edit"></i>编辑
                        </button>

                        <button class="ui tiny circular red icon button" @click="remove(worker)">
                            <i class="icon remove"></i>删除
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="ui info message" v-else>
            暂无任何员工数据。
        </div>

        <pagination :total="totalWorkerPages" v-on:active="activePage" visible="10"></pagination>
    </segment>

    <el-dialog title="添加员工" v-model="activeNewWorkerDialog">
        <div class="ui worker form">
            <div class="required field">
                <label>名字</label>
                <input type="text" v-model="newWorker.name" placeholder="输入员工名字" />
            </div>

            <div class="field">
                <label>工种(选填)</label>
                <input type="text" v-model="newWorker.type" placeholder="输入员工工种" />
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button class="ui fluid green button" :class="{loading: creatingWorker}" @click="createWorker()">保存</button>
        </span>
    </el-dialog>

    <el-dialog title="编辑员工" v-model="activeEditWorkerDialog">
        <div class="ui worker form">
            <div class="required field">
                <label>名字</label>
                <input type="text" v-model="currentWorker.name" placeholder="输入员工名字" />
            </div>

            <div class="field">
                <label>工种(选填)</label>
                <input type="text" v-model="currentWorker.type" placeholder="输入员工工种" />
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <button class="ui fluid green button" :class="{loading: updatingWorker}" @click="updateWorker()">保存</button>
        </span>
    </el-dialog>
</div>
</template>

<script>
import segment from 'components/Segment';
import pagination from 'components/Pagination';

const data = () => {
    return {
        workers: [],
        currentWorkerPage: 1,
        totalWorkerPages: 1,
        loadingWorkerList: false,
        loadingJobs: false,

        activeNewWorkerDialog: false,
        creatingWorker: false,
        newWorker: {
            name: null,
            type: null,
            telephone: null
        },

        activeEditWorkerDialog: false,
        updatingWorker: false,
        currentWorker: {
            id: null,
            name: null,
            type: null,
            telephone: null
        },

        activedWorkerId: null
    }
};

const methods = {
    remove(worker) {
        this.loadingWorkerList = true;

        this.$http.post('worker/remove', {
            id: worker.id
        }).then(response => {
            if (response.data.success) {
                this.loadWorkers();
            }
        }).finally(() => {
            this.loadingWorkerList = false;
        });
    },

    createWorker() {
        this.creatingWorker = true;

        this.$http.post('worker/create', {
            ...this.newWorker
        }).then(response => {
            if (response.data.success) {
                this.resetNewWorker();
                this.loadWorkers();
            }
        }).finally(() => {
            this.creatingWorker = false;
        });
    },

    edit(worker) {
        this.activeEditWorkerDialog = true;

        this.currentWorker.id = worker.id;
        this.currentWorker.name = worker.name;
        this.currentWorker.type = worker.type;
        this.currentWorker.telephone = worker.telephone;
    },

    updateWorker() {
        this.updatingWorker = true;

        this.$http.post('worker/update', {
            ...this.currentWorker
        }).then(response => {
            if (response.data.success) {
                this.resetCurrentWorker();
                this.loadWorkers();
            }
        }).finally(() => {
            this.updatingWorker = false;
        });
    },

    activeWorker(worker) {
        this.activedWorkerId = worker.id;

        this.$emit('active', worker);
    },

    resetCurrentWorker() {
        this.activeEditWorkerDialog = false;

        this.currentWorker.id = null;
        this.currentWorker.name = null;
        this.currentWorker.type = null;
        this.currentWorker.telephone = null;
    },

    resetNewWorker() {
        this.activeNewWorkerDialog = false;

        this.newWorker.name = null;
        this.newWorker.type = null;
        this.newWorker.telephone = null;
    },

    loadWorkers() {
        this.loadingWorkerList = true;

        this.$http.get('workers', {
            params: {
                page: this.currentWorkerPage
            }
        }).then(response => {
            let res = response.data;

            if (res.data) {
                this.workers = res.data;
                this.currentWorkerPage = res.current_page;
                this.totalWorkerPages = Math.ceil(res.total/res.per_page);
            }else {
                this.workers = [];
                this.currentWorkerPage = 1;
                this.totalWorkerPages = 1;
            }
        }).finally(() => {
            this.loadingWorkerList = false;
        });
    },

    activePage(page) {
        this.currentWorkerPage = page;
        this.loadWorkers();
    },
};

const components = {
    segment,
    pagination
};

const mounted = function() {
    this.loadWorkers();
};

export default {
    name: 'workers-list',
    data,
    mounted,
    methods,
    components
};
</script>

<style lang="less">
.worker-list {
    tr {
        cursor: pointer;
    }
}

</style>
