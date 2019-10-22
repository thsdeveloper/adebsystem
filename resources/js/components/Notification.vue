<template>
  <v-menu offset-y left :close-on-content-click="false" max-width="380px" min-width="380px">
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-badge color="red darken-4" v-if="notifications.length > 0">
          <span slot="badge" class="badge-criativa">{{notifications.length}}</span>
          <v-icon>notifications</v-icon>
        </v-badge>
        <v-icon v-else>notifications</v-icon>
      </v-btn>
    </template>
    <v-list three-line subheader avatar>
      <v-subheader>
        <v-icon>notifications</v-icon>
        NOTIFICAÇÕES
        <v-btn icon right absolute @click.prevent="markAllAsRead" v-if="notifications.length > 0">
          <v-icon color="grey lighten-1">done_all</v-icon>
        </v-btn>
      </v-subheader>
      <v-list-item-group v-model="item" color="primary">
        <v-list-item v-for="(item, i) in items" :key="i">
          <v-list-item-avatar>
            <v-img :src="item.avatar"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title v-html="item.title"></v-list-item-title>
            <v-list-item-subtitle v-html="item.subtitle"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-menu>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "Notification",
        data() {
            return {
                item: 5,
                items: [
                    {
                        avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
                        title: 'Solicitação de amizade!',
                        subtitle: "<span class='text--primary'>Bruno Alves</span> &mdash; solicitou sua amizade dentro do AdebSystem?",
                    },
                    {
                        avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
                        title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
                        subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend.",
                    },
                    {
                        avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                        title: 'Oui oui',
                        subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?",
                    },
                    {
                        avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
                        title: 'Birthday gift',
                        subtitle: "<span class='text--primary'>Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?",
                    },
                    {
                        avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
                        title: 'Recipe to try',
                        subtitle: "<span class='text--primary'>Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos.",
                    },
                ],
            }
        },
        methods: {
            markAsRead(id) {
                this.$store.dispatch('notification/markAsRead', {id: id});
            },
            markAllAsRead() {
                this.$store.dispatch('notification/markAllAsRead');
            },
            clickNotification() {
                // alert('Você clicou na notificação')
            },
            listenForChanges() {
                Echo.private('App.Models.User.' + this.user.id).notification(notification => {
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
        computed: {
            ...mapGetters({
                notifications: 'notification/notifications',
                user: 'auth/user'
            }),
        },
        created() {
            this.listenForChanges();

            this.$store.dispatch('notification/fetchNotifications');
        }

    }
</script>

<style scoped>

</style>
