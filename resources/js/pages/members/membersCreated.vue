<template>
    <v-container fill-height>
        <form-membro />
    </v-container>
</template>

<script>
  import FormMembro from '../../components/FormMembro'
  export default {
    components: { FormMembro },
    middleware: ['auth', 'permission'],
  }
</script>
