<template>
  <div class="d-flex justify-content-between header">
    <nuxt-link class="text-secondary" to="/">
      <h2>GifApp</h2>
    </nuxt-link>

    <div class="d-flex align-items-center">
      <nuxt-link to="/favorites" class="mr-4">
        <v-icon name="heart"></v-icon>
      </nuxt-link>

      <nuxt-link to="/history" class="mr-4">
        <v-icon name="history"></v-icon>
      </nuxt-link>

      <avatar-menu></avatar-menu>
    </div>
  </div>
</template>

<script>
import LogoutButton from '@/components/auth/LogoutButton'
import AvatarMenu from '@/components/header/AvatarMenu'

export default {
  components: { LogoutButton, AvatarMenu }
}
</script>

<style lang="scss" scoped>
.header {
  margin: 40px 0 0;

  a {
    color: #6c757d;
    transition: color 0.2s ease;

    &:hover {
      color: #3490dc;
    }
  }
}
</style>
