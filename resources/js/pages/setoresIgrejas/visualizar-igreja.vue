<template>
    <v-container>
        <v-row>
            <v-col cols="6">
                <v-card class="mx-auto">
                    <v-img class="white--text align-end" height="150px"
                           src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">
                        <v-card-title>{{igreja.nome_igreja}} - Setor: {{igreja.setor.codigo_setor}}</v-card-title>
                    </v-img>
                    <v-card-subtitle class="pb-0">Pastor: {{igreja.pastor.name}} | Co-pastor:
                        {{igreja.co_pastor.name}}
                    </v-card-subtitle>
                    <v-card-text class="text--primary">
                        <div>Endereço: {{igreja.endereco.address}}, {{igreja.endereco.neighborhood}}</div>
                        <div>Whitsunday Island, Whitsunday Islands</div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="orange" text>
                            Share
                        </v-btn>
                        <v-btn color="orange" text>
                            Explore
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card max-height="200px">
                    <GmapMap :center="{ lat: -15.7825066, lng: -47.7501889}" :zoom="14" map-type-id="roadmap"
                             style="width: 100%; height: 200px">
                        <GmapMarker :key="index" v-for="(m, index) in markers" :position="m"
                                    :clickable="true"
                                    label="ADEB"
                                    :opacity="1.0"
                                    :draggable="true"
                                    title="Arraste o ponteiro para o endereço"/>
                    </GmapMap>
                </v-card>
            </v-col>
        </v-row>
        <v-row>

        </v-row>


    </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import GoogleMapLoader from '../../components/GoogleMapLoader'

  export default {
    name: 'VisualizarIgreja',
    components: { GoogleMapLoader },
    middleware: ['auth', 'permission'],

    data () {
      return {
        markers: [
          {
            lat: -15.7825066,
            lng: -47.7501889,
          }
        ]
      }
    },

    methods: {
      buscarIgreja () {
        this.$store.dispatch('igreja/visualizarIgrejaPorId', this.$route.params.id)
      }
    },
    mounted () {
      this.buscarIgreja()
    },
    computed: {
      ...mapGetters({
        igreja: 'igreja/igreja',
      }),
    },
    beforeMount () {
      // console.log('IdUser', this.$route.params.userId)
    }
  }
</script>

<style scoped>

</style>
