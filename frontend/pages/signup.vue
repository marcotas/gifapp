<template>
  <div class="login-container">
    <div class="card login mx-auto border-0 shadow-lg">
      <div class="card-body">
        <h3 class="card-title text-center mb-3">Sign Up</h3>

        <div class="form-group">
          <input
            type="text"
            v-model="form.name"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('name') }"
            placeholder="Name"
          />
          <div class="invalid-feedback">{{ form.errors.get('name') }}</div>
        </div>

        <div class="form-group">
          <input
            type="text"
            v-model="form.email"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('email') }"
            placeholder="E-mail address"
          />
          <div class="invalid-feedback">{{ form.errors.get('email') }}</div>
        </div>

        <div class="form-group">
          <input
            type="password"
            v-model="form.password"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('password') }"
            placeholder="Password"
          />
          <div class="invalid-feedback">{{ form.errors.get('password') }}</div>
        </div>

        <div class="form-group">
          <input
            type="password"
            v-model="form.password_confirmation"
            class="form-control"
            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
            placeholder="Password Confirmation"
          />
          <div class="invalid-feedback">
            {{ form.errors.get('password_confirmation') }}
          </div>
        </div>

        <button @click="signup(form)" class="btn btn-primary btn-block">
          Register
          <v-icon
            v-if="form.submitting"
            name="spinner"
            class="ml-1"
            spin
          ></v-icon>
        </button>

        <nuxt-link
          :to="{ name: 'signin' }"
          class="text-center w-100 d-block mt-3"
          >or Sing In</nuxt-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import Form from '~/components/form'
import { mapActions } from 'vuex'

export default {
  layout: 'guest',

  data() {
    return {
      form: new Form().setHttp(this.$axios)
    }
  },

  methods: {
    ...mapActions({
      signup: 'auth/signup'
    })
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
      width: 400px;
    }
  }
}
</style>
