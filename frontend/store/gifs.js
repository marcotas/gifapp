export const state = () => ({
  shortUrls: {},
  fetching: false
})

export const mutations = {
  setShortUrl (state, { tenorGif, shortUrl }) {
    state.shortUrls[tenorGif.id] = shortUrl
  },

  fetchingShortUrl (state, status) {
    state.fetching = status
  }
}

export const actions = {
  async getShortUrl ({ state, dispatch }, tenorGif) {
    const shortUrl =
      state.shortUrls[tenorGif.id] ||
      (await dispatch('fetchShortUrl', tenorGif))

    return shortUrl
  },

  async fetchShortUrl ({ commit }, tenorGif) {
    commit('fetchingShortUrl', true)
    const { data } = await this.$axios.post('api/short-url', {
      url: tenorGif.itemurl
    })
    commit('fetchingShortUrl', false)

    const shortUrl = data.short_url
    commit('setShortUrl', { tenorGif, shortUrl })

    return shortUrl
  }
}
