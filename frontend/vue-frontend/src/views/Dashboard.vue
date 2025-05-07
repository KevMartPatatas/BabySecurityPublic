<script setup>
import {RouterLink, RouterView} from "vue-router"
import {useUserStore} from "@/stores/user.js"
import LayoutAuth from "@/layouts/LayoutAuth.vue"

const userStore = useUserStore()
</script>

<template>
    <LayoutAuth v-if="userStore.userIsLoggedIn">
      <template v-slot:username>
        {{ userStore.userName }}
      </template>

      <template #email>
        {{ userStore.userEmail }}
      </template>

      <template v-slot:content>
        <RouterView />
      </template>
    </LayoutAuth>

  <RouterView v-else />
</template>

<style scoped>

</style>