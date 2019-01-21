<template>
  <card class="text-center">
      <h1><v-icon>warning</v-icon> Você não pode está aqui! </h1>

    <div class="links">
      <router-link :to="{ name: 'home' }">
        {{ $t('go_home') }}
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  name: 'NotPermission'
}
</script>
