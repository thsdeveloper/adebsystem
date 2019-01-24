<template>
    <div>
        <v-layout>
            <v-flex xs12 sm6 md4>
                <v-text-field v-model="form.cep" :mask="maskCep" label="CEP"></v-text-field>
            </v-flex>
            <v-flex xs12 sm6 md4>
                <v-select v-model="form.ufState" :items="states" label="Estado" item-text="name"
s                                item-value="uf" hint="Selecione o estado do usuário" @change="buscaUf"
                                no-data-text="Não encontramos este estado!">
                </v-select>
            </v-flex>
            <v-flex xs12 sm6 md4>
                <v-autocomplete v-model="form.city" :items="cities" label="Cidade" item-text="name"
                                item-value="id" deletable-chips hint="Selecione a cidade do usuário" @change="buscaBairro"
                                no-data-text="Não encontramos a cidade!"></v-autocomplete>
            </v-flex>
            <v-flex xs12 sm6 md4>
                <v-autocomplete v-model="form.ufbairro" :items="neighborhoods" label="Bairro" item-text="name"
                                item-value="uf" deletable-chips hint="Selecione o bairro do usuário"
                                no-data-text="Não encontramos este bairro!"></v-autocomplete>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    export default {
        name: "SessionEnderecos",
        data: () => ({
            //Arrays dos dados recebidos
            isLoading: false,

            maskCep: '#####-###',

            form:{
                ufState: null,
                city: null,
                ufbairro: null,
                cep: null
            },
        }),
        methods:{
            fetchStates(){
                this.$store.dispatch('member/fetchStates');
            },
            buscaUf(){
                this.$store.dispatch('member/fetchCities', this.form.ufState);
            },
            buscaBairro(){
                this.$store.dispatch('member/fetchNeighborhoods', this.form.ufState);
            }
        },
        computed: {
            ...mapGetters({
                states: 'member/states',
                cities: 'member/cities',
                neighborhoods: 'member/neighborhoods'
            }),
        },
        mounted(){
            this.fetchStates();
        }
    }
</script>
