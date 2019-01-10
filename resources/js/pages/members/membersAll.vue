<template>
    <v-layout>
        <v-flex>
            <v-card>
                <v-list two-line>
                    <v-subheader>
                        Membros
                    </v-subheader>

                   <div v-for="user in users.data">
                       <v-list-tile avatar :to="{ name: 'members.detail', params: { userId: user.id }}">
                           <v-list-tile-avatar>
                               <img :src="user.photo_url">
                           </v-list-tile-avatar>


                           <v-list-tile-content>
                               <v-list-tile-title>{{user.name}}</v-list-tile-title>
                               <v-list-tile-sub-title>{{user.email}}</v-list-tile-sub-title>
                           </v-list-tile-content>

                           <v-list-tile-action>
                               <v-menu offset-y left>
                                   <v-btn icon ripple slot="activator">
                                       <v-icon color="grey lighten-1">more_vert</v-icon>
                                   </v-btn>
                                   <v-list dense>
                                       <v-list-tile to="/settings">
                                           <v-list-tile-action>
                                               <v-icon>settings</v-icon>
                                           </v-list-tile-action>
                                           <v-list-tile-content>
                                               <v-list-tile-title>
                                                   {{$t('settings')}}
                                               </v-list-tile-title>
                                           </v-list-tile-content>
                                       </v-list-tile>
                                   </v-list>
                               </v-menu>

                           </v-list-tile-action>
                       </v-list-tile>
                       <v-divider></v-divider>
                   </div>


                </v-list>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: 'ListarMembros',
        middleware: ['auth', 'admin'],
        methods:{
            clickUser(index, item){
                console.log('Index:', index);
                console.log('Item:', item)
            },
            fetchUsers(){
                this.$store.dispatch('auth/fetchUsers');
                this.$store.dispatch('toolbar/tabsVisible',{
                    tabsVisible: true,
                    menusTabs: ["Encontrar Pessoas", "Seguindo", "Liderança"]
                });
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
