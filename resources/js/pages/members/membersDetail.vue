<template> 
  <v-container fluid>
    <v-row>
      <v-col>
        <v-flex xs12 sm12>
          <v-card>
            <v-toolbar dark color="primary">
              Detalhes do Membro
            </v-toolbar>
            <v-img class="white--text" height="100px">
              <v-container fill-height fluid>
              <v-layout fill-height align-content-center>
                  <v-flex md1>
                    <v-avatar color="primary" size="80">
                    </v-avatar>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-img>
            <v-col class="l-flex">
                  <v-chip>Situação: {{}}</v-chip>
                  <v-chip>Tipo de Cadastro: {{}}</v-chip>
                  <v-chip>Data de Cadastro: {{}}</v-chip>
            </v-col>
            <v-card-title>
              <v-container fill-height fluid>
                <v-row>
                  <v-col>
                    <v-subheader inset>Dados Pessoais
                    </v-subheader>
                    <v-divider></v-divider>
                    <p></p>
                    <div class="subtitle-1">
                      <v-icon>assignment_ind</v-icon>
                      Nome: {{member.name}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>fingerprint</v-icon>
                      RG: {{member.details.rg}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>wc</v-icon>
                      Sexo: {{}}
                    </div>
                    <div class="subtitle-1">
                     <v-icon>person</v-icon>
                      Nome da Mãe: {{member.details.nome_mae}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>house</v-icon>
                        Estado de Naturalidade: {{}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>phonelink_ring</v-icon>
                        Telefone: {{member.details.phone}}
                    </div>
                    <p></p>
                    <p></p>
                    <v-subheader inset>Dados Congregacionais</v-subheader>
                    <v-divider></v-divider>
                    <p></p>
                    <div class="subtitle-1">
                      <v-icon>domain</v-icon>
                      Setor: {{member.details.igreja.setor.nome_setor}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>work</v-icon>
                      Cargo/Função: {{}}
                    </div>
                    <v-subheader inset>Dados Ministeriais
                    </v-subheader>
                    <v-divider></v-divider>
                    <p></p>
                    <div class="subtitle-1">
                      <v-icon>work</v-icon>
                      Cargo Ministerial: {{}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>confirmation_number</v-icon>
                      Código COMADEBG: {{member.details.cod_comadebg}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>how_to_reg</v-icon>
                      Situação no Ministério: {{member.details.situacao_ministerio}}
                    </div>
                    <p></p>
                    <p></p>
                  </v-col>
                  <v-col>
                    <br />
                    <br />
                    <div class="subtitle-1">
                      <v-icon>cake</v-icon>
                       Data de Nascimento: {{member.details.data_nascimento}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>school</v-icon>
                      Escolaridade: {{}}
                    </div>
                    <div class="subtitle-1"> 
                      <v-icon>favorite</v-icon>
                      Estado Civil: {{}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>person</v-icon>
                      Nome do Pai: {{member.details.nome_pai}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>house</v-icon>
                      Cidade de Naturalidade: {{}}
                    </div>
                    <div class="subtitle-1">
                     <v-icon>email</v-icon>
                     Email: {{member.email}} <v-icon>forward_to_inbox</v-icon>
                    </div>
                    <br />
                    <br />
                    <p></p>
                    <div class="subtitle-1">
                      <v-icon>festival</v-icon>
                      Igreja: {{}}
                    </div>
                    <div class="subtitle-1">
                     <v-icon>book_online</v-icon>
                     Data de Conversão: {{member.details.data_conversao}}
                    </div>
                    <br />
                    <br />
                    <div class="subtitle-1">
                      <v-icon>book_online</v-icon>
                      Data de Consagração: {{member.details.data_consagracao}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>confirmation_number</v-icon>
                      Código CGADB: {{member.details.cod_cgadb}}
                    </div>
                  </v-col>
                  <v-col>
                    <br />
                    <br />
                    <div class="subtitle-1">
                        <v-icon>account_balance_wallet</v-icon>
                          CPF: {{member.details.cpf}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>build</v-icon>
                       Profissão: {{member.details.profession.name}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>family_restroom</v-icon>
                      Cônjuge: {{}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>room</v-icon>
                      Endereço: {{member.details.endereco.address}}  Número: {{member.details.endereco.number}}  Cidade: {{member.details.endereco.city}}  Bairro: {{member.details.endereco.neighborhood}}
                    </div>
                    <br />
                    <br />
                    <br />
                    <p></p>
                    <div class="subtitle-1">
                      <v-icon>group_add</v-icon>
                      Forma de Ingresso na Igreja:{{member.details.forma_ingresso}}
                    </div>
                    <div class="subtitle-1">
                      <v-icon>book_online</v-icon>
                     Data de Batismo: {{member.details.data_batismo}}
                    </div>
                    <br />
                    <br />
                  <div class="subtitle-1">
                    <v-icon>my_location</v-icon>
                    Convenção de Origem: {{member.details.convencao_igreja}}
                  </div>
                  <div class="subtitle-1">
                    <v-icon>menu_book</v-icon>
                    Cursos Teológicos:{{}}
                  </div>
                  </v-col>
                  <v-container>
                    <div class="subtitle-1">
                      <v-icon>notes</v-icon>
                      Observações: gjgaladfjadgnjamgdfajgklklajdfçkjadsmvkladmnvjkadflmbafdklmaklçnbaknnfklvmadfkbnskvlgdhvijhnjfdnajlkvnladfadvaklvma{{member.details.observacao}}
                    </div>
                  </v-container>
                </v-row>
                <v-layout> 
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
import {mapGetters} from 'vuex';

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
.full-width {
  width: 100%;
}

.mold-imageProfile {
  position: absolute;
  top: 25px;
  left: 10px;
}
</style>
