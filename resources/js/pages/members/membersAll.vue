<template>
    <div>
        <v-layout>
            <v-flex>
                <v-card>
                    <v-list two-line>
                        <v-subheader>
                            Membros
                        </v-subheader>

                        <div v-for="user in users">
                            <v-list-tile avatar :to="{ name: 'members.detail', params: { userId: user.id }}">
                                <v-list-tile-avatar>
                                    <img :src="user.photo_url">
                                </v-list-tile-avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title>{{user.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{user.email}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-divider></v-divider>
                        </div>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row justify-center>
            <v-btn dark fab fixed bottom right color="purple" to="created">Adicionar</v-btn>
        </v-layout>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'MembersAll',
        middleware: ['auth', 'admin'],
        methods:{
            buscaMember(user){
                this.$store.dispatch('member/fetchMember', user.id)
            },
            fetchUsers(){
                this.$store.dispatch('auth/fetchUsers');
            }
        },
        computed: {
            ...mapGetters({users: 'auth/users'})
        },
        mounted(){
            this.fetchUsers();
        },
        created(){
        },
        metaInfo () {
            return { title: this.$t('members_manager') }
        }
    }
</script>


<style scoped>

</style>
