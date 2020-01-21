<template>
    <v-form v-model="valid">
        <v-card>
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model.lazy="form.valor" prefix="R$" :rules="valorRules" outlined
                                      label="Valor da transação:" v-money="money" placeholder="0,00" :autofocus="true"/>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-menu ref="menuPagamento" v-model="menuDataPagamento" :close-on-content-click="false"
                                :return-value.sync="form.data_pagamento"
                                transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="form.data_pagamento" label="Data da transação"
                                              hint="Data para efetivação da transação" persistent-hint
                                              prepend-inner-icon="event" outlined readonly v-on="on"/>
                            </template>
                            <v-date-picker v-model="form.data_pagamento" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="menuDataPagamento = false">Cancelar</v-btn>
                                <v-btn text color="primary" @click="$refs.menuPagamento.save(form.data_pagamento)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-col>

                    <v-col cols="12" md="4">

                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="form.descricao" :rules="valorRules" outlined
                                      label="Descrição:" placeholder="Ex. Compras/Recebimento de ações"/>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-form>
</template>

<script>
  import { VMoney } from 'v-money'

  export default {
    name: 'FormCadastroReceitaDespesa',
    directives: { money: VMoney },
    data: () => ({
      money: {
        decimal: ',',
        thousands: '.',
        precision: 2,
        masked: false
      },
      menuDataPagamento: false,

      valid: false,

      form: {
        tipo_receita_financeiro_id: null,
        conta_id: null,
        descricao: null,
        valor: null,
        data_pagamento: new Date().toISOString().substr(0, 10),
        situacao: null,
        observacao: null
      },

      valorRules: [
        v => !!v || 'O valor da transação é obrigatório!',
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid',
      ],
    }),
  }
</script>

<style scoped>

</style>
