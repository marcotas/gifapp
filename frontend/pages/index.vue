<template>
  <div>
    <div
      class="input-search pt-4"
      :class="{ sticked: searchSticked }"
      ref="searchEl"
    >
      <div class="form-group">
        <input
          type="text"
          class="form-control form-control-lg rounded-pill border-0 shadow-sm mb-4 pl-5"
          placeholder="Search gifs..."
          v-model="search"
          @keyup.enter="onSearch"
        />

        <v-icon
          v-if="!searching"
          name="search"
          class="text-secondary search-icon"
        ></v-icon>

        <b-spinner
          small
          v-if="searching"
          style="border-width: 2px"
          class="text-secondary search-icon"
        ></b-spinner>
      </div>
    </div>

    <gif-list :gifs="gifs"></gif-list>
  </div>
</template>

<script>
import LogoutButton from '@/components/auth/LogoutButton'
import _ from 'lodash'
import { mapActions } from 'vuex'
import GifList from '@/components/gifs/list'
import Sticky from 'vue-sticky-directive'

const searchOffset = 84

export default {
  components: { LogoutButton, GifList },

  directives: { Sticky },

  async asyncData({ $tenor, app }) {
    const { data } = await $tenor.get('/trending')

    return {
      gifs: data.results,
      next: data.next
    }
  },

  data() {
    return {
      source: 'trending',
      gifs: [],
      next: null,
      search: null,
      suggestions: [],
      searching: false,
      loadingMore: false,
      searchSticked: false
    }
  },

  mounted() {
    const searchElement = this.$refs.searchEl

    window.onscroll = () => {
      const totalHeight = document.documentElement.offsetHeight
      const bottomOfWindow =
        document.documentElement.scrollTop + window.innerHeight >=
        document.documentElement.offsetHeight - 1000

      if (bottomOfWindow && this.next) {
        this.loadMore()
      }

      this.searchSticked = searchElement.offsetTop > searchOffset
    }
  },

  watch: {
    search: _.debounce(function(search) {
      this.fetchSuggestions(search)
    }, 300),

    searchSticked() {
      console.log('searchSticked', this.searchSticked)
    }
  },

  methods: {
    ...mapActions({
      saveSearch: 'searchHistory/saveSearch'
    }),

    async fetchSuggestions(search) {
      const params = { q: search, limit: 10 }
      const { data } = await this.$tenor.get('/search_suggestions', { params })
      this.suggestions = data.results
    },

    async searchGifs() {
      this.searching = true
      const data = await this.fetchGifs()
      this.searching = false
      this.gifs = data.results
      this.next = data.next
      this.saveSearch(this.search)
    },

    onSearch() {
      this.source = 'search'
      this.next = null
      this.searchGifs()
    },

    async fetchGifs(params = {}) {
      params = { ...params, q: this.search, pos: this.next }
      const { data } = await this.$tenor.get(this.source, { params })
      return data
    },

    async loadMore() {
      if (this.loadingMore) return
      this.loadingMore = true
      const data = await this.fetchGifs()
      this.loadingMore = false

      this.gifs = this.gifs.concat(data.results)
      this.next = data.next || null
    }
  }
}
</script>

<style lang="scss" scoped>
.input-search {
  z-index: 100;
  position: sticky;
  top: 0;
  transition: all 0.2s ease;

  .form-control {
    transition: all 0.2s ease;
  }

  &.sticked {
    padding-top: 10px !important;
    background-color: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    width: 105%;
    margin-left: -2.5%;

    .form-control {
      background-color: rgba(255, 255, 255, 0.75) !important;
      box-shadow: 0 16px 16px -5px rgba(0, 0, 0, 0.25) !important;

      &:focus,
      &:hover {
        background-color: rgba(255, 255, 255, 1) !important;
        cursor: text;
      }
      &:hover {
        cursor: pointer;
      }
    }
  }

  .form-group {
    position: relative;

    .search-icon {
      position: absolute;
      top: 0.9rem;
      left: 1rem;
    }
  }
}
</style>
