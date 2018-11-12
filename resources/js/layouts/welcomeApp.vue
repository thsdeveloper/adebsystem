<template>
    <div class="back">
        <v-app class="inspire">
            <v-content>
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                        <v-flex xs12 sm8 md4>
                            <child animate-in="bounceInRight"></child>
                            <links-navigation-welcome-app/>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</template>
<script>
    import LinksNavigationWelcomeApp from "../components/LinksNavigationWelcomeApp";
    export default {
        name: 'WelcomeApp',
        components: {LinksNavigationWelcomeApp}
    }
</script>
<style lang="scss">
    .back {
        background: linear-gradient(-135deg, #8649d6c7 0%, #2791d2b8 100%), url('/img/background_welcome_app.jpg');
        background-size: cover;
    }
    .theme--light.application {
        background: none!important;
    }
</style>
