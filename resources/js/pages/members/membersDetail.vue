<template>
    <v-layout>
        <v-flex xs12 sm12>
            <v-card>
                <v-img class="white--text" height="100px" src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                    <v-container fill-height fluid>
                        <v-layout fill-height align-content-center>
                            <v-flex md1>
                                <v-avatar size="50" color="grey lighten-4">
                                    <img :src="member.photo_url" :tile="true" :alt="member.name">
                                </v-avatar>
                            </v-flex>
                            <v-flex align-center flexbox>
                                <span class="headline">{{member.name}}</span><br>
                                <span class="body-1">{{member.email}}</span><br>
                            </v-flex>
                            <v-flex align-self-baseline>
                                <v-btn color="primary">Enviar mensagem</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-img>
                <v-card-title>
                    <v-container fill-height fluid>
                        <v-layout>
                            <v-flex md5>
                                <div class="subheading"><v-icon>card_giftcard</v-icon> {{member.details.date_birth}}</div>
                                <div class="subheading"><v-icon>account_balance_wallet</v-icon> CPF: {{member.details.cpf}}</div>
                                <div class="subheading"><v-icon>assignment_ind</v-icon> {{member.details.profession.name}}</div>
                            </v-flex>
                            <v-flex md4>
                                sdsd
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-title>
                <v-card-actions>
                    <!--<v-btn flat color="orange">Share</v-btn>-->
                    <!--<v-btn flat color="orange">Explore</v-btn>-->
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        name: "DetalheDoMebro",
        methods: {
            fetchUser(){
                var id = this.$route.params.userId;
                console.log(this.$route.params.userId);
                this.$store.dispatch('member/fetchMember', id)
            }
        },
        mounted(){
            this.fetchUser();
        },
        computed: {
            ...mapGetters({
                member: 'member/memberDetail',
            }),
        },
        beforeMount () {
            // console.log('IdUser', this.$route.params.userId)
        }
    }
</script>

<style scoped>

</style>
