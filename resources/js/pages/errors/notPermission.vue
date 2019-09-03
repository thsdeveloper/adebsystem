<template>
    <v-layout align-center justify-center column fill-height>
      <v-flex md6>
        <v-card>
          <v-card-title>
            <div>
              <h1>
                Ops! Acesso não permitido.
              </h1>
              <p>Este módulo não esta habilitado para a sua conta, verifique junto ao administrador do sistema para conceder acesso.</p>
            </div>
          </v-card-title>
        </v-card>
      </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: 'NotPermission'
    }
</script>
