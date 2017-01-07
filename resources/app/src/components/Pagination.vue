<script>
const props = [
    'total',
    'visible'
];

const data = () => {
    return {
        currentPage: 1
    };
};

const computed = {
    pages() {
        if (this.total == 1) {
            return false;
        }

        let result = [];
        let start;
        let end;
        let half;

        half = Math.floor(this.visible / 2);

        start = this.currentPage - half + 1 - this.visible % 2;
        end = this.currentPage + half;

        if (start <= 0) {
            start = 1;
            end = this.visible;
        }

        if (end > this.total) {
            start = this.total - this.visible + 1;

            if (start <= 0) {
                start = 1;
            }

            end = this.total;
        }

        let itPage = start;

        while (itPage <= end) {
            result.push(itPage);

            itPage++;
        }

        return result;
    }
};

const methods = {
    updatePage(page) {
        this.updateCurrentPage(page);
    },

    isActive(page) {
        if (page == this.currentPage) {
            return true;
        }

        return false;
    },

    previous() {
        this.updateCurrentPage(this.currentPage - 1);
    },

    next() {
        this.updateCurrentPage(this.currentPage + 1);
    },

    updateCurrentPage(page) {
        this.currentPage = page;

        this.$emit('active', page);
    }
};

export default {
    name: 'klxx-pagination',
    props,
    data,
    computed,
    methods
};
</script>

<template>
<div class="j-pagination clearfix" v-show="total > 1">
    <ul class="pagination pull-right">
        <li>
            <i class="icon angle left" :class="{disabled: currentPage == 1}" @click="previous"></i>
        </li>

        <li v-for="page of pages" :class="{active:isActive(page)}" @click="updatePage(page)">{{ page }}</li>

        <li>
            <i class="icon angle right" :class="{disabled: currentPage == total}" @click="next"></i>
        </li>
    </ul>
</div>
</template>

<style lang="less">
.j-pagination {
    margin-top: 15px;

    .pagination li {
        color: #444;
        display: inline-block;
        border-radius: 2px;
        text-align: center;
        vertical-align: top;
        font-size: 1rem;
        padding: 0 10px;
        height: 25px;
        line-height: 25px;
        cursor: pointer;
        &:last-child {
            padding-right: 0;

            i {
                margin-right: 0;
            }
        }
    }

    .pagination li.active {
        color: #fff;
    }

    .pagination li.active {
        background-color: #21BA45;
    }

    .pagination li.disabled {
        cursor: default;
        color: #999;
    }

    .pagination li i {
        font-size: 2rem;
    }

    .pagination li.pages ul li {
        display: inline-block;
        float: none;
    }
}
</style>
