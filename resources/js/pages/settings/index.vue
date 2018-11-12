<template>
    <div>
        <div>
            <transition name="fade" mode="out-in">
                <router-view/>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        middleware: 'auth',
        data: () => ({

        }),
        computed: {
            tabs () {
                return [
                    {
                        id: '1',
                        icon: 'user',
                        name: this.$t('profile'),
                        route: 'settings.profile'
                    },
                    {
                        id: '2',
                        icon: 'lock',
                        name: this.$t('password'),
                        route: 'settings.password'
                    }
                ]
            }
        }
    }
</script>

<style>
    .settings-card .card-body {
        padding: 0;
    }
</style>
