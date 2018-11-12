<template>
  <card class="text-center">
      <h1><v-icon>warning</v-icon>{{ $t('page_not_found') }}</h1>

    <div class="links">
      <router-link :to="{ name: 'home' }">
        {{ $t('go_home') }}
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
