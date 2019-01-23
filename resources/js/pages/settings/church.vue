<template>
    <div>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <v-img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/contacts_card_scene_632x224_d78913331687cc7a47fb481a0d86d4bd.png" height="125px" contain></v-img>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="display-1">Dados e personalização da igreja</p>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="subheading">Configurações recomendadas para ajudar você a manter todass as informações da igreja atualizadas</p>
        </v-flex>
        <v-layout row wrap>
            <v-flex xs12 sm12 md6 d-flex child-flex>
                <v-card>
                    <v-layout row>
                        <v-flex xs7>
                            <v-card-title primary-title>
                                <div>
                                    <div class="headline">Funções administrativas</div>
                                    <div>A Verificação de funções fornece recomendações personalizadas para cada tipo de usuário no sistema</div>
                                </div>
                            </v-card-title>
                        </v-flex>
                        <v-flex align-self-center>
                            <v-img src="/img/icones/funcoes_administrativas.svg" height="125px" contain></v-img>
                        </v-flex>
                    </v-layout>
                    <v-divider light></v-divider>
                    <v-card-actions class="pa-3">

                        <v-dialog v-model="dialog" width="500">
                            <v-btn slot="activator" flat>{{ $t('update') }}</v-btn>
                            <v-card>
                                <v-card-title class="headline grey lighten-2" primary-title>Funções administrativas</v-card-title>
                                <v-card-text>
                                    <v-list
                                            subheader
                                            three-line
                                    >
                                        <v-subheader>General</v-subheader>
                                        <v-list-tile @click="">
                                            <v-list-tile-action>
                                                <v-checkbox
                                                        v-model="notifications"
                                                ></v-checkbox>
                                            </v-list-tile-action>

                                            <v-list-tile-content @click.prevent="notifications = !notifications">
                                                <v-list-tile-title>Notifications</v-list-tile-title>
                                                <v-list-tile-sub-title>Notify me about updates to apps or games that I downloaded</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>

                                        <v-list-tile @click="">
                                            <v-list-tile-action>
                                                <v-checkbox
                                                        v-model="sound"
                                                ></v-checkbox>
                                            </v-list-tile-action>

                                            <v-list-tile-content @click.prevent="sound = !sound">
                                                <v-list-tile-title>Sound</v-list-tile-title>
                                                <v-list-tile-sub-title>Auto-update apps at any time. Data charges may apply</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>

                                        <v-list-tile @click="">
                                            <v-list-tile-action>
                                                <v-checkbox
                                                        v-model="widgets"
                                                ></v-checkbox>
                                            </v-list-tile-action>

                                            <v-list-tile-content @click.prevent="widgets = !widgets">
                                                <v-list-tile-title>Auto-add widgets</v-list-tile-title>
                                                <v-list-tile-sub-title>Automatically add home screen widgets</v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </v-list>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" flat @click="dialog = false">I accept
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "church"
    }
</script>

<style scoped>

</style>
