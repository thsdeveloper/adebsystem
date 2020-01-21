<template>
  <v-app>
    <div>
      <toolbar/>
    </div>
    <navigation-drawer/>
    <v-content>
        <child animate-in="fadeIn"></child>
    </v-content>
  </v-app>
</template>

<script>
    /* eslint-disable indent */
    import Child from '../components/Child'
    import NavigationDrawer from "../components/NavigationDrawer";
    import Toolbar from "../components/Toolbar";

    export default {
        components: {
            Toolbar,
            NavigationDrawer,
            Child,
        },
        props: {
            source: String
        },
        methods: {}
    }
</script>
