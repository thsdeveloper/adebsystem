<template>
    <div>
        <v-form ref="form" v-model="valid">
            <v-card>
                <v-card-title :class="tipo.color + ' white--text'">
                    <v-icon large left color="white">{{tipo.icon}}</v-icon>
                    Cadastrar {{tipo.title}}
                </v-card-title>
                <v-card-subtitle :class="tipo.color + ' white--text'">
                    O processo de cadastro de {{tipo.title}} pode ser visualizado nos relatórios de transações financeiras
                </v-card-subtitle>

                <v-card-text class="mt-5">
                    <v-row>
                        <v-col cols="12" md="2">
                            <v-text-field v-model.lazy="form.valor" prefix="R$" :rules="valorRules" outlined
                                          :label="'Valor da '+ tipo.title " v-money="money" placeholder="0,00"
                                          :autofocus="true"/>
                        </v-col>

                        <v-col cols="12" md="3">
                            <v-menu ref="menuPagamento" v-model="menuDataPagamento" :close-on-content-click="false"
                                    :return-value.sync="form.data_pagamento"
                                    transition="scale-transition" offset-y min-width="290px">
                                <template v-slot:activator="{ on }">
                                    <v-text-field v-model="computedDateFormatted" :label="'Data da '+ tipo.title "
                                                  hint="Data para efetivação da transação" persistent-hint
                                                  prepend-inner-icon="event" outlined readonly v-on="on"/>
                                </template>
                                <v-date-picker v-model="form.data_pagamento" no-title scrollable locale="pt-BR">
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="menuDataPagamento = false">Cancelar</v-btn>
                                    <v-btn text color="primary" @click="$refs.menuPagamento.save(form.data_pagamento)">
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="12" md="5">
                            <v-text-field v-model="form.descricao" :rules="descricaoRules" outlined persistent-hint
                                          hint="Descreva a transação que será efetuada"
                                          :label="'Descrição da '+ tipo.title"
                                          placeholder="Ex. Compras/Recebimento de ações"/>
                        </v-col>
                        <v-col cols="12" md="2">
                            <v-switch v-model="form.situacao" label="Efetuado?"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col md="4">
                            <v-select v-model="form.tipo_categoria_id" :items="categorias"
                                      :label="'Categoria de '+ tipo.title "
                                      prepend-inner-icon="event"
                                      placeholder="Escolha o tipo de categoria" outlined item-value="id"
                                      item-text="nome" :rules="categoriaRules"
                                      no-data-text="Nenhuma categoria encontrada" append-outer-icon="add_circle"
                                      v-on:click:append-outer="dialogCategoria = true"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-textarea outlined v-model="form.observacao" label="Observação:"
                                        placeholder="Descreva uma observação para a transação"/>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-card-actions>
                    <v-btn text :color="tipo.color" @click="cadastrarTransacao">
                        Cadastrar {{tipo.title}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-form>

        <v-dialog v-model="dialogCategoria" persistent max-width="600px">
            <v-form ref="formCategoria" v-model="validCategoria">
                <v-card>
                    <v-card-title :class="tipo.color + ' white--text'">
                        <span class="headline"> <v-icon large left color="white">{{tipo.icon}}</v-icon> Nova categoria de {{tipo.title}}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col>
                                    <v-text-field v-model="formCategoria.nome" label="Nome da Categoria" outlined
                                                  :rules="nomeCategoria" required/>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="dialogCategoria = false">Fechar</v-btn>
                        <v-btn color="blue darken-1" text @click="CadastrarCategoria">Cadastrar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

    </div>
</template>

<script>
  import { VMoney } from 'v-money'
  import { mapGetters } from 'vuex'

  export default {
    name: 'FormCadastroReceitaDespesa',
    directives: { money: VMoney },
    props: {
      tipoReceita: Boolean
    },
    data: () => ({
      money: {
        decimal: '.',
        thousands: ',',
        precision: 2,
        masked: true
      },

      dialogCategoria: false,
      menuDataPagamento: false,

      valid: false,
      validCategoria: false,

      formCategoria: {
        nome: null,
      },

      form: {
        tipo_categoria_id: null,
        descricao: null,
        valor: null,
        data_pagamento: new Date().toISOString().substr(0, 10),
        situacao: false,
        observacao: null,
      },

      valorRules: [
        v => !!v || 'O valor da transação é obrigatório!',
      ],
      descricaoRules: [
        v => !!v || 'O campo Descrição é obrigatório',
      ],
      nomeCategoria: [
        v => !!v || 'O nome da categoria é obrigatório!',
      ],
      categoriaRules: [
        v => !!v || 'O campo Categoria é obrigatório!',
      ],
      rulescampoObrigatorio: [
        v => !!v || 'O campo é obrigatório!',
      ],
    }),
    methods: {
      cadastrarTransacao () {
        if (this.$refs.form.validate()) {
          let loader = this.$loading.show();
          this.$store.dispatch('financeiro/cadastrarTransacao', {
            transacao: this.form,
            tipo: this.tipoReceita
          }).finally(() => {
            loader.hide()
          })
        }
      },
      CadastrarCategoria () {
        if (this.$refs.formCategoria.validate()) {
          let loader = this.$loading.show()
          this.$store.dispatch('financeiro/cadastrarCategoria', {
            tipo: this.tipoReceita,
            categoria: this.formCategoria
          }).then((categoria) => {
            loader.hide()
            this.dialogCategoria = false
            this.$toasted.show('Categoria: ' + categoria.nome + ' cadastrado com sucesso')
          })
        }
      },
      formatDate (date) {
        if (!date) return null
        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },
      buscarCategorias () {
        this.$store.dispatch('financeiro/buscarCategorias', this.tipoReceita)
      },
    },
    computed: {
      ...mapGetters({
        categorias: 'financeiro/categorias',
      }),
      tipo () {
        switch (this.tipoReceita) {
          case true:
            return { color: 'green darken-2', icon: 'mdi-trending-up', title: 'Receita' }
          case false:
            return { color: 'red darken-2', icon: 'mdi-trending-down', title: 'Despesa' }
          default:
            return {}
        }
      },
      computedDateFormatted () {
        return this.formatDate(this.form.data_pagamento)
      },
    },
    mounted () {
      this.buscarCategorias()
    },
    watch: {
      // date (val) {
      //   this.form.data_pagamento = this.formatDate(this.date)
      // },
    },
  }
</script>

<style scoped>

</style>
