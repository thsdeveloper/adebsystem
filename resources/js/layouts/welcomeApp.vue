<template>
    <div class="back">
        <v-app class="inspire">
            <v-content>
                <v-container fluid fill-height>
                    <v-layout align-center justify-center>
                        <v-flex xs12 sm8 md4>
                            <div class="white--text">
                                <img src="/img/logo_adeb.png" class="img-logo-adeb"
                                     alt="Assembleia de Deus de Brasília, ADEB" width="50px">
                                <div class="text-intro">
                                    <h1 class="font-weight-light">
                                        Bem vindo ao Adeb System 1.0
                                    </h1>
                                    <p class="subheading">
                                        Sistema de Gerenciamento Integrado da ADEB.
                                    </p>
                                </div>
                            </div>
                            <div class="white--text pr-5">
                                <p>
                                    Obtenha análises, relatórios, contatos e total interatividade dentro do nosso
                                    sistema
                                    de gestão integrado da Assembleia de Deus de Brasília.
                                </p>
                                <p>
                                    As informações armazenadas em nossa base de dados tem a total segurança e
                                    criptografia
                                    em duas pontas, ou seja, suas informações sempre estarão seguras em nosso sistema.
                                </p>
                            </div>
                            <links-navigation-welcome-app/>
                        </v-flex>
                        <v-flex xs12 sm8 md4>
                            <child animate-in="bounceInRight"></child>
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
        background: linear-gradient(-135deg, #8649d6c7 0%, #2791d2b8 100%), url('/img/fachada_adeb.jpg');
        background-size: cover;
    }

    img.img-logo-adeb.text-md-center {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .theme--light.application {
        background: none !important;
    }
</style>
