<template>
    <v-dialog v-model="modalCreateMember" width="800">
        <v-btn slot="activator" dark fab fixed bottom right color="purple"><v-icon>add</v-icon></v-btn>

        <v-card>
            <v-card>
                <v-card-title class="headline purple lighten-2" primary-title>
                    <v-flex white--text>
                        Novo membro
                    </v-flex>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.name" label="Nome completo" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.email" label="Email" hint="Email válido para verificação"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-dialog ref="dialog" v-model="modalDateBirth" :return-value.sync="form.date_birth" persistent lazy full-width width="290px">
                                    <v-text-field slot="activator" v-model="form.date_birth" label="Data de nascimento" prepend-icon="event" readonly></v-text-field>
                                    <v-date-picker v-model="form.date_birth" :max="new Date().toISOString().substr(0, 10)" min="1950-01-01" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="modalDateBirth = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.dialog.save(form.date_birth)">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field v-model="form.mother_name" label="Nome da Mãe"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field v-model="form.dad_name" label="Nome do Pai"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.cpf" label="CPF*" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.rg" label="RG*" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-select  v-model="form.sex" :items="['Masculino', 'Feminino']" label="Sexo*" required></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <auto-complete-profession @click="professionSelected"/>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <auto-complete-profession @click="professionSelected"/>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="modalCreateMember = false">Close</v-btn>
                    <v-btn color="blue darken-1" flat @click="modalCreateMember = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-card>
    </v-dialog>
</template>

<script>
    import AutoCompleteProfession from "./AutoCompleteProfession";
    export default {
        name: "createMember",
        components: {AutoCompleteProfession},
        data: () => ({
            modalCreateMember: false,
            modalDateBirth: false,
            form:{
                name: null,
                email: null,
                date_birth: null,
                mother_name: null,
                dad_name: null,
                cpf: null,
                rg: null,
                sex: null,
                profession: null,
            },
        }),
        methods:{
            professionSelected(id){
                this.form.profession = id;
            },
        },

    }
</script>

<style scoped>

</style>
