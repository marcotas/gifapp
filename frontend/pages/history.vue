<template>
  <div class="mx-auto" style="max-width: 500px">
    <h4 class="text-center">Search History</h4>

    <ul class="list-group mb-3">
      <li
        class="list-group-item d-flex align-items-center justify-content-between"
        v-for="(search, index) of searchHistories.data"
        :key="index"
      >
        <div class="lead">{{ search.text }}</div>

        <div class="d-flex align-items-baseline">
          <div
            class="mr-2 text-sm text-muted"
            style="font-size: 12px"
          >{{ search.updated_at | from_now }}</div>

          <div class="badge badge-secondary badge-pill">{{ search.hits }}</div>
        </div>
      </li>
    </ul>

    <button v-if="hasMore" @click="loadMore" class="btn btn-light mx-auto w-100 mb-5">Load More</button>
  </div>
</template>

<script>
export default {
  async asyncData({ $axios }) {
    const { data: searchHistories } = await $axios.get('api/searches')

    return {
      searchHistories,
      page: 1
    }
  },

  computed: {
    hasMore() {
      return (
        this.searchHistories.meta &&
        this.searchHistories.meta.last_page > 1 &&
        this.page < this.searchHistories.meta.last_page
      )
    }
  },

  methods: {
    async loadMore() {
      const params = { page: ++this.page }
      const { data: searchHistories } = await this.$axios.get('api/searches', {
        params
      })

      searchHistories.data.forEach((newSearch) =>
        this.searchHistories.data.push(newSearch)
      )
    }
  }
}
</script>
