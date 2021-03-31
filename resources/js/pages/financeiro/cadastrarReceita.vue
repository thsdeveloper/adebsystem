<template>
    <v-container>
        <form-cadastro-receita-despesa tipo-receita/>
    </v-container>
</template>

<script>
  import FormCadastroReceitaDespesa from '../../components/FormCadastroReceitaDespesa'
  export default {
    middleware: ['auth', 'permission'],
    name: 'cadastrarReceita',
    components: { FormCadastroReceitaDespesa }
  }
</script>
