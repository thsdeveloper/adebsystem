<template>
  <v-card flat>
    <v-card-text>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row>
          <v-col>
            <h2>Informe o tipo de relatório:</h2>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field label="Gerar relatório por nomes" v-model="formRelatorio.nome" :rules="nomeRules" outlined></v-text-field>
          </v-col>

          <v-col class="d-flex" cols="12" sm="6">
            <v-select v-model="formRelatorio.tipo" :items="tiposRelatorios" item-value="id" item-text="nome" outlined
                      label="Tipo do relatório"></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-btn color="primary" elevation="2" @click="gerarRelatorio()">Gerar Relatório</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios'
import * as types from "../store/mutation-types";
import download from 'downloadjs'
export default {
  name: 'RelatorioVisitantes',
  props: {
    title: {type: String, default: 'Inserir texto aqui...'},
    description: {type: String, default: 'Descrição vem aqui...'}
  },
  data() {
    return {
      valid: false,
      formRelatorio: {
        nome: '',
        tipo: 1
      },


      tiposRelatorios: [
        {
          nome: 'Apresentação',
          id: 1,
        },
        {
          nome: 'Visitantes Procurando Igreja',
          id: 2
        },
        {
          nome: 'Visitantes Evangélicos',
          id: 3
        },
        {
          nome: 'Visitantes Não Evangélicos',
          id: 4
        },
        {
          nome: 'Todos os visitantes',
          id: 5
        }
      ],
      nomeRules: [
        v => !!v || 'Nome é obrigatório',
      ],
    }
  },
  methods:{
    async gerarRelatorio() {
      try {
        if (this.$refs.form.validate()) {
          const { data } = await axios.post('/api/relatorio/visitantes');

          download(data, 'file.pdf', 'application/pdf');

          console.info(data);

        }
      } catch (e) {
        alert('Ocorreu na geração de relatório');
      }
    },
  }

}
</script>

<style scoped>

</style>
