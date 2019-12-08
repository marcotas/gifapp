<template>
  <div class="login-container">
    <div class="card login mx-auto shadow-lg border-0">
      <div class="card-body">
        <h3 class="card-title text-center mb-3">Sign In</h3>

        <div v-if="invalidCredentials" class="alert alert-danger">
          Invalid credentials
        </div>

        <div class="form-group">
          <input
            type="text"
            v-model="form.username"
            class="form-control"
            placeholder="E-mail address"
          />
        </div>

        <div class="form-group">
          <input
            type="password"
            v-model="form.password"
            class="form-control"
            placeholder="Password"
          />
        </div>

        <button
          @click="login"
          :disabled="loading"
          class="btn btn-primary btn-block"
        >
          Sign In
          <v-icon
            class="ml-2"
            :name="loading ? 'spinner' : 'sign-in-alt'"
            :spin="loading"
          ></v-icon>
        </button>

        <nuxt-link
          :to="{ name: 'signup' }"
          class="text-center w-100 d-block mt-3"
          >or Sing Up</nuxt-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapActions } from 'vuex'

export default {
  layout: 'guest',

  data: () => ({
    form: {},
    baseUrl: process.env.API_URL,
    invalidCredentials: false,
    loading: false
  }),

  methods: {
    ...mapActions({
      signin: 'auth/signin'
    }),

    async login() {
      try {
        this.loading = true
        await this.signin(this.form)
        this.$router.push('/')
      } catch (error) {
        this.invalidCredentials = true
        console.error(error, error.response)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;

  .login {
    max-width: 500px;

    .form-control {
      min-width: 240px;
    }
  }
}
</style>
