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
    </div>
    <v-card>
      <v-form ref="form" v-model="valid" lazy-validation>

        <div class="blue pa-2 pl-3">
          <span class="white--text">Dados básicos</span>
        </div>
        <!--Dados básicos-->
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex v-if="imagePerfil === true">
              <v-avatar :size="50" color="teal">
                <img :src="form.fotoBase64" alt="Foto de Perfil">
              </v-avatar>
            </v-flex>
            <v-flex md4>
              <v-select v-model="form.status_id" :items="situacaoesMembro" label="Tipo de Cadastro*"
                        item-text="nome" item-value="id" required></v-select>
            </v-flex>
            <v-flex md4>
              <v-select v-model="form.tipo_cadastro_id" :items="tiposCadastros" label="Tipo de Cadastro*"
                        item-text="nome" item-value="id" required></v-select>
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
            <v-flex xs12 sm4>
              <v-select v-model="form.marital_status" :items="maritalStatus"
                        :rules="maritalStatusRules" label="Estado Civil" item-text="name"
                        item-value="id"></v-select>
            </v-flex>
            <v-flex xs12 sm6 md4>
              <v-select v-model="form.gender" :rules="genderRules" :items="genders" label="Sexo*"
                        item-text="name" item-value="id" required></v-select>
            </v-flex>
            <v-flex xs12 sm6 md4>
              <v-text-field v-model="form.data_nascimento" label="Data de Nascimento"
                            mask="##/##/####" :rules="dateBirthRules" required></v-text-field>
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
          </v-layout>
        </v-container>

        <div class="blue pa-2 pl-3">
          <span class="white--text">Dados da Igreja</span>
        </div>
        <!--Dados da Igreja-->
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex md6>
              <v-select v-model="form.setor_id" :items="setores"
                        label="Escolha o Setor" item-text="codigo_setor" :rules="rulesSetores"
                        @change="buscaIgreja" item-value="id"></v-select>
            </v-flex>
            <v-flex md6>
              <v-autocomplete v-model="form.igreja_id" :items="igrejas" :rules="rulesIgreja"
                              label="Escolha a Igreja" item-text="nome_igreja" item-value="id"
                              hint="Selecione a igreja do membro"
                              no-data-text="Não encontramos esta igreja">
              </v-autocomplete>
            </v-flex>
          </v-layout>
          <v-layout row wrap v-if="form.tipo_cadastro_id === 2 || form.tipo_cadastro_id === 1">
            <v-flex xs12 sm6>
              <v-select v-model="form.departments" :items="departments" :rules="departmentsRules"
                        attach chips label="Departamentos do membro" multiple item-text="name"
                        item-value="id">
              </v-select>
            </v-flex>
            <v-flex xs12 sm6>
              <v-select v-model="form.trusts" :items="trusts" :rules="trustsRules" attach chips
                        label="Cargo/Função - Local" multiple item-text="name" item-value="id">
              </v-select>
            </v-flex>
            <v-flex xs12 sm4>
              <v-text-field v-model="form.data_conversao" label="Data de Conversão"
                            mask="##/##/####" :rules="dateBirthRules" required></v-text-field>
            </v-flex>
            <v-flex xs12 sm4>
              <v-select
                v-model="form.forma_ingresso"
                :items="formasIgresso"
                item-value="id"
                item-text="nome"
                label="Forma de ingresso na igreja?"
              ></v-select>
            </v-flex>
          </v-layout>
        </v-container>

        <div class="blue pa-2 pl-3">
          <span class="white--text">Dados de contato</span>
        </div>
        <!--Dados de contato-->
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex xs6 sm6 md4>
              <v-text-field v-model="form.cep" :mask="maskCep" label="CEP"
                            @change="buscaCEP"></v-text-field>
            </v-flex>
            <v-flex xs6 sm6 md4>
              <v-select v-model="form.uf" :items="states" :rules="stateRules" label="Estado"
                        item-text="name"
                        item-value="uf" hint="Selecione o estado do usuário" @change="buscarCidade"
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
            <v-flex xs12 sm6 md4>
              <v-text-field v-model="form.email" label="Email" :rules="emailRules"
                            hint="Email válido para verificação"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md4>
              <v-text-field v-model="form.phone" :rules="telefoneRules" :mask="maskPhone"
                            label="Telefone celular"></v-text-field>
            </v-flex>
          </v-layout>
        </v-container>

        <div class="blue pa-2 pl-3" v-if="form.tipo_cadastro_id === 1">
          <span class="white--text">Dados Ministeriais</span>
        </div>
        <!--Dados de Obreiros-->
        <v-container grid-list-md v-if="form.tipo_cadastro_id === 1">
          <v-layout row wrap>
            <v-flex xs6 sm4>
              <v-select v-model="form.cargo_ministerial_id" :items="cargosMinisteriais" :rules="cargoMinisterialRules"
                        label="Cargo Ministerial" item-text="nome"
                        item-value="id">
              </v-select>
            </v-flex>
            <v-flex xs12 sm4>
              <v-select v-model="form.uf_naturalidade_id" :items="states" :rules="stateRules" label="Estado de Naturalidade"
                        item-text="name"
                        item-value="uf" hint="Selecione a naturalidade" @change="buscarCidade"
                        no-data-text="Não encontramos este estado!">
              </v-select>
            </v-flex>
            <v-flex xs12 sm4>
              <v-autocomplete v-model="form.cidade_naturalidade_id" :items="cities" :rules="cidadeRules"
                              label="Cidade da Naturalidade" item-text="name"
                              item-value="name" deletable-chips hint="Selecione a cidade"
                              no-data-text="Não encontramos a cidade!">
              </v-autocomplete>
            </v-flex>
            <v-flex>
              <v-text-field v-model="form.data_consagracao" mask="##/##/####" label="Data Consagração">
              </v-text-field>
            </v-flex>
            <v-flex>
              <v-select v-model="form.curso_teologico_id" :items="cursosTeologicos"
                        label="Curso Teológivos" item-text="nome"
                        item-value="id">
              </v-select>
            </v-flex>
            <v-flex>
              <v-text-field v-model="form.convencao_igreja" label="Convenção de Origem">
              </v-text-field>
            </v-flex>
            <v-flex>
              <v-text-field v-model="form.cod_comadebg" label="Código COMADEBG">
              </v-text-field>
            </v-flex>
            <v-flex>
              <v-text-field v-model="form.cod_cgadb" label="Código CGADB">
              </v-text-field>
            </v-flex>
            <v-flex>
              <v-select v-model="form.situacao_ministerio_id" :items="siatuacoesNoMinisterio"
                        label="Situação no Ministério" item-text="nome"
                        item-value="id">
              </v-select>
            </v-flex>
          </v-layout>
        </v-container>

        <div class="blue pa-2 pl-3">
          <span class="white--text">Upload de Arquivos</span>
        </div>
        <!--Dados de Obreiros-->
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex xs6 sm4>
              Upload de arquivos aqui
            </v-flex>
          </v-layout>
        </v-container>

        <v-container grid-list-md>
          <v-fab-transition>
            <v-btn color="teal" fab dark absolute top right @click="dialogUpload = true">
              <v-icon>add_a_photo</v-icon>
            </v-btn>
          </v-fab-transition>
        </v-container>
      </v-form>
    </v-card>
    <v-layout row justify-center>
      <v-btn dark fab fixed bottom right color="success" @click="salvaMembro">
        <v-icon>save</v-icon>
      </v-btn>
    </v-layout>


    <!--Modal de cadastro da Imagem de Perfil-->
    <v-dialog v-model="dialogUpload" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>
          Cadastrar imagem do membro?
        </v-card-title>
        <v-card-text>
          <croppa :width="150" :height="150" v-model="myCroppa" :zoom-speed="10"></croppa>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="salvarImagemPerfil">
            Salvar imagem
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
        metaInfo() {
            return {title: 'Cadastro de Membro/Congregado'}
        },
        data: () => ({

            //Upload de Foto
            myCroppa: {},
            dialogUpload: false,
            imagePerfil: false,


            url: 'google.com',
            modalCreateMember: false,
            maskCPF: '###.###.###-##',
            maskPhone: '(##) # ####-####',
            maskCep: '#####-###',
            valid: false,

            formasIgresso: [
                {id: 1, nome: 'Aclamação - Aceito sem carta'},
                {id: 2, nome: 'Novo Convertido - Por meio do batismo'},
                {id: 3, nome: 'Transferência - Aceito com carta de recomendação'},
                {id: 4, nome: 'Nacido na Igreja'},
            ],

            cursosTeologicos: [
                {id: 1, nome: 'Básico'},
                {id: 2, nome: 'Médio'},
                {id: 3, nome: 'Bacharel'},
            ],

            siatuacoesNoMinisterio: [
                {id: 1, nome: 'Recebido'},
                {id: 2, nome: 'Consagrado'},
                {id: 3, nome: 'Reintegrado'},
                {id: 4, nome: 'Aguardando Recebimento'},
            ],

            situacaoesMembro: [
                {id: 1, nome: 'Ativo'},
                {id: 2, nome: 'Desligado por pedido'},
                {id: 3, nome: 'Desligado por Ausência'},
                {id: 4, nome: 'Desligado por Óbito'},
                {id: 5, nome: 'Jubilado'},
                {id: 6, nome: 'Disciplina Temporária'},
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
            form: {
                setor_id: null,
                igreja_id: null,
                status_id: 1,
                name: null,
                email: null,
                data_nascimento: null,
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
                data_conversao: null,
                schooling: null,
                forma_ingresso: null,
                tipo_cadastro_id: 2,
                fotoBase64: null,
                cargo_ministerial_id: null,
                uf_naturalidade_id: null,
                cidade_naturalidade_id: null,
                data_consagracao: null,
                curso_teologico_id: null,
                convencao_igreja: null,
                cod_comadebg: null,
                cod_cgadb: null,
                situacao_ministerio_id: 1,
            },
        }),
        methods: {
            salvarImagemPerfil() {
                this.form.fotoBase64 = this.myCroppa.generateDataUrl('image/jpeg', 0.8);
                this.dialogUpload = false;
                this.imagePerfil = true;
            },
            fetchStates() {
                this.$store.dispatch('member/fetchStates');
            },
            buscarCidade() {
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
                    let loader = this.$loading.show();
                    this.$store.dispatch('member/saveMember', this.form).then(res => {
                        loader.hide();
                    });
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
            },
            buscarTiposCadastros() {
                this.$store.dispatch('member/buscarTiposCadastros');
            },
            buscarCargosMinisteriais() {
                this.$store.dispatch('member/buscarCargosMinisteriais');
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
                tiposCadastros: 'member/tiposCadastros',
                cargosMinisteriais: 'member/cargosMinisteriais',
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
            this.buscarTiposCadastros();
            this.buscarCargosMinisteriais();
        },
    }
</script>

<style scoped>
  .v-btn--floating .v-icon {
    height: auto !important;
    width: auto !important;
  }
</style>
