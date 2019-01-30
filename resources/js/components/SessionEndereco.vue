<template>
    <div>
        <v-layout row wrap>
            <v-flex xs6 sm6 md4>
                <v-text-field v-model="form.cep" :mask="maskCep" label="CEP" @change="buscaCEP"></v-text-field>
            </v-flex>
            <v-flex xs6 sm6 md4>
                <v-select v-model="form.uf" :items="states" label="Estado" item-text="name"
                          item-value="uf" hint="Selecione o estado do usuário" @change="buscaUf"
                          no-data-text="Não encontramos este estado!">
                </v-select>
            </v-flex>
            <v-flex xs12 sm6 md4>
                <v-autocomplete v-model="form.cidade" :items="cities" label="Cidade" item-text="name"
                                item-value="name" deletable-chips hint="Selecione a cidade do usuário"
                                no-data-text="Não encontramos a cidade!"></v-autocomplete>
            </v-flex>
            <v-flex xs12 sm6 md4>
                <v-text-field v-model="form.bairro" label="Bairro"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md6>
                <v-text-field v-model="form.address" label="Endereço"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md2>
                <v-text-field v-model="form.numero" label="Número" mask="######" placeholder="Ex. 38"></v-text-field>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios'
    import swal from 'sweetalert2'
    export default {
        name: "SessionEnderecos",
        data: () => ({
            //Arrays dos dados recebidos
            isLoading: false,

            maskCep: '#####-###',

            form:{
                uf: null,
                cidade: null,
                bairro: null,
                cep: null,
                address: null,
                numero: null,
            },
        }),
        methods:{
            fetchStates(){
                this.$store.dispatch('member/fetchStates');
            },
            buscaUf(){
                this.$store.dispatch('member/fetchCities', this.form.uf);
            },
            buscaCEP(){
                var _this = this;
                // Make a request for a user with a given ID
                if(this.form.cep.length === 8){
                    axios.get('https://viacep.com.br/ws/'+_this.form.cep+'/json/')
                        .then(function (res) {
                            if(res.data.erro === true){
                                swal.fire(
                                    'CEP inválido',
                                    'Por favor, preencha o endereço completo ou insira um novo CEP.',
                                    'question')
                            }else {
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
            }
        },
        computed: {
            ...mapGetters({
                states: 'member/states',
                cities: 'member/cities',
            }),
        },
        mounted(){
            this.fetchStates();
        },
        updated() {
            this.$emit('click', this.form);
        },

    }
</script>
