<template>
  <a href="#" @click.prevent="startLogout">Logout</a>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  methods: {
    ...mapActions({
      logout: 'auth/logout'
    }),
    startLogout() {
      this.logout()
      this.$router.push('/signin')
    }
  }
}
</script>
