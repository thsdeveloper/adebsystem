<template>
    <v-container fill-height fluid>
        <form-membro :tipo-form="2"/>
    </v-container>
</template>

<script>
  import FormMembro from '../../components/FormMembro'
  export default {
    components: { FormMembro },
    middleware: ['auth', 'permission'],
  }
</script>
