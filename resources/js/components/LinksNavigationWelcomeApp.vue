<template>
    <div>
        <v-btn flat small to="/login">{{$t('login')}}</v-btn>
        <v-btn flat small to="/register">{{$t('register')}}</v-btn>
        <v-btn flat small to="/password/reset">{{$t('reset')}}</v-btn>
    </div>
</template>

<script>
    export default {
        name: "LinksNavigationWelcomeApp"
    }
</script>

<style scoped>

</style>
