<template>
    <v-container>
        <form-cadastro-receita-despesa/>
    </v-container>
</template>

<script>
  import FormCadastroReceitaDespesa from '../../components/FormCadastroReceitaDespesa'
  export default {
    middleware: ['auth', 'permission'],
    name: 'cadastrarDespesa',
    components: { FormCadastroReceitaDespesa }
  }
</script>
