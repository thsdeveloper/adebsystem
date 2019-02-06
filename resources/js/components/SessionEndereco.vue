<template>
    <div>

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
            // this.$emit('click', this.form);
        },

    }
</script>
