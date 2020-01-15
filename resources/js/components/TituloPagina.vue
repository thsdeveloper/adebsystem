<template>
  <div class="pb-4">
    <div class="font-weight-thin display-1">
      {{title}}
    </div>
    <div class="subheading">
      {{description}}
    </div>
  </div>
</template>

<script>
  export default {
    name: 'TituloPagina',
    props: {
      title: { type: String, default: 'Inserir texto aqui...' },
      description: { type: String, default: 'Descrição vem aqui...' }
    }
  }
</script>

<style scoped>

</style>
