<template>
    <v-app>
        <div>
            <navbar v-on:click="abrirOuFechar" />
        </div>
        <div>
            <navigation-drawer/>
        </div>
        <v-content>
            <v-container fluid>
                <child animate-in="fadeIn"></child>
            </v-container>
        </v-content>
        <v-footer class="pa-3 text-xs-center">
            <v-spacer></v-spacer>
            <div>&copy; Todos os direitos reservados {{ new Date().getFullYear() }}</div>
        </v-footer>
    </v-app>
</template>

<script>
    /* eslint-disable indent */
    import Navbar from '~/components/Navbar'
    import Child from '../components/Child'
    import NavigationDrawer from "../components/NavigationDrawer";

    export default {
        components: {
            NavigationDrawer,
            Child,
            Navbar
        },
        props: {
            source: String
        },
        methods: {
            abrirOuFechar(e){
                this.drawer = true;
            }
        }
    }
</script>
