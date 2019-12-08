export const state = () => ({
  searchHistories: []
})

export const actions = {
  async saveSearch ({ commit }, text) {
    if (!text) {
      return
    }

    const { data: searchHistory } = await this.$axios.post('/api/searches', {
      text
    })

    return searchHistory
  }
}
