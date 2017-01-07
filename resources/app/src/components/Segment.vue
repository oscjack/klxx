<script>
const props = ['showLoader'];

const methods = {
    getClass() {
        if (this.showLoader) {
            return 'loading';
        }
    }
};

export default {
    name: 'segment',
    props,
    methods
};
</script>

<template>
<div class="ui segment" :class="getClass()">
    <slot></slot>
</div>
</template>
