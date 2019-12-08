<template>
  <div class="container">
    <Header />
    <nuxt />
  </div>
</template>

<script>
import Header from '@/components/Header'

export default {
  components: { Header },
  middleware: 'auth'
}
</script>
