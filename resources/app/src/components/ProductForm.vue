<script>
import extend from 'lodash/extend';

const props = [
    'value'
];

const methods = {
    update(value, field) {
        let product = this.value;
        let frmFld = {};

        frmFld[field] = value;

        this.$emit('input', extend({}, product, frmFld));
    }
};

export default {
    name: 'product-form',
    props,
    methods
};
</script>

<template>
<form class="ui product form">
    <div class="required field">
        <label>名字</label>
        <input
            type="text"
            v-bind:value="value.name"
            v-on:input="update($event.target.value, 'name')"
            placeholder="输入产品名字" />
    </div>

    <div class="required field">
        <label>价格</label>
        <input
            type="text"
            v-bind:value="value.price"
            v-on:input="update($event.target.value, 'price')"
            placeholder="输入产品单价" />
    </div>

    <div class="required field">
        <label>加工费(单件)</label>
        <input
            type="text"
            v-bind:value="value.fee"
            v-on:input="update($event.target.value, 'fee')"
            placeholder="输入加工费单价" />
    </div>

    <div class="field">
        <label>规格 (选填)</label>
        <input
            type="text"
            v-bind:value="value.model"
            v-on:input="update($event.target.value, 'model')"
            placeholder="输入产品规格" />
    </div>

    <div class="field">
        <label>库存 (选填)</label>
        <input
            type="number"
            v-bind:value="value.stock_qty"
            v-on:input="update($event.target.value, 'stock_qty')"
            placeholder="输入产品库存数量" />
    </div>

    <div class="field">
        <label>描述 (选填)</label>
        <textarea
            v-bind:value="value.description"
            v-on:input="update($event.target.value, 'description')"
            placeholder="输入产品描述"></textarea>
    </div>
</form>
</template>
