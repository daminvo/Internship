<template>
  <div>
    <div class="project--container">
      <ProjectCard v-for="fav in favorites" :key="fav.id"
                   :data="fav.offer"
      />
      <p v-if="favorites.length === 0" class="info__p">
        Show your interest towards some projects :)
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ProjectCard from '~/components/ProjectCard'

export default {
  name: 'UserProfileWishlistsPage',
  scrollToTop: false,

  components: { ProjectCard },

  metaInfo () { return { title: 'Profile Wishlists' } },

  data: () => ({
    favorites: '',
    searchQuery: ''
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      data: 'auth/data'
    })
  },

  mounted () {
    this.getFavorites()
  },

  methods: {
    async getFavorites () {
      this.favorites = this.data.favorites
    }
  }
}
</script>
