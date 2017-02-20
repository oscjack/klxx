<template>
<div class="workers-management-page">
    <header-bar title="员工管理"></header-bar>

    <page>
        <div class="row">
            <div class="col-md-5">
                <worker-list v-on:active="activeWorker" v-on:reset="resetWorker"></worker-list>
            </div>

            <div class="col-md-7">
                <jobs-list :worker-id="activedWorkerId" :worker-name="activedWorkerName"></jobs-list>
            </div>
        </div>
    </page>
</div>
</template>

<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';
import workerList from 'components/WorkerList';
import jobsList from 'components/JobsList';

const components = {
    headerBar,
    page,
    segment,
    workerList,
    jobsList
};

const data = () => {
    return {
        activedWorkerId: null,
        activedWorkerName: null
    }
};

const methods = {
    activeWorker(worker) {
        this.activedWorkerId = worker.id;
        this.activedWorkerName = worker.name;
    },

    resetWorker() {
        this.activedWorkerId = null;
        this.activedWorkerName = null;
    }
};

export default {
    name: 'workers-management-page',
    data,
    methods,
    components
};
</script>
