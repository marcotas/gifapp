<template>
  <div>
    <masonry :cols="{ default: 4, 1000: 3, 700: 2, 400: 1 }" :gutter="20">
      <gif-card
        class="mb-3"
        @share="share"
        v-for="gif of gifs"
        :key="gif.id"
        :gif="gif"
      />
    </masonry>

    <b-modal ref="shareModal" hide-footer title="Share GIF">
      <div class="details" :class="{ active: !fetching }" v-if="gif">
        <div class="d-block text-center">
          <img :src="gif.url" alt class="img-fluid rounded-lg mb-3" />
        </div>

        <div class="form-group">
          <label>Short Url</label>
          <input
            type="text"
            :value="shortUrl"
            class="form-control cursor-pointer"
          />
        </div>

        <div class="form-group">
          <label>GIF Url</label>
          <input
            type="text"
            :value="tenorGif.itemurl"
            class="form-control cursor-pointer"
          />
        </div>
      </div>

      <div
        v-if="fetching"
        class="d-flex text-muted align-items-center justify-content-center"
        style="height: 200px"
      >
        <b-spinner></b-spinner>
        <h3 class="mb-0 ml-3">Loading...</h3>
      </div>
    </b-modal>
  </div>
</template>

<style lang="scss" scoped>
.details {
  transform: translateY(-50px);
  transition: all 0.2s ease;
  height: 0;
  opacity: 0;

  &.active {
    transform: translateY(0);
    height: auto;
    opacity: 1;
  }
}
</style>

<script>
import GifCard from '@/components/gifs/card'
import { mapActions, mapState } from 'vuex'

export default {
  components: { GifCard },

  props: {
    gifs: { required: true, type: Array }
  },

  data: () => ({
    tenorGif: null,
    shortUrl: null
  }),

  computed: {
    fetching() {
      return this.$store.state.gifs.fetching
    },

    gif() {
      return this.tenorGif && this.tenorGif.media[0].gif
    }
  },

  methods: {
    ...mapActions('gifs', ['getShortUrl']),

    async share(gif) {
      this.tenorGif = gif
      this.$refs.shareModal.show()
      this.shortUrl = await this.getShortUrl(this.tenorGif)
    }
  }
}
</script>
