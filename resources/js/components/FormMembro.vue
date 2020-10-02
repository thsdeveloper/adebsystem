<template>
  <div>
    <v-form ref="form" v-model="valid">
      <v-card>
        <v-card-title :class="tipo.color + ' white--text'">
          <v-icon large left color="white">{{ tipo.icon }}</v-icon>
          {{ tipo.title }} membrolkdshgfksdahjgfkjadhsgf,jhfdskj Thiago dsfsdafdsj hgjsghdf jsdhgf kjgf
        </v-card-title>
        <v-card-subtitle :class="tipo.color + ' white--text'">
          O processo de {{ tipo.title }} o membro pode ser visualizado nos relatórios de transações.
        </v-card-subtitle>

        <v-card-text class="mt-5">
          <v-row v-if="imagePerfil === true">
            <v-avatar :size="50" color="teal">
              <img :src="form.fotoBase64" alt="Foto de Perfil">
            </v-avatar>
          </v-row>
          <v-row>
            <v-col cols="12" md="4">
              <v-select v-model="form.status_id" :items="situacoesmembros" label="Situação do membro"
                        item-text="nome" item-value="id" outlined/>
            </v-col>
            <v-col cols="12" md="4">
              <v-select v-model="form.tipo_cadastro_id" :items="tiposCadastros" label="Tipo de Cadastro*"
                        item-text="nome" item-value="id" outlined/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.cpf" v-mask="maskCPF" label="CPF*" masked="false"
                            :rules="rules.campoObrigatorio" outlined @change="buscaCadastroCpf"
                            :counter="11" :disabled="disabled"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="8" xs="12">
              <v-text-field v-model="form.name" label="Nome completo"
                            :rules="rules.campoObrigatorio" outlined
                            :counter="255"/>
            </v-col>
            <v-col cols="12" md="4" xs="12">
              <v-text-field v-model="form.rg" label="Número do Documento / RG"
                            :rules="rules.campoObrigatorio"
                            :counter="191" outlined/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6" md="4">
              <v-select v-model="form.marital_status_id" :items="maritalStatus"
                        :rules="rules.campoObrigatorio" label="Estado Civil" item-text="name"
                        outlined item-value="id"/>
            </v-col>
            <v-col cols="6" md="4">
              <v-select v-model="form.gender_id" :rules="rules.campoObrigatorio" :items="genders"
                        label="Sexo*" outlined
                        item-text="name" item-value="id"/>
            </v-col>
            <v-col md="4">
              <v-text-field v-model="form.data_nascimento" label="Data de Nascimento" v-mask="maskDate"
                            outlined :rules="rules.campoObrigatorio" clearable/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6" md="4">
              <v-select v-model="form.schooling_id" :items="schoolings"
                        outlined :rules="rules.campoObrigatorio"
                        label="Escolaridade" item-text="name" item-value="id"/>

            </v-col>
            <v-col cols="6" md="4">
              <v-autocomplete v-model="form.profession_id" :items="professions"
                              outlined :rules="rules.campoObrigatorio"
                              label="Profissão" item-text="name"
                              item-value="id" deletable-chips
                              hint="Selecione a profissão do membro"
                              no-data-text="Não encontramos esta profissão!"/>
            </v-col>
            <v-col cols="12" md="4" v-if="form.marital_status_id === 2">
              <v-text-field v-model="form.nome_conjuge" label="Nome do Conjuge"
                            outlined :rules="rules.campoObrigatorio"
              />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.nome_mae" label="Nome da mãe"
                            outlined :rules="rules.campoObrigatorio"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.nome_pai" label="Nome do pai"
                            outlined :rules="rules.campoObrigatorio"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.email" outlined label="Email" :rules="rules.emailRules"
                            hint="Email válido para verificação"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.phone" :rules="rules.campoObrigatorio"
                            v-mask="maskPhone" outlined
                            label="Telefone celular"/>
            </v-col>
          </v-row>
          <v-divider/>
          <v-card-title>Dados Congregacionais</v-card-title>
          <v-row>
            <v-col md="6">
              <v-select v-model="form.setor_id" :items="setores"
                        label="Escolha o Setor" item-text="codigo_setor"
                        :rules="rules.campoObrigatorio" outlined
                        @change="buscaIgreja" item-value="id" no-data-text="Não encontramos nenhum setor cadastrado"/>
            </v-col>
            <v-col md="6">
              <v-autocomplete v-model="form.igreja_id" :items="igrejas"
                              :rules="rules.campoObrigatorio" outlined
                              label="Escolha a Igreja" item-text="nome_igreja" item-value="id"
                              hint="Selecione a igreja do membro"
                              no-data-text="Não encontramos esta igreja">
              </v-autocomplete>
            </v-col>
          </v-row>
          <v-row v-if="form.tipo_cadastro_id === 2 || form.tipo_cadastro_id === 1">
            <v-col cols="12" md="6">
              <v-select v-model="form.departments" :items="departments"
                        :rules="rules.campoObrigatorio" outlined
                        attach chips label="Departamentos do membro" multiple item-text="name"
                        item-value="id">
              </v-select>
            </v-col>
            <v-col cols="12" md="6">
              <v-select v-model="form.trusts" :items="trusts" :rules="rules.campoObrigatorio"
                        attach chips outlined
                        label="Cargo/Função - Local" multiple item-text="name" item-value="id">
              </v-select>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.data_conversao" label="Data de Conversão" v-mask="maskDate"
                            outlined :rules="rules.campoObrigatorio" clearable/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.data_batismo" label="Data do Batísmo" v-mask="maskDate"
                            outlined :rules="rules.campoObrigatorio" clearable/>
            </v-col>
            <v-col cols="12" sm="4">
              <v-select
                v-model="form.forma_ingresso_id"
                :items="formasIgresso"
                :rules="rules.campoObrigatorio"
                item-value="id"
                item-text="nome" outlined
                label="Forma de ingresso na igreja?"
              />
            </v-col>
          </v-row>
          <v-divider/>
          <v-card-title>Endereço</v-card-title>
          <session-enderecos/>

          <v-divider v-if="form.tipo_cadastro_id === 1"/>
          <v-card-title v-if="form.tipo_cadastro_id === 1">Dados Ministeriais</v-card-title>
          <v-card-subtitle v-if="form.tipo_cadastro_id === 1">* Obrigatório apenas para obreiros
          </v-card-subtitle>

          <v-row v-if="form.tipo_cadastro_id === 1">
            <v-col cols="12" md="4">
              <v-select v-model="form.cargo_ministerial_id" :items="cargosMinisteriais"
                        :rules="rules.campoObrigatorio" outlined
                        label="Cargo Ministerial" item-text="nome"
                        item-value="id"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-select v-model="form.uf_naturalidade" :items="estados"
                        :rules="rules.campoObrigatorio"
                        label="Estado de Naturalidade"
                        item-text="name" outlined
                        item-value="uf" hint="Selecione a naturalidade"
                        no-data-text="Não encontramos este estado!"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-autocomplete v-model="form.cidade_naturalidade" :items="cidades"
                              :rules="rules.campoObrigatorio" outlined
                              label="Cidade da Naturalidade" item-text="name"
                              item-value="name" deletable-chips hint="Selecione a cidade"
                              no-data-text="Não encontramos a cidade!"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.data_consagracao" label="Data da Consagração" v-mask="maskDate"
                            outlined :rules="rules.campoObrigatorio" clearable/>
            </v-col>
            <v-col cols="12" md="4">
              <v-select v-model="form.curso_teologico_id" :items="cursosTeologicos"
                        label="Curso Teológivos" item-text="nome" outlined
                        item-value="id"/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.convencao_igreja" label="Convenção de Origem" outlined/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.cod_comadebg" label="Código COMADEBG" outlined/>
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field v-model="form.cod_cgadb" label="Código CGADB" outlined/>
            </v-col>
            <v-col cols="12" md="4">
              <v-select v-model="form.situacao_ministerio_id" :items="siatuacoesNoMinisterio"
                        :rules="rules.campoObrigatorio"
                        label="Situação no Ministério" item-text="nome"
                        item-value="id" outlined outlined/>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-textarea outlined v-model="form.observacao" label="Escreva uma observação sobre o cadastro"
                          value=""/>
            </v-col>
          </v-row>
          <v-row v-if="this.formPublico === true">
            <v-col>
              <v-btn elevation="2" block large color="primary" @click="salvaMembro">Cadastrar</v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-form>

    <v-btn v-if="this.formPublico != true" dark fab fixed bottom right large :color="tipo.color" @click="salvaMembro">
      <v-icon>{{ tipo.icon }}</v-icon>
    </v-btn>

    <v-dialog v-model="dialogUpload" width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title>
          Cadastrar imagem do membro?
        </v-card-title>
        <v-card-text>
          <croppa :width="150" :height="150" v-model="myCroppa" :zoom-speed="10"/>
        </v-card-text>
        <v-divider/>
        <v-card-actions>
          <v-spacer/>
          <v-btn color="primary" flat @click="salvarImagemPerfil">
            Salvar imagem
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import swal from 'sweetalert2'
import Croppa from 'vue-croppa'
import 'vue-croppa/dist/vue-croppa.css'
import SessionEnderecos from './SessionEndereco'

export default {
  name: 'FormMembro',
  components: {
    SessionEnderecos,
    croppa: Croppa.component,
  },
  props: {
    // Tipo 1 > Inserir | 2 > Editar
    tipoForm: { type: Number, default: 1 },
    formPublico: { type: Boolean, default: false }
  },
  data: () => ({

    //Upload de Foto
    myCroppa: {},
    dialogUpload: false,
    imagePerfil: false,
    disabled: false,

    modalCreateMember: false,
    maskCPF: '###.###.###-##',
    maskPhone: '(##) # ####-####',
    maskDate: '##/##/####',
    numeroMask: '######',
    valid: false,
    modalDataAniversario: false,
    modalDataConversao: false,
    modalDataBatismo: false,
    modalConsagracao: false,

    formasIgresso: [
      { id: 1, nome: 'Aclamação - Aceito sem carta' },
      { id: 2, nome: 'Novo Convertido - Por meio do batismo' },
      { id: 3, nome: 'Transferência - Aceito com carta de recomendação' },
      { id: 4, nome: 'Nacido na Igreja' },
      { id: 5, nome: 'Outros' },
    ],

    cursosTeologicos: [
      { id: 1, nome: 'Básico' },
      { id: 2, nome: 'Médio' },
      { id: 3, nome: 'Bacharel' },
    ],

    siatuacoesNoMinisterio: [
      { id: 1, nome: 'Recebido' },
      { id: 2, nome: 'Consagrado' },
      { id: 3, nome: 'Reintegrado' },
      { id: 4, nome: 'Aguardando Recebimento' },
    ],

    //Regras do forms
    rules: {
      emailRules: [
        v => !!v || 'Email é obrigatório',
        v => /.+@.+/.test(v) || 'E-mail deve ser válido'
      ],
      campoObrigatorio: [
        v => !!v || 'Este campo é obrigatório',
      ],
    },

    form: {
      setor_id: null,
      igreja_id: null,
      status_id: 1,
      name: null,
      email: null,
      data_nascimento: null,
      cpf: null,
      rg: null,
      gender_id: null,
      profession_id: null,
      phone: null,

      cidade: null,
      bairro: null,
      cep: null,
      address: null,
      numero: null,

      departments: null,
      trusts: null,
      marital_status_id: null,
      nome_conjuge: null,
      nome_mae: null,
      nome_pai: null,
      data_conversao: null,
      data_batismo: null,
      schooling_id: null,
      forma_ingresso_id: null,
      tipo_cadastro_id: 2,
      fotoBase64: null,
      cargo_ministerial_id: null,
      uf_naturalidade: null,
      cidade_naturalidade: null,
      data_consagracao: null,
      curso_teologico_id: null,
      convencao_igreja: null,
      cod_comadebg: null,
      cod_cgadb: null,
      situacao_ministerio_id: 1,
      observacao: null,
    },
  }),
  methods: {
    salvarImagemPerfil () {
      this.form.fotoBase64 = this.myCroppa.generateDataUrl('image/jpeg', 0.8)
      this.dialogUpload = false
      this.imagePerfil = true
      this.executeSalvarMembro()
    },
    buscaIgreja () {
      let loader = this.$loading.show()
      this.$store.dispatch('igreja/buscarIgrejasPorSetor', this.form.setor_id).then(res => {
        loader.hide()
      })
    },
    salvaMembro () {
      if (this.$refs.form.validate()) {
        swal({
          type: 'question',
          title: 'Cadastrar imagem do perfil?',
          text: 'Deseja realizar o cadastro da imagem do perfil agora? É rápido, prático e facilita a sua identificação!',
          showCancelButton: true,
          confirmButtonText: 'Sim, inserir foto!',
          cancelButtonText: 'Não, depois!',
        }).then((result) => {
          console.warn('441', result)
          if (result.value) {
            this.dialogUpload = true
          } else if (result.dismiss === 'cancel') {
            this.executeSalvarMembro()
          }
        })
      } else {
        this.$toasted.show('Alguns campos estão incorretos! Favor verifique.', { type: 'error' })
      }
    },
    executeSalvarMembro () {
      if (this.$refs.form.validate()) {
        let loader = this.$loading.show()
        this.$store.dispatch('member/saveMember', { form: this.form, endereco: this.enderecoViaCep }).then(res => {
          loader.hide()

          swal({
            type: 'success',
            title: 'Membro cadastrado com sucesso!',
            text: 'O membro foi cadastrado com sucesso em nossa base de dados.',
          }).then((result) => {
            if (result.value) {
              this.$router.push({ name: 'members.all' })
            }
          }).catch((result) => {
            loader.hide()
          })

        })
      }
    },
    buscaCadastroCpf () {
      let loader = this.$loading.show()
      this.$store.dispatch('member/buscaCadastroCpf', this.form.cpf).then(res => {
        loader.hide()
        if (res === true) {
          swal({
            type: 'warning',
            title: 'CPF já cadastrado no sistema!',
            text: 'O CPF informado já esta cadastrado na nossa base de dados, por favor digite outro CPF.',
          })
          this.form.cpf = null
        }
      }).catch(res => {
        loader.hide()
      })
    },
    fetchDepartments () {
      this.$store.dispatch('department/fetchDepartments')
    },
    fetchMaritalStatus () {
      this.$store.dispatch('member/fetchMaritalStatus')
    },
    fetchTrusts () {
      this.$store.dispatch('member/fetchTrusts')
    },
    fetchGenders () {
      this.$store.dispatch('member/fetchGenders')
    },
    fetchSchoolings () {
      this.$store.dispatch('member/fetchSchoolings')
    },
    fetchProfessions () {
      this.$store.dispatch('member/fetchProfessions')
    },
    fetchSetores () {
      this.$store.dispatch('setor/fetchSetores')
    },
    buscarTiposCadastros () {
      this.$store.dispatch('member/buscarTiposCadastros')
    },
    buscarCargosMinisteriais () {
      this.$store.dispatch('member/buscarCargosMinisteriais')
    },
    buscarSituacoesMembro () {
      this.$store.dispatch('member/buscarSituacoesMembro')
    },
    buscaMembro () {
      var id = this.$route.params.id
      this.$store.dispatch('member/fetchMember', id).then(membro => {
        console.warn('583', membro)
        this.form.status_id = membro.status_id
        this.form.tipo_cadastro_id = membro.details.tipo_cadastro_id
        this.form.cpf = membro.details.cpf
        this.form.name = membro.name
        this.form.rg = membro.details.rg
        this.form.rg = membro.details.rg
        this.form.marital_status_id = membro.details.marital_status_id
        this.form.gender_id = membro.details.gender_id
        this.form.data_nascimento = membro.details.data_nascimento
        this.form.schooling_id = membro.details.schooling_id
        this.form.profession_id = membro.details.profession_id
        this.form.nome_conjuge = membro.details.nome_conjuge
        this.form.nome_mae = membro.details.nome_mae
        this.form.nome_pai = membro.details.nome_pai
        this.form.email = membro.email
        this.form.phone = membro.details.phone

        //Todo: Igreja e Setor
        this.form.setor_id = membro.details.igreja.setor.id
        if (this.form.setor_id) {
          this.buscaIgreja()
        }
        this.form.igreja_id = membro.details.igreja.id

        this.form.departments = membro.details.departamentos
        this.form.trusts = membro.details.cargos

        this.form.data_conversao = membro.details.data_conversao
        this.form.data_batismo = membro.details.data_batismo
        this.form.forma_ingresso_id = membro.details.forma_ingresso_id

        this.form.cep = membro.details.endereco.cep
        // this.form.estado = membro.details.endereco.cep;

        this.form.observacao = membro.details.observacao
      })
    },
  },
  computed: {
    ...mapGetters({
      departments: 'department/departments',
      maritalStatus: 'member/maritalStatus',
      trusts: 'member/trusts',
      genders: 'member/genders',
      schoolings: 'member/schoolings',
      estados: 'endereco/estados',
      cidades: 'endereco/cidades',
      tiposCadastros: 'member/tiposCadastros',
      cargosMinisteriais: 'member/cargosMinisteriais',
      professions: 'member/professions',
      setores: 'setor/setores',
      igrejas: 'igreja/igrejas',
      situacoesmembros: 'member/situacoesmembros',
      membro: 'member/memberDetail',
      enderecoViaCep: 'endereco/enderecoViaCep',
    }),

    computedDataNascimento () {
      return this.formatDate(this.form.data_nascimento)
    },
    computedDataConversao () {
      return this.formatDate(this.form.data_conversao)
    },
    computedDataBatismo () {
      return this.formatDate(this.form.data_batismo)
    },
    computedDataConsagracao () {
      return this.formatDate(this.form.data_consagracao)
    },
    formatDate (date) {
      console.log('dataNascimento', date)
      if (!date) return null
      const [year, month, day] = date.split('/')
      return `${day}-${month}-${year}`
    },
    tipo () {
      switch (this.tipoForm) {
        case 1:
          return { color: 'green darken-2', icon: 'save', title: 'Cadastrar' }
        case 2:
          return { color: 'primary', icon: 'save', title: 'Editar' }
        default:
          return {}
      }
    },
  },
  mounted () {
    this.fetchDepartments()
    this.fetchMaritalStatus()
    this.fetchTrusts()
    this.fetchGenders()
    this.fetchSchoolings()
    this.fetchProfessions()
    this.fetchSetores()
    this.buscarTiposCadastros()
    this.buscarCargosMinisteriais()
    this.buscarSituacoesMembro()
    if (this.tipoForm === 2) {
      this.disabled = true
      this.buscaMembro()
    }
  }
}
</script>

<style scoped>

</style>
