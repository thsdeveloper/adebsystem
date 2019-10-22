<template>
    <div>
        <v-btn small to="/login">{{$t('login')}}</v-btn>
        <v-btn small to="/register">{{$t('register')}}</v-btn>
        <v-btn small to="/password/reset">Redefinir Senha</v-btn>
    </div>
</template>

<script>
    export default {
        name: "LinksNavigationWelcomeApp"
    }
</script>

<style scoped>

</style>
