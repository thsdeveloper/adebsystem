<template>
    <div>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <v-img src="https://www.gstatic.com/identity/boq/accountsettingsmobile/contacts_card_scene_632x224_d78913331687cc7a47fb481a0d86d4bd.png"
                   height="125px" contain></v-img>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="display-1">Assembleia de Deus de Brasília - ADEB</p>
        </v-flex>
        <v-flex xs12 sm12 md12 align-center justify-center layout text-xs-center>
            <p class="subheading">Configurações recomendadas para ajudar você a manter todas as informações pernitentes
                ao ministério ADEB atualizadas.</p>
        </v-flex>
        <v-layout row wrap>
            <v-flex xs12 sm12 md6 d-flex child-flex>
                <v-card>
                    <v-layout row>
                        <v-flex xs7>
                            <v-card-title primary-title>
                                <div>
                                    <div class="headline">Atualizar informações</div>
                                    <div>Aqui você pode atualizar as principais informações sobre a ADEB - SEDE.</div>
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
                            <v-btn slot="activator" flat>Atualizar informações da SEDE</v-btn>
                            <v-card>
                                <v-card-title class="headline grey lighten-2" primary-title>Funções administrativas
                                </v-card-title>
                                <v-card-text>
                                    <v-list subheader three-line>
                                        <!--<v-subheader>Pr. Presidente do Ministério</v-subheader>-->
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Pr. Presidente do Ministério" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione a cidade do usuário"
                                                            no-data-text="Não encontramos a cidade!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                    <v-list subheader three-line>
                                        <!--<v-subheader>Pr. 1º Vice Presidente</v-subheader>-->
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Pr. 1º Vice Presidente" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione a cidade do usuário"
                                                            no-data-text="Não encontramos a cidade!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                    <v-list subheader three-line>
                                        <!--<v-subheader>Pr. 2º Vice Presidente</v-subheader>-->
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Pr. 2º Vice Presidente" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione a cidade do usuário"
                                                            no-data-text="Não encontramos a cidade!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                    <v-list subheader three-line>
                                        <!--<v-subheader>Pr. 2º Vice Presidente</v-subheader>-->
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Pr. 3º Vice Presidente" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione a cidade do usuário"
                                                            no-data-text="Não encontramos a cidade!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                    <v-list subheader three-line>
                                        <!--<v-subheader>Pr. 2º Vice Presidente</v-subheader>-->
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Pr. 4º Vice Presidente" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione a cidade do usuário"
                                                            no-data-text="Não encontramos a cidade!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                    <v-list subheader three-line>
                                        <v-list-tile @click="">
                                            <v-autocomplete label="Igreja Sede do Ministério" item-text="name"
                                                            item-value="name"
                                                            deletable-chips hint="Selecione uma igreja para ser definida como SEDE"
                                                            no-data-text="Não encontramos a igreja!"></v-autocomplete>

                                        </v-list-tile>
                                    </v-list>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" flat @click="dialog = false">Atualizar</v-btn>
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
