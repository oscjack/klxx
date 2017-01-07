<script>
import extend from 'lodash/extend';

const props = [
    'value'
];

const methods = {
    update(value, field) {
        let customer = this.value;
        let frmFld = {};

        frmFld[field] = value;

        this.$emit('input', extend({}, customer, frmFld));
    }
};

export default {
    name: 'customer-form',
    props,
    methods
};
</script>

<template>
<form class="ui customer form">
    <div class="required field">
        <label>名字</label>
        <input
            type="text"
            v-bind:value="value.name"
            v-on:input="update($event.target.value, 'name')"
            placeholder="输入客户名字" />
    </div>

    <div class="required field">
        <label>电话</label>

        <input
            type="text"
            v-bind:value="value.telephone"
            v-on:input="update($event.target.value, 'telephone')"
            placeholder="输入客户电话" />
    </div>

    <div class="field">
        <label>描述 (选填)</label>
        <textarea
            v-bind:value="value.description"
            v-on:input="update($event.target.value, 'description')"
            placeholder="输入客户描述"></textarea>
    </div>

    <div class="field">
        <label>联系地址 (选填)</label>
        <input
            type="text"
            v-bind:value="value.address"
            v-on:input="update($event.target.value, 'address')"
            placeholder="输入客户联系地址" />
    </div>

    <div class="field">
        <label>邮箱地址 (选填)</label>
        <input
            type="text"
            v-bind:value="value.email_address"
            v-on:input="update($event.target.value, 'email_address')"
            placeholder="输入客户邮箱地址" />
    </div>
</form>
</template>
