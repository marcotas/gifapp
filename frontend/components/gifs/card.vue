<template>
  <div class="card active position-relative rounded-lg overflow-hidden">
    <img
      :src="tinygif.url"
      :style="{ height }"
      :alt="tinygif.dims[1]"
      @load="onLoad"
      class="card-img-top rounded-lg"
    />

    <div class="action-icons d-flex align-items-center">
      <div class="cursor-pointer icon mr-2" @click="$emit('share', gif)">
        <v-icon name="regular/share-square" inverse />
      </div>

      <div class="cursor-pointer icon" :class="{favorite: isFavorite}" @click="toggleFavorite(gif)">
        <v-icon v-if="!isFavoriting" :name="favoriteIcon" :spin="isFavoriting" inverse />
        <b-spinner v-if="isFavoriting" small class="text-white" style="border-width: 2px" />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  props: {
    gif: { required: true, type: Object }
  },

  data: () => ({
    loaded: false
  }),

  computed: {
    tinygif() {
      return this.gif.media[0].tinygif
    },
    height() {
      return this.loaded ? 'auto' : this.tinygif.dims[1] + 'px'
    },
    favoriteIcon() {
      return this.isFavorite ? 'heart' : 'regular/heart'
    },
    isFavorite() {
      return this.$store.getters['favorites/isFavorite'](this.gif)
    },
    isFavoriting() {
      return this.$store.getters['favorites/isFavoriting'](this.gif)
    }
  },

  methods: {
    ...mapActions({
      toggleFavorite: 'favorites/toggleFavorite'
    }),

    onLoad() {
      this.loaded = true
    }
  }
}
</script>

<style lang="scss" scoped>
.card {
  position: relative;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  will-change: transform, box-shadow;
  border: 0;

  img {
    background-color: lighten($color: #6c757d, $amount: 20);
  }

  .action-icons {
    position: absolute;
    transform: translateY(-100%);
    transition: all 0.2s ease;
    top: 0;
    right: 0;
    padding: 10px;
    background-color: rgba(0, 0, 0, 0);
    border-bottom-left-radius: 24px;
    box-shadow: 0 0 15px 15px rgba(0, 0, 0, 0);

    .icon {
      display: flex;
      position: relative;
      transition: all 0.2s ease;
      opacity: 0;
    }

    .favorite {
      position: relative;
      bottom: -36px;
      opacity: 1;
    }
  }

  &:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 15px -8px rgba(0, 0, 0, 0.5);

    .action-icons {
      transform: translateY(0);
      opacity: 1;
      background-color: rgba(0, 0, 0, 0.25);
      box-shadow: 0 0 15px 15px rgba(0, 0, 0, 0.25);

      .icon {
        opacity: 1;
      }

      .favorite {
        bottom: 0;
      }
    }
  }
}
</style>
