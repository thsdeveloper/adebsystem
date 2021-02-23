<template>
  <ais-instant-search :search-client="searchClient" index-name="users">

    <ais-autocomplete>
      <div slot-scope="{ currentRefinement, indices, refine }">
        {{refine}}
        <v-autocomplete
          type="search"
          :value="currentRefinement"
          :items="indices"
          placeholder="O que esta procurando?"
          @input="refine($event.currentTarget.value)">

          <template v-slot:selection="data">
            <li v-for="hit in index.hits" :key="hit.objectID">
              <ais-highlight attribute="name" :hit="hit"/>
            </li>
          </template>


        </v-autocomplete>

<!--       <pre>-->
<!--          Indices: {{indices}}-->
<!--       </pre>-->



        <input
          type="search"
          :value="currentRefinement"
          placeholder="O que esta procurando?"
          @input="refine($event.currentTarget.value)"
        >


        <ul v-if="currentRefinement" v-for="index in indices" :key="index.indexId">
          <li>
            <h3>{{ index.indexName }}</h3>
            <ul>
              <li v-for="hit in index.hits" :key="hit.objectID">
                <ais-highlight attribute="name" :hit="hit"/>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </ais-autocomplete>

  </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite'


export default {
  components: {},

  data: () => ({
    tabs: false,
    appName: window.config.appName,
    searchClient: algoliasearch(
      'E8899U875I',
      '80969d7aeaacf9e75303435ef8ae11b8'
    ),
  }),

  computed: {},
  methods: {}
}
</script>
