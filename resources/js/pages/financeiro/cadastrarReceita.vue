<template>
    <v-container>
        <v-row>
            <v-col>
                <titulo-pagina title="Cadastrar Receita" description="Uma receita representa qualquer valor financeiro dado como entrada na igreja"/>
            </v-col>
        </v-row>
        <form-cadastro-receita-despesa />
    </v-container>
</template>

<script>
  import TituloPagina from '../../components/TituloPagina'
  import FormCadastroReceitaDespesa from '../../components/FormCadastroReceitaDespesa'
  export default {
    middleware: ['auth', 'permission'],
    name: 'cadastrarReceita',
    components: { FormCadastroReceitaDespesa, TituloPagina }
  }
</script>

<style scoped>

</style>
