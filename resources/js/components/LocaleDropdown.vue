<template>
    <div>
        <v-menu offset-y left>
            <v-btn icon small slot="activator">
                <v-icon>g_translate</v-icon>
                <!--{{ locales[locale] }}-->
            </v-btn>
            <v-list dense>
                <v-list dense>
                    <v-list-tile v-for="(value, key) in locales" :key="key" @click.prevent="setLocale(key)">
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ value }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { loadMessages } from '~/plugins/i18n'

    export default {
        computed: mapGetters({
            locale: 'lang/locale',
            locales: 'lang/locales'
        }),

        methods: {
            setLocale (locale) {
                if (this.$i18n.locale !== locale) {
                    loadMessages(locale)
                    this.$store.dispatch('lang/setLocale', { locale })
                }
            }
        }
    }
</script>
