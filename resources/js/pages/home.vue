<template>
 <v-container>
   <v-row>
     <v-col>
       <v-card>
         <v-card-title>Crescimento nos últimos anos</v-card-title>
         <v-card-text>
           <apexchart type="bar" :options="options" :series="series"></apexchart>
         </v-card-text>
       </v-card>
     </v-col>
     <v-col>
       <v-card>
         <v-card-title>Crescimento nos últimos anos</v-card-title>
         <v-card-text>
           <apexchart width="380" type="donut" :options="options" :series="series"></apexchart>
         </v-card-text>
       </v-card>
     </v-col>
   </v-row>
   <v-row>
     <v-col>
       <v-card color="#385F73" dark>
         <v-card-text class="white--text">
           <div class="headline mb-2">AdebSystem 1.0</div>
           Sistema Integrado de Gerenciamento da ADEB
         </v-card-text>

         <v-card-actions>
           <v-btn text>Contato</v-btn>
         </v-card-actions>
       </v-card>
     </v-col>
     <v-col>
       <post-time-line/>
     </v-col>
   </v-row>
 </v-container>
</template>

<script>

    import PostTimeLine from "../components/PostTimeLine";

    export default {
        components: {PostTimeLine},
        middleware: 'auth',
        metaInfo() {
            return {title: this.$t('home')}
        },
        data() {
            return {
                options: {
                    chart: {
                        id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                    }
                },
                series: [{
                    name: 'series-1',
                    data: [30, 40, 45, 50, 49, 60, 70, 91]
                }]
            }
        },
    }
</script>
<style scoped>

</style>
