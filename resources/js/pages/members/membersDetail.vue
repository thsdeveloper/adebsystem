<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <v-flex xs12 sm12>
          <v-card>
            <v-toolbar dark color="primary">
              <v-row>
                <v-col>
                  <v-avatar size="50" color="grey lighten-4">
                    <img :src="member.photo_url" :tile="true" :alt="member.name">
                  </v-avatar>
                </v-col>
                <v-col>
                  <v-toolbar-title></v-toolbar-title>
                </v-col>
              </v-row>
            </v-toolbar>
            <v-img class="white--text" height="100px">
              <v-container fill-height fluid>
                <v-layout fill-height align-content-center>
                  <v-flex md1>
                    <v-avatar size="50" color="grey lighten-4">
                      <img :src="member.photo_url" :tile="true" :alt="member.name">
                    </v-avatar>
                  </v-flex>
                  <v-flex align-center flexbox>
                    <span class="headline">{{member.name}}</span><br>
                    <span class="body-1">{{member.email}}</span><br>
                  </v-flex>
                  <v-flex align-self-baseline>
                    <v-btn color="primary" block>Enviar mensagem</v-btn>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-img>
            <v-card-title>
              <v-container fill-height fluid>
                <v-layout>
                  <v-flex md4>
                  <div class="subtitle-2"> 
                     Situação do Membro: {{member.status}}
                  </div>
                  <div class="subtitle-2"> 
                    Tipo de Cadastro: {{member.details.tipo_cadastro}}
                  </div>
                  <div class="subtitle-2">
                    Data do Cadastro:
                  </div>                   
                  <div class="subtitle-1">
                    <strong>Dados Pessoais</strong></div>
                  <div class="subtitle-1">
                    <v-icon>assignment_ind</v-icon>
                    Nome: {{member.name}}
                  </div>
                    <v-flex md4><div class="subtitle-1">
                    <v-icon>account_balance_wallet</v-icon>
                      CPF: {{member.details.cpf}}
                  </div></v-flex>
                  <div class="subtitle-1">
                    <v-icon>fingerprint</v-icon>
                    Documento/RG: {{member.details.rg}}
                  </div>
                  <div class="subtitle-1"> 
                    <v-icon>favorite</v-icon>
                     Estado Civil: {{member.details.marital_status}}
                  </div>
                  <div class="subtitle-1">
                     <v-icon>person</v-icon>
                     Nome da Mãe: {{member.details.nome_mae}}
                  </div>
                  <div class="subtitle-1">
                     <v-icon>email</v-icon>
                     Email: {{member.email}} <v-icon>forward_to_inbox</v-icon> <i>Programar para enviar Email</i>
                  </div>
                  <div class="subtitle-1">
                   <v-icon>house</v-icon>
                    Estado de Naturalidade: {{member.details.uf_naturalidade}}
                  </div>
                  <div class="subtitle-1">
                   <v-icon>room</v-icon>
                    Endereço: {{member.details.endereco.address}}  Número: {{member.details.endereco.number}}  Cidade: {{member.details.endereco.city}}  Bairro: {{member.details.endereco.neighborhood}}
                  </div>
                  <v-divider></v-divider>
                  <p></p>
                  <div class="subtitle-1">
                     <strong>Dados Congregacionais</strong>
                  </div>
                  <div class="subtitle-1">
                    <v-icon>domain</v-icon>
                    Setor:{{}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>festival</v-icon>
                    Igreja: {{}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>work</v-icon>
                    Cargo/Função: {{}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>groups</v-icon>
                    Departamentos: {{}}
                  </div>
                  <div class="subtitle-1">
                     <v-icon>book_online</v-icon>
                     Data de Conversão: {{member.details.data_conversao}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>book_online</v-icon>
                     Data de Batismo: {{member.details.data_batismo}}
                    </div>
                  <div class="subtitle-1">
                    <v-icon>group_add</v-icon>
                    Forma de Ingresso na Igreja:{{member.details.forma_ingresso}}
                  </div>
                  <v-divider></v-divider>
                  <p></p>
                  <div class="subtitle-1">
                     <strong>Dados Eclesiásticos</strong>
                  </div>
                  <div class="subtitle-1">
                    <v-icon>work</v-icon>
                    Cargo Ministerial: {{member.details.cargo_ministerial}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>book_online</v-icon>
                     Data de Consagração: {{member.details.data_consagracao}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>my_location</v-icon>
                    Convenção de Origem: {{member.details.convencao_igreja}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>confirmation_number</v-icon>
                    Código COMADEBG: {{member.details.cod_comadebg}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>confirmation_number</v-icon>
                    Código CGADB: {{member.details.cod_cgadb}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>menu_book</v-icon>
                    Cursos Teológicos:{{member.details.curso_teologico}}
                  </div>
                  <v-divider></v-divider>
                  <div class="subtitle-1">
                    <v-icon>notes</v-icon>
                    Observações: {{member.details.observacao}}
                  </div>
                </v-flex>         
                  <v-flex md4>
                    <div class="subtitle-1">
                      <v-icon>cake</v-icon>
                       Data de Nascimento: {{member.details.data_nascimento}}
                    </div>
                  <div class="subtitle-1">
                      <v-icon>wc</v-icon>
                      Sexo: {{member.details.gender}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>school</v-icon>
                    Escolaridade: {{member.details.schooling}}
                  </div>
                  <div class="subtitle-1">
                      <v-icon>build</v-icon>
                       Profissão: {{member.details.profession.name}}
                  </div>
                  <div class="subtitle-1">
                      <v-icon>family_restroom</v-icon>
                      Cônjuge: {{member.details.nome_conjuge}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>person</v-icon>
                    Nome do Pai: {{member.details.nome_pai}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>phonelink_ring</v-icon>
                    Telefone: {{member.details.phone}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>house</v-icon>
                    Cidade de Naturalidade: {{member.details.cidade_naturalidade}}
                  </div>
                </v-flex>
                </v-layout>
              </v-container>
            </v-card-title>
            <v-card-actions>
              <!--<v-btn flat color="orange">Share</v-btn>-->
              <!--<v-btn flat color="orange">Explore</v-btn>-->
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-col>
    </v-row>
  </v-container>


</template>

<script>
  import { mapGetters } from 'vuex';

  export default {
    name: 'DetalheDoMebro',
    methods: {
      fetchUser () {
        var id = this.$route.params.id
        this.$store.dispatch('member/fetchMember', id)
      }
    },
    mounted () {
      this.fetchUser()
    },
    computed: {
      ...mapGetters({
        member: 'member/memberDetail',
      }),
    },
    beforeMount () {
      // console.log('IdUser', this.$route.params.userId)
    },

  }
</script>

<style scoped>

</style>
