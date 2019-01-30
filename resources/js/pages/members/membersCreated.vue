<template>
    <v-card>
        <v-card-title class="headline indigo" primary-title>
            <v-flex white--text>
                Cadastro de membro
            </v-flex>
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md8>
                            <v-text-field v-model="form.name" label="Nome completo" :rules="nameRules" :counter="255" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field v-model="form.cpf" :mask="maskCPF" label="CPF*" :rules="cpfRules" :counter="11" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field v-model="form.rg" label="RG*" :rules="rgRules" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field v-model="form.email" label="Email" :rules="emailRules" hint="Email válido para verificação"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-menu ref="menuBirthday" :close-on-content-click="false" v-model="menuBirthday" :nudge-right="40" lazy transition="scale-transition" offset-y full-width min-width="290px">
                                <v-text-field slot="activator" v-model="form.date_birth" label="Data de nascimento" readonly></v-text-field>
                                <v-date-picker ref="picker" locale="pt-br" v-model="form.date_birth" :max="new Date().toISOString().substr(0, 10)" min="1950-01-01" @change="saveBirthday"></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field v-model="form.mother_name" label="Nome da Mãe"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md6>
                            <v-text-field v-model="form.dad_name" label="Nome do Pai"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-select  v-model="form.gender" :rules="genderRules" :items="genders" label="Sexo*" item-text="name" item-value="id" required></v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <auto-complete-profession @click="professionSelected"/>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field v-model="form.phone" :rules="telefoneRules" :mask="maskPhone" label="Telefone celular"></v-text-field>
                        </v-flex>
                    </v-layout>
                    <session-enderecos @click="changeAddress"/>
                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-select v-model="form.departments" :items="departments" :rules="departmentsRules" attach chips label="Departamentos do membro" multiple item-text="name" item-value="id"></v-select>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-select v-model="form.trusts" :items="trusts" :rules="trustsRules" attach chips label="Cargo/Função" multiple item-text="name" item-value="id"></v-select>
                        </v-flex>
                        <v-flex xs12 sm4>
                            <v-select v-model="form.marital_status" :items="maritalStatus" :rules="maritalStatusRules" label="Estado Civil" item-text="name" item-value="id"></v-select>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-menu ref="menuConversion" :close-on-content-click="false" v-model="menuConversion" :nudge-right="40" lazy transition="scale-transition" offset-y full-width min-width="290px">
                                <v-text-field slot="activator" v-model="form.date_conversion" label="Data de conversão" readonly></v-text-field>
                                <v-date-picker ref="picker" locale="pt-br" v-model="form.date_conversion" :max="new Date().toISOString().substr(0, 10)" @change="saveConversion"></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-select v-model="form.schooling" :items="schoolings" label="Escolaridade" item-text="name" item-value="id"></v-select>
                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex>
                            <v-btn color="blue" @click="reset">Limpar</v-btn>
                            <v-btn color="success" :disabled="!valid"  @click="salvaMembro">Salvar</v-btn>
                        </v-flex>
                    </v-layout>
                </v-form>
            </v-container>
        </v-card-text>
        <v-card-actions>

        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters} from 'vuex';
    import moment from 'moment'
    import SessionEnderecos from "../../components/SessionEndereco";
    import AutoCompleteProfession from "../../components/AutoCompleteProfession";

    export default {
        name: "MemberCreated",
        components: {AutoCompleteProfession, SessionEnderecos},
        data: () => ({
            modalCreateMember: false,
            modalDateBirth: false,
            modalDateConversion: false,
            maskCPF: '###.###.###-##',
            maskPhone: '(##) # ####-####',
            valid: false,
            menuBirthday: false,
            menuConversion: false,

            nameRules: [
                v => !!v || 'Nome é obrigatório',
                v => (v && v.length <= 255) || 'O nome deve ter menos de 255 caracteres'
            ],
            cpfRules:[
                v => !!v || 'Campo CPF é obrigatório',
            ],
            genderRules:[
                v => !!v || 'Sexo é obrigatório',
            ],
            rgRules:[
                v => !!v || 'RG é obrigatório',
            ],
            telefoneRules:[
                v => !!v || 'Telefone é obrigatório',
            ],
            dataNascimentoRules:[
                v => !!v || 'Data de Nascimento é obrigatório',
            ],
            emailRules:[
                v => !!v || 'Email é obrigatório',
                v => /.+@.+/.test(v) || 'E-mail deve ser válido'
            ],
            departmentsRules:[
                v => !!v || 'Departamento é obrigatório',
            ],
            trustsRules:[
                v => !!v || 'Cargo/Função é obrigatório',
            ],
            maritalStatusRules:[
                v => !!v || 'Estado Civil é obrigatório',
            ],

            form:{
                name: null,
                email: null,
                date_birth: null,
                mother_name: null,
                dad_name: null,
                cpf: null,
                rg: null,
                gender: null,
                profession: null,
                phone: null,
                cep: null,
                state: null,
                city: null,
                address: null,
                number: null,
                neighborhood: null,
                departments: null,
                marital_status: null,
                date_conversion: null,
                schooling: null,
            },
        }),
        watch: {
            menuBirthday (val) {
                val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
            },
            menuConversion (val) {
                val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
            }
        },
        methods:{
            saveBirthday (date) {
                this.$refs.menuBirthday.save(date)
            },
            saveConversion (date) {
                this.$refs.menuConversion.save(date)
            },
            professionSelected(id){
                this.form.profession = id;
            },
            computedDateFormattedMomentjs () {
                return this.date ? moment(this.date).format('dddd, MMMM Do YYYY') : ''
            },
            changeAddress(form){
                this.form.cep = form.cep;
                this.form.state = form.uf;
                this.form.city = form.cidade;
                this.form.address = form.address;
                this.form.neighborhood = form.bairro;
                this.form.number = form.numero;
            },
            salvaMembro () {
                if (this.$refs.form.validate()) {
                    this.$store.dispatch('member/saveMember', this.form);
                }
            },
            reset () {
                this.$refs.form.reset()
            },

            fetchDepartments(){
                this.$store.dispatch('department/fetchDepartments');
            },
            fetchMaritalStatus(){
                this.$store.dispatch('member/fetchMaritalStatus');
            },
            fetchTrusts(){
                this.$store.dispatch('member/fetchTrusts');
            },
            fetchGenders(){
                this.$store.dispatch('member/fetchGenders');
            },
            fetchSchoolings(){
                this.$store.dispatch('member/fetchSchoolings');
            },
        },
        computed: {
            ...mapGetters({
                departments: 'department/departments',
                maritalStatus: 'member/maritalStatus',
                trusts: 'member/trusts',
                genders: 'member/genders',
                schoolings: 'member/schoolings',
            }),
        },
        mounted(){
            this.fetchDepartments();
            this.fetchMaritalStatus();
            this.fetchTrusts();
            this.fetchGenders();
            this.fetchSchoolings();
        },
    }
</script>

<style scoped>

</style>
