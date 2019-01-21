<template>
    <v-menu offset-y left :close-on-content-click="false" max-width="380px" min-width="380px">
        <v-btn icon slot="activator">
            <v-badge color="red darken-4" v-if="notifications.length > 0">
                <span slot="badge" class="badge-criativa">{{notifications.length}}</span>
                <v-icon>notifications</v-icon>
            </v-badge>
            <v-icon v-else>notifications</v-icon>
        </v-btn>
        <v-list two-line subheader>
            <v-subheader>
                <v-icon>notifications</v-icon> Notificações
                <v-btn icon right absolute @click.prevent="markAllAsRead" v-if="notifications.length > 0">
                    <v-icon  color="grey lighten-1">done_all</v-icon>
                </v-btn>
            </v-subheader>
            <transition-group enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
                <v-list-tile v-for="(item, index) in notifications" v-bind:key="index" avatar @click.prevent="clickNotification">

                    <v-list-tile-avatar>
                        <v-avatar size="32px">
                            <img :src="item.data.image" :alt="item.data.user">
                        </v-avatar>
                    </v-list-tile-avatar>

                    <v-list-tile-content>
                        <v-list-tile-title>{{item.data.user}}</v-list-tile-title>
                        <v-list-tile-sub-title>{{item.data.message}} {{item.data.description}}</v-list-tile-sub-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-tooltip left>
                            <v-btn icon ripple slot="activator" @click.prevent="markAsRead(item.id)">
                                <v-icon  color="grey lighten-1">done</v-icon>
                            </v-btn>
                            <span>Marcar a notificação como lida</span>
                        </v-tooltip>
                    </v-list-tile-action>

                </v-list-tile>
            </transition-group>
            <v-list-tile v-if="notifications.length === 0">

                <v-list-tile-content>
                    <v-list-tile-title>Suas notificações são exibidas aqui</v-list-tile-title>
                    <v-list-tile-sub-title>Sem noficações neste momento</v-list-tile-sub-title>
                </v-list-tile-content>

            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
        name: "Notification",
        data(){
            return{

            }
        },
        methods:{
            markAsRead(id){
                this.$store.dispatch('notification/markAsRead', {id: id});
            },
            markAllAsRead(){
                this.$store.dispatch('notification/markAllAsRead');
            },
            clickNotification(){
                // alert('Você clicou na notificação')
            },
            listenForChanges(){
                Echo.private('App.Models.User.'+this.user.id).notification(notification => {
                    this.$store.dispatch('notification/addNotification', notification);
                    this.$store.dispatch('snackbar/showSnackbar', 'Acabamos de receber um post');
                    // if(! ('Notification' in window)) {
                    //     alert('Web Notification is not supported');
                    //     return;
                    // }
                    // Notification.requestPermission(permission => {
                    //     let notification = new Notification('Novo post criado!', {
                    //         body: post.text.text, // content for the alert
                    //         icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                    //     });
                    //     // link to page on clicking the notification
                    //     notification.onclick = () => {
                    //         window.open(window.location.href);
                    //     };
                    // });
                })
            }
        },
        computed:{
            ...mapGetters({
                notifications: 'notification/notifications',
                user: 'auth/user'
            }),
        },
        created(){
            this.listenForChanges();

            this.$store.dispatch('notification/fetchNotifications');
        }

    }
</script>

<style scoped>

</style>
