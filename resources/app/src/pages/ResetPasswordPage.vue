<script>
import headerBar from 'components/HeaderBar';
import page from 'pages/Page';
import segment from 'components/Segment';

const data = () => {
    return {
        oldPassword: null,
        password: null,
        confirmPassword: null,
        saving: false
    }
};

const methods = {
    save() {
        this.saving = true;

        this.$http.post('/resetPassword', {
            old_password: this.oldPassword,
            password: this.password,
            confirm_password: this.confirmPassword
        }).then(response => {
            if (response.data.success) {
                this.$router.go(-1);
            }
        }).finally(() => {
            this.saving = false;
        });
    }
};

const components = {
    headerBar,
    page,
    segment
};

export default {
    name: 'reset-password-page',
    data,
    methods,
    components
}
</script>

<template>
<div class="reset-password-page">
    <header-bar title="修改管理员密码">
        <button
            slot="actions"
            class="ui tiny green button"
            @click="save()">
            <i class="icon save"></i> 保存
        </button>
    </header-bar>

    <page>
        <segment :show-loader="saving">
            <form class="ui form">
                <div class="field">
                    <label>原密码</label>
                    <input
                        type="password"
                        v-model="oldPassword"
                        placeholder="输入原密码" />
                </div>

                <div class="field">
                    <label>新密码</label>
                    <input
                        type="password"
                        v-model="password"
                        placeholder="输入新密码" />
                </div>

                <div class="field">
                    <label>确认新密码</label>
                    <input
                        type="password"
                        v-model="confirmPassword"
                        placeholder="确认新密码" />
                </div>
            </form>
        </segment>
    </page>
</div>
</template>
