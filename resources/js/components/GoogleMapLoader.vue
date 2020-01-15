<template>
  <div>
    <v-row>
      <v-col>
        <GmapMap :center="center" :zoom="zoom" :map-type-id="mapType" style="width: 100%; height: auto">

          <GmapMarker :key="index" v-for="(m, index) in markers" :position="m"
                      :clickable="true"
                      label="ADEB"
                      :opacity="1.0"
                      :draggable="true"
                      @click="infoIgreja"
                      title="Arraste o ponteiro para o endereço"
                      @dragend="gMapFunc($event.latLng)"/>

        </GmapMap>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    name: 'GoogleMapLoader',
    props: {
      center: {
        type: Object,
        default: () => ({
          lat: -15.7825066,
          lng: -47.7501889,
        }),
      },
      zoom: {
        type: Number,
        default: 10
      },
      mapType: {
        type: String,
        default: 'roadmap'
      },
      markers: {
        type: Array,
        default: () => []
      }
    },

    data () {
      return {

      }
    },

    mounted () {
    },

    methods: {
      infoIgreja (e) {
        console.log(e)
      },
      gMapFunc (event) {
        console.log(event.lat())
        // this.jdata = {"geo": {"lat":evnt.lat(), "lng":evnt.lng()}};
      },
    }
  }
</script>
