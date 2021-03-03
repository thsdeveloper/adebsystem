<template>
  <v-autocomplete
    flat solo-inverted hide-details prepend-inner-icon="search"
    v-model="membro"
    :items="membros"
    :loading="isLoading"
    clearable
    dense
    :search-input.sync="search"
    item-text="name"
    no-data-text="Nenhum membro encontrado."
    item-value="id"
    label="O que você está procurando?"
    prepend-icon="mdi-database-search"
    full-width
    @change="acessarLinkMembro()"
  ></v-autocomplete>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: "SearchNavigate",
  data() {
    return {
      membro: null,
      isLoading: false,
      search: null

    }
  },
  methods:{
    acessarLinkMembro(){
      if(this.membro != null){
        window.location.href = '/members/detail/'+this.membro;
      }
    }
  },
  watch: {
    search (val) {
      this.$store.dispatch('member/buscarMembrosApiAlgolia', val)
    },
  },
  computed: {
    ...mapGetters({
      membros: 'member/membrosAlgolia',
    })
  },
}
</script>

<style scoped>

</style>
