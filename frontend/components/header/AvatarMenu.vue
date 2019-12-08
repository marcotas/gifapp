<template>
  <div class="dropdown" @click.stop="() => null">
    <div
      @click="active = !active"
      class="avatar cursor-pointer"
      :style="{
        backgroundImage:
          'url(https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?h=350&auto=compress&cs=tinysrgb)'
      }"
    ></div>

    <div
      class="dropdown-menu dropdown-menu-right show"
      :class="{ active }"
      aria-labelledby="dropdownMenuButton"
    >
      <logout-button class="dropdown-item"></logout-button>
    </div>
  </div>
</template>

<script>
import LogoutButton from '@/components/auth/LogoutButton'

export default {
  components: { LogoutButton },

  data: () => ({
    active: false
  }),

  mounted() {
    document.onclick = () => {
      this.active = false
    }
  },

  destroyed() {
    document.onclick = null
  }
}
</script>

<style lang="scss" scoped>
.dropdown {
  .avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    transition: box-shadow 0.2s ease;
    background-size: cover;
    background-position: center;

    &:hover {
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
  }

  .dropdown-menu {
    transition: all 0.2s ease;
    transform: translate(50%, -50%) scale(0);
    opacity: 0;
    will-change: opacity, transform;
    visibility: hidden;
    border: 0;
    padding: 5px;
    box-shadow: 0 15px 15px 0px rgba(0, 0, 0, 0.25);

    &.active {
      visibility: visible;
      opacity: 1;
      transform: translate(0, 0) scale(1);
    }

    .dropdown-item {
      padding: 0.25rem 1rem;
      border-radius: 0.5rem;
    }
  }
}
</style>
