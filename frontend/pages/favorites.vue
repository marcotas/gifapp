<template>
  <div>
    <h3 class="text-secondary text-center mb-4">My Favorite Gifs</h3>

    <gif-list :gifs="gifs"></gif-list>
    <button v-if="hasMore" @click="loadMore" class="btn btn-light">Load more</button>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import GifList from '@/components/gifs/list'

async function fetchGifs(tenor, ids) {
  const params = { ids: ids.join(',') }
  const { data } = await tenor.get('gifs', { params })
  return data.results
}

export default {
  components: { GifList },

  async asyncData({ $tenor, store }) {
    const limit = 20
    let cursor = 0,
      ids = store.state.favorites.favorites.slice(cursor, limit + cursor)

    const gifs = await fetchGifs($tenor, ids)
    cursor += limit

    return { cursor, limit, gifs, loadingMore: false }
  },

  created() {
    window.onscroll = () => {
      const totalHeight = document.documentElement.offsetHeight
      const bottomOfWindow =
        document.documentElement.scrollTop + window.innerHeight >=
        document.documentElement.offsetHeight - 1000

      if (bottomOfWindow && this.hasMore) {
        this.loadMore()
      }
    }
  },

  computed: {
    ...mapState('favorites', ['favorites']),
    ids() {
      return this.favorites.slice(this.cursor, this.limit + this.cursor)
    },
    hasMore() {
      return this.cursor < this.favorites.length
    }
  },

  methods: {
    async loadMore() {
      if (this.loadingMore) {
        return
      }

      this.loadingMore = true
      const gifs = await this.fetchGifs()
      this.loadingMore = false
      this.gifs = this.gifs.concat(gifs)
    },

    async fetchGifs() {
      const gifs = await fetchGifs(this.$tenor, this.ids)
      this.cursor += this.limit
      return gifs
    }
  }
}
</script>
