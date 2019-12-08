export const state = () => ({
  favorites: [],
  favoriting: []
})

export const getters = {
  isFavorite: state => tenorGif => state.favorites.includes(+tenorGif.id),
  isFavoriting: state => tenorGif => state.favoriting.includes(+tenorGif.id)
}

export const mutations = {
  set (state, favorites) {
    state.favorites = favorites.reverse()
  },

  addFavoriting (state, tenorGif) {
    if (state.favoriting.includes(+tenorGif.id)) {
      return
    }

    state.favoriting.push(+tenorGif.id)
  },

  removeFavoriting (state, tenorGif) {
    if (!state.favoriting.includes(+tenorGif.id)) {
      return
    }

    state.favoriting = state.favoriting.filter(id => +id !== +tenorGif.id)
  }
}

export const actions = {
  async toggleFavorite ({ commit }, tenorGif) {
    commit('addFavoriting', tenorGif)
    const { data } = await this.$axios.post('api/favorites', {
      tenor_id: tenorGif.id
    })
    commit('removeFavoriting', tenorGif)
    commit('set', data.favorite_gifs)
  }
}
