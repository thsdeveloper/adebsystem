<template>
    <div>
        <div class="pb-4">
            <div class="font-weight-thin display-1">
                <v-icon size="40">supervisor_account</v-icon>
                Cadastro de Membros/Congregados
            </div>
            <div class="subheading">
                Cadastro geral de membro ou congregado de acordo com o critério ministerial.
            </div>
            <croppa v-model="myCroppa"></croppa>
        </div>
        <v-card>
            <v-card-text>
                <v-container grid-list-md>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-layout row wrap>
                            <v-flex md4>
                                <v-switch v-model="form.status" :rules="rulesStatus" label="Cadastro ativo?"></v-switch>
                            </v-flex>
                            <v-flex md4>
                                <v-radio-group v-model="form.tipo_cadastro" row>
                                    <v-radio label="Membro" :value="1"></v-radio>
                                    <v-radio label="Congregado" :value="2"></v-radio>
                                </v-radio-group>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.cpf" :mask="maskCPF" label="CPF*" :rules="cpfRules"
                                              :counter="11" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md8>
                                <v-text-field v-model="form.name" label="Nome completo" :rules="nameRules"
                                              :counter="255" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.rg" label="RG*" :rules="rgRules" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.email" label="Email" :rules="emailRules"
                                              hint="Email válido para verificação"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.phone" :rules="telefoneRules" :mask="maskPhone"
                                              label="Telefone celular"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-select v-model="form.gender" :rules="genderRules" :items="genders" label="Sexo*"
                                          item-text="name" item-value="id" required></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-menu ref="menuBirthday" :close-on-content-click="false" v-model="menuBirthday"
                                        :nudge-right="40" lazy transition="scale-transition" offset-y full-width
                                        min-width="290px">
                                    <v-text-field slot="activator" v-model="form.date_birth" :rules="dateBirthRules"
                                                  label="Data de nascimento" readonly></v-text-field>
                                    <v-date-picker ref="picker" locale="Pt-br" v-model="form.date_birth"
                                                   :max="new Date().toISOString().substr(0, 10)" min="1950-01-01"
                                                   @change="saveBirthday"></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-select v-model="form.schooling" :items="schoolings" :rules="escolaridadeRules"
                                          label="Escolaridade" item-text="name" item-value="id"></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-autocomplete v-model="form.profession" :items="professions" :rules="professionRules"
                                                label="Profissão" item-text="name"
                                                item-value="id" deletable-chips hint="Selecione a profissão do membro"
                                                no-data-text="Não encontramos esta profissão!"></v-autocomplete>
                            </v-flex>
                            <v-flex md4>
                                <v-select v-model="form.setor_id" :items="setores"
                                          label="Escolha o Setor" item-text="codigo_setor" :rules="rulesSetores"
                                          @change="buscaIgreja" item-value="id"></v-select>
                            </v-flex>
                            <v-flex md4>
                                <v-autocomplete v-model="form.igreja_id" :items="igrejas" :rules="rulesIgreja"
                                          label="Escolha a Igreja" item-text="nome_igreja" item-value="id"
                                          hint="Selecione a igreja do membro" no-data-text="Não encontramos esta igreja"></v-autocomplete>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs6 sm6 md4>
                                <v-text-field v-model="form.cep" :mask="maskCep" label="CEP"
                                              @change="buscaCEP"></v-text-field>
                            </v-flex>
                            <v-flex xs6 sm6 md4>
                                <v-select v-model="form.uf" :items="states" :rules="stateRules" label="Estado"
                                          item-text="name"
                                          item-value="uf" hint="Selecione o estado do usuário" @change="buscaUf"
                                          no-data-text="Não encontramos este estado!">
                                </v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-autocomplete v-model="form.cidade" :items="cities" :rules="cidadeRules"
                                                label="Cidade" item-text="name"
                                                item-value="name" deletable-chips hint="Selecione a cidade do usuário"
                                                no-data-text="Não encontramos a cidade!"></v-autocomplete>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.bairro" :rules="bairroRules" label="Bairro"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.address" :rules="addressRules"
                                              label="Endereço"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-text-field v-model="form.numero" label="Número" :rules="numeroRules" mask="######"
                                              placeholder="Ex. 38"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <!--<session-enderecos @click="changeAddress"/>-->
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-select v-model="form.departments" :items="departments" :rules="departmentsRules"
                                          attach chips label="Departamentos do membro" multiple item-text="name"
                                          item-value="id"></v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-select v-model="form.trusts" :items="trusts" :rules="trustsRules" attach chips
                                          label="Cargo/Função" multiple item-text="name" item-value="id"></v-select>
                            </v-flex>
                            <v-flex xs12 sm4>
                                <v-select v-model="form.marital_status" :items="maritalStatus"
                                          :rules="maritalStatusRules" label="Estado Civil" item-text="name"
                                          item-value="id"></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-menu ref="menuConversion" :close-on-content-click="false" v-model="menuConversion"
                                        :nudge-right="40" lazy transition="scale-transition" offset-y full-width
                                        min-width="290px">
                                    <v-text-field slot="activator" v-model="form.date_conversion"
                                                  label="Data de conversão" readonly></v-text-field>
                                    <v-date-picker ref="picker" locale="pt-br" v-model="form.date_conversion"
                                                   :max="new Date().toISOString().substr(0, 10)"
                                                   @change="saveConversion"></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <v-select
                                        v-model="form.forma_ingresso"
                                        :items="formasIgresso"
                                        item-value="id"
                                        item-text="nome"
                                        label="Forma de ingresso na igreja?"
                                ></v-select>
                            </v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex>
                                <v-btn color="error" @click="reset">Limpar formulário</v-btn>
                                <!--                                <v-btn color="success" :disabled="!valid"  @click="salvaMembro">Salvar</v-btn>-->
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>

            </v-card-actions>
        </v-card>
        <v-layout row justify-center>
            <v-btn dark fab fixed bottom right color="success" @click="salvaMembro">
                <v-icon>save</v-icon>
            </v-btn>
        </v-layout>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import moment from 'moment';
    import SessionEnderecos from "../../components/SessionEndereco";
    import AutoCompleteProfession from "../../components/AutoCompleteProfession";
    import axios from 'axios';
    import swal from 'sweetalert2';
    import Croppa from 'vue-croppa';
    import 'vue-croppa/dist/vue-croppa.css'

    export default {
        name: "MemberCreated",
        components: {croppa: Croppa.component, AutoCompleteProfession, SessionEnderecos},
        data: () => ({
            myCroppa: {},
            url: 'google.com',
            modalCreateMember: false,
            modalDateBirth: false,
            modalDateConversion: false,
            maskCPF: '###.###.###-##',
            maskPhone: '(##) # ####-####',
            maskCep: '#####-###',
            valid: false,
            menuBirthday: false,
            menuConversion: false,

            formasIgresso: [
                {id: 1, nome: 'Aclamação - Aceito sem carta'},
                {id: 2, nome: 'Novo Convertido - Por meio do batismo'},
                {id: 3, nome: 'Transferência - Aceito com carta de recomendação'},
            ],

            nameRules: [
                v => !!v || 'Nome é obrigatório',
                v => (v && v.length <= 255) || 'O nome deve ter menos de 255 caracteres'
            ],
            cpfRules: [
                v => !!v || 'Campo CPF é obrigatório',
            ],
            genderRules: [
                v => !!v || 'Sexo é obrigatório',
            ],
            rgRules: [
                v => !!v || 'RG é obrigatório',
            ],
            telefoneRules: [
                v => !!v || 'Telefone é obrigatório',
            ],
            dataNascimentoRules: [
                v => !!v || 'Data de Nascimento é obrigatório',
            ],
            emailRules: [
                v => !!v || 'Email é obrigatório',
                v => /.+@.+/.test(v) || 'E-mail deve ser válido'
            ],
            departmentsRules: [
                v => !!v || 'Departamento é obrigatório',
            ],
            trustsRules: [
                v => !!v || 'Cargo/Função é obrigatório',
            ],
            maritalStatusRules: [
                v => !!v || 'Estado Civil é obrigatório',
            ],
            dateBirthRules: [
                v => !!v || 'Data de nascimento é obrigatório',
            ],
            stateRules: [
                v => !!v || 'Estado é obrigatório',
            ],
            cidadeRules: [
                v => !!v || 'Cidade é obrigatório',
            ],
            bairroRules: [
                v => !!v || 'Bairro é obrigatório',
            ],
            addressRules: [
                v => !!v || 'Endereço é obrigatório',
            ],
            numeroRules: [
                v => !!v || 'Número da casa/apartamento é obrigatório',
            ],
            escolaridadeRules: [
                v => !!v || 'Escolaridade é obrigatório',
            ],
            professionRules: [
                v => !!v || 'Profissão é obrigatório',
            ],
            rulesStatus: [
                v => !!v || 'Membro está ativo?',
            ],
            rulesSetores: [
                v => !!v || 'Escolha o Setor que o membro congrega',
            ],
            rulesIgreja: [
                v => !!v || 'Escolha uma igreja para o membro',
            ],
            // form:{
            //   status: null,
            //   name: 'Thiago Oliveira Barros',
            //   email: 'thiagohhshsh@gmail.com',
            //   date_birth: '1971-02-13',
            //   cpf: '04307651189',
            //   rg: '2622896',
            //   gender: 1,
            //   profession: 22,
            //   phone: '61996617935',
            //   uf: 'DF',
            //   cidade: 'Brasília',
            //   bairro: 'Samambaia Sul',
            //   cep: '72308006',
            //   address: 'Qn 312 Conjunto 14 Lote 7',
            //   numero: '07',
            //   departments: null,
            //   trusts: null,
            //   marital_status: 2,
            //   date_conversion: '2005-02-13',
            //   schooling: 1,
            // },
            form: {
                setor_id: null,
                igreja_id: null,
                status: 1,
                name: null,
                email: null,
                date_birth: null,
                cpf: null,
                rg: null,
                gender: null,
                profession: null,
                phone: null,
                uf: null,
                cidade: null,
                bairro: null,
                cep: null,
                address: null,
                numero: null,
                departments: null,
                trusts: null,
                marital_status: null,
                date_conversion: null,
                schooling: null,
                forma_ingresso: null,
                tipo_cadastro: 1,
            },
        }),
        watch: {
            menuBirthday(val) {
                val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
            },
            menuConversion(val) {
                val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
            }
        },
        methods: {
            fetchStates() {
                this.$store.dispatch('member/fetchStates');
            },
            buscaUf() {
                this.$store.dispatch('member/fetchCities', this.form.uf);
            },
            buscaIgreja() {
                this.$store.dispatch('igreja/buscarIgrejasPorSetor', this.form.setor_id);
            },
            buscaCEP() {
                var _this = this;
                // Make a request for a user with a given ID
                if (this.form.cep.length === 8) {
                    axios.get('https://viacep.com.br/ws/' + _this.form.cep + '/json/')
                        .then(function (res) {
                            if (res.data.erro === true) {
                                swal.fire(
                                    'CEP inválido',
                                    'Por favor, preencha o endereço completo ou insira um novo CEP.',
                                    'question')
                            } else {
                                _this.form.bairro = res.data.bairro;
                                _this.form.address = res.data.logradouro;
                                _this.form.uf = res.data.uf;
                                _this.form.cidade = res.data.localidade;
                            }
                        }).catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                }
            },
            saveBirthday(date) {
                this.$refs.menuBirthday.save(date)
            },
            saveConversion(date) {
                this.$refs.menuConversion.save(date)
            },
            computedDateFormattedMomentjs() {
                return this.date ? moment(this.date).format('dddd, MMMM Do YYYY') : ''
            },
            // changeAddress(form){
            //     this.form.cep = form.cep;
            //     this.form.state = form.uf;
            //     this.form.city = form.cidade;
            //     this.form.address = form.address;
            //     this.form.neighborhood = form.bairro;
            //     this.form.number = form.numero;
            // },
            salvaMembro() {
                if (this.$refs.form.validate()) {
                    this.$store.dispatch('member/saveMember', this.form);
                }
            },
            reset() {
                this.$refs.form.reset()
            },

            fetchDepartments() {
                this.$store.dispatch('department/fetchDepartments');
            },
            fetchMaritalStatus() {
                this.$store.dispatch('member/fetchMaritalStatus');
            },
            fetchTrusts() {
                this.$store.dispatch('member/fetchTrusts');
            },
            fetchGenders() {
                this.$store.dispatch('member/fetchGenders');
            },
            fetchSchoolings() {
                this.$store.dispatch('member/fetchSchoolings');
            },
            fetchProfessions() {
                this.$store.dispatch('member/fetchProfessions');
            },
            fetchSetores() {
                this.$store.dispatch('setor/fetchSetores');
            }
        },
        computed: {
            ...mapGetters({
                departments: 'department/departments',
                maritalStatus: 'member/maritalStatus',
                trusts: 'member/trusts',
                genders: 'member/genders',
                schoolings: 'member/schoolings',
                states: 'member/states',
                cities: 'member/cities',
                professions: 'member/professions',
                setores: 'setor/setores',
                igrejas: 'igreja/igrejas'
            }),
        },
        mounted() {
            this.fetchDepartments();
            this.fetchMaritalStatus();
            this.fetchTrusts();
            this.fetchGenders();
            this.fetchSchoolings();
            this.fetchStates();
            this.fetchProfessions();
            this.fetchSetores();
        },
    }
</script>

<style scoped>
    .v-btn--floating .v-icon {
        height: auto !important;
        width: auto !important;
    }
</style>
