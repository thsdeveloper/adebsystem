<template>
    <v-app>
        <div>
            <toolbar/>
        </div>
        <div>
            <navigation-drawer/>
        </div>
        <v-content>
            <v-container fluid grid-list-md>
                <snackbar></snackbar>
                <child animate-in="fadeIn"></child>
            </v-container>
        </v-content>
        <v-footer>
            <v-flex py-3 text-xs-center white--text xs12>
                <div>&copy; Todos os direitos reservados {{ new Date().getFullYear() }}</div>
            </v-flex>
        </v-footer>
    </v-app>
</template>

<script>
    /* eslint-disable indent */
    import Child from '../components/Child'
    import NavigationDrawer from "../components/NavigationDrawer";
    import Snackbar from "../components/Snackbar";
    import Toolbar from "../components/Toolbar";

    export default {
        components: {
            Toolbar,
            Snackbar,
            NavigationDrawer,
            Child,
        },
        props: {
            source: String
        },
        methods: {

        }
    }
</script>
