<template>
    <v-layout>
        <v-flex>
            <v-card>
                <v-list two-line>
                    <v-subheader>
                        Membros
                    </v-subheader>

                    <vue-recyclist
                            class="lista-users"
                            :list="users.data"
                            :tombstone="true"
                            :size="10"
                            :loadmore="loadData"
                            :spinner="true"
                            :nomore="true">
                        <!-- tombstone slot -->
                        <template slot="tombstone" slot-scope="props">
                            <div class="item tombstone">
                                <div class="avatar"></div>
                                <div class="bubble">
                                    <p></p>
                                    <p></p>
                                    <p></p>
                                    <div class="meta">
                                        <time class="posted-date"></time>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <!-- item slot -->
                        <template slot="item" slot-scope="props">
                            <v-list-tile avatar :to="{ name: 'members.detail', params: { userId: props.data.id }}">
                                <v-list-tile-avatar>
                                    <img :src="props.data.photo_url">
                                </v-list-tile-avatar>


                                <v-list-tile-content>
                                    <v-list-tile-title>{{props.data.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{props.data.email}}</v-list-tile-sub-title>
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
                        </template>
                        <!-- loading spinner -->
                        <div slot="spinner">Loading...</div>
                        <!-- end of list -->
                        <div slot="nomore">No More Data</div>
                    </vue-recyclist>

                    <!--<div v-if="users">-->
                    <!--<ais-index app-id="GTUYAIQFFN" api-key="89f1f0d2d3af5b31c8438baf0d5f8c82" index-name="users">-->
                    <!--<ais-search-box></ais-search-box>-->
                    <!--<ais-input placeholder="Pesquise o usuário..." submit-title="Procurar"></ais-input>-->
                    <!--<v-text-field flat solo-inverted hide-details prepend-inner-icon="search" :label="$t('what_are_you_looking_for')" class="hidden-sm-and-down" />-->

                    <!--<ais-results>-->
                    <!--<template slot-scope="{ result }">-->

                    <!--<v-list-tile avatar :to="{ name: 'members.detail', params: { userId: result.id }}">-->
                    <!--<v-list-tile-avatar>-->
                    <!--<img :src="result.photo_url">-->
                    <!--</v-list-tile-avatar>-->

                    <!--<v-list-tile-content>-->
                    <!--<v-list-tile-title>{{result.name}}</v-list-tile-title>-->
                    <!--<v-list-tile-sub-title>{{result.email}}</v-list-tile-sub-title>-->
                    <!--</v-list-tile-content>-->

                    <!--<v-list-tile-action>-->
                    <!--<v-menu offset-y left>-->
                    <!--<v-btn icon ripple slot="activator">-->
                    <!--<v-icon color="grey lighten-1">more_vert</v-icon>-->
                    <!--</v-btn>-->
                    <!--<v-list dense>-->
                    <!--<v-list-tile to="/settings">-->
                    <!--<v-list-tile-action>-->
                    <!--<v-icon>settings</v-icon>-->
                    <!--</v-list-tile-action>-->
                    <!--<v-list-tile-content>-->
                    <!--<v-list-tile-title>-->
                    <!--{{$t('settings')}}-->
                    <!--</v-list-tile-title>-->
                    <!--</v-list-tile-content>-->
                    <!--</v-list-tile>-->
                    <!--</v-list>-->
                    <!--</v-menu>-->

                    <!--</v-list-tile-action>-->
                    <!--</v-list-tile>-->
                    <!--<v-divider></v-divider>-->
                    <!--</template>-->
                    <!--</ais-results>-->
                    <!--</ais-index>-->
                    <!--</div>-->
                </v-list>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex';
    import VueRecyclist from 'vue-recyclist'
    export default {
        name: 'ListarMembros',
        components: {
            'vue-recyclist': VueRecyclist
        },
        middleware: 'auth',
        data () {
            return {

            }
        },
        methods:{
            async loadData() {
                axios.get('/app/financeiro/pagamentos-pendentes', {
                    params: {
                        page: this.users.page,
                        pageSize: queryInfo.pageSize,
                    }
                }).then(response => {
                    this.data = response.data.data;
                    this.total = response.data.total
                    this.loadingTable = false;
                }).catch(error => {console.log(error.response.data)});
            },
            clickUser(index, item){
                console.log('Index:', index);
                console.log('Item:', item)
            },
            fetchUsers(){
                this.$store.dispatch('auth/fetchUsers')
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
