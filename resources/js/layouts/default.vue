<template>
    <v-app>
        <div>
            <toolbar/>
        </div>
        <div>
            <navigation-drawer/>
        </div>
        <v-content>
            <v-container>
                <snackbar></snackbar>
                <child animate-in="fadeIn"></child>
            </v-container>
        </v-content>
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
