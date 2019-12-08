export const state = () => ({
  user: null,
  token: null
})

export const LOCAL_STORAGE_KEY = 'gifapp-auth-token'

export const mutations = {
  add (state, user) {
    state.user = user
  },
  addToken (state, token) {
    state.token = token
    this.$axios.setToken(token.access_token, 'Bearer')
    localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(token))
  },
  removeToken (state) {
    state.token = null
    localStorage.removeItem(LOCAL_STORAGE_KEY)
  },
  removeUser (state) {
    state.user = null
  }
}

export const actions = {
  async signin ({ commit, dispatch }, form) {
    const { data: token } = await this.$axios.post('/oauth/token', {
      grant_type: 'password',
      client_id: +process.env.API_CLIENT_ID,
      client_secret: process.env.API_CLIENT_SECRET,
      ...form,
      scope: ''
    })
    commit('addToken', token)
    return dispatch('fetchUser', token)
  },

  async signup ({ commit }, form) {
    try {
      const { data } = await form.save('api/signup')
      commit('add', data.user)
      commit('addToken', data.token)
      this.$router.push('/')
    } catch (error) {
      console.log('error', error)
    }
  },

  async fetchUser ({ commit }, token) {
    try {
      const { data: user } = await this.$axios.get('api/me')
      commit('add', user)
      this.commit('favorites/set', user.favorite_gifs)
      return user
    } catch (error) {
      console.log('auth error', error, error.response)
      return null
    }
  },

  logout ({ commit }) {
    commit('removeToken')
    commit('removeUser')
  }
}
