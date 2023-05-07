<template>
  <div>
    <div class="project--container">
      <ProjectCard v-for="internship in internships" :key="`project-${internship.id}`"
                   :data="internship"
      />
      <p v-if="internships.length === 0" class="info__p">
        Let fill this page with some projects
      </p>
    </div>
  </div>
</template>

<script>
import ProjectCard from '~/components/ProjectCard'
import { mapGetters } from 'vuex'

export default {
  name: 'UserProfileProjectsPage',
  scrollToTop: false,

  components: { ProjectCard },

  metaInfo () { return { title: 'Profile Projects' } },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      data: 'auth/data'
    }),

    internships () {
      if (this.user.role === 'student') {
        return this.data.internships.map(e => e.internship)
      }

      return this.data.internships
    }
  }
}
</script>
