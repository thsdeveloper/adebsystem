<template>
 <div>
   <form-membro :form-publico="true" />
 </div>
</template>

<script>
    import FormMembro from '../../components/FormMembro'

    export default {
        middleware: 'guest',
        layout: 'welcomeApp',

        components: {
          FormMembro,
            // LoginWithGithub
        },
    }
</script>
