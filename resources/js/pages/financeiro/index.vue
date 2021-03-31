<template>
    <div>
        <router-view/>
<!--        <v-speed-dial v-model="fab" absolute bottom right direction="top" :open-on-hover="true"-->
<!--                      :transition="transition">-->
<!--            <template v-slot:activator>-->
<!--                <v-btn v-model="fab" color="blue darken-2" dark fab large>-->
<!--                    <v-icon v-if="fab">mdi-close</v-icon>-->
<!--                    <v-icon v-else>mdi-plus</v-icon>-->
<!--                </v-btn>-->
<!--            </template>-->
<!--            <v-btn fab dark small color="green" :to="{ name: 'financeiro.cadastrarReceita'}">-->
<!--                <v-icon>mdi-trending-up</v-icon>-->
<!--            </v-btn>-->
<!--            <v-btn fab dark small color="red" :to="{ name: 'financeiro.cadastrarDespesa'}">-->
<!--                <v-icon>mdi-trending-down</v-icon>-->
<!--            </v-btn>-->
<!--        </v-speed-dial>-->
    </div>
</template>
<script>
  export default {
    middleware: 'auth',
    data: () => ({
      direction: 'top',
      fab: false,
      fling: false,
      hover: false,
      tabs: null,
      top: false,
      right: false,
      bottom: true,
      left: false,
      transition: 'slide-y-reverse-transition',
    }),

    computed: {
      activeFab () {
        switch (this.tabs) {
          case 'one':
            return { class: 'purple', icon: 'account_circle' }
          case 'two':
            return { class: 'red', icon: 'edit' }
          case 'three':
            return { class: 'green', icon: 'keyboard_arrow_up' }
          default:
            return {}
        }
      },
    },
    watch: {
      top (val) {
        this.bottom = !val
      },
      right (val) {
        this.left = !val
      },
      bottom (val) {
        this.top = !val
      },
      left (val) {
        this.right = !val
      },
    },

  }
</script>
