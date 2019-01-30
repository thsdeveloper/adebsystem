<template>
    <div>
        <v-autocomplete v-model="selectProfession" :items="professions" label="Profissão" item-text="name"
                        item-value="id" deletable-chips hint="Selecione a profissão do membro"
                        no-data-text="Não encontramos esta profissão!" :input="selecionouItem()"></v-autocomplete>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'AutoCompleteProfession',
        props: {

        },

        data: () => ({
            selectProfession: null
        }),
        created () {

        },
        methods: {
            selecionouItem(){
                this.$emit('click', this.selectProfession);
            },
            fetchProfessions(){
                this.$store.dispatch('member/fetchProfessions');
            },
        },
        computed: {
            ...mapGetters({professions: 'member/professions'})
        },
        mounted(){
            this.fetchProfessions();
        },
    }
</script>
