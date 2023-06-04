<template>
  <div class="shortlisted__container">
    <div class="shorlisted-top__container">
      <div>
        <div v-show="project" class="shortlisted-top__image-container mt-2_5">
          <div class="project-details--image shortlisted--image">
            <img
              :src="project.thumbnail_url"
              alt="Project Photo"
              class="img"
            >
          </div>
        </div>
      </div>

      <div class="shortlisted-top__left">
        <h1 class="shortlisted--h1  mb-1_5 text-outline--thin">
          {{ project ? project.title : '' }}
        </h1>

        <div v-if="!$matchMedia.xl" class="separator-short mb-1" />

        <h3 class="shortlisted--h3 mt-3">
          Shortlisted Student
        </h3>
      </div>
    </div>

    <div v-if="$matchMedia.xl" class="separator-short" />

    <div v-if="$matchMedia.xl" class="separator-short mb-1" />

    <div>
      <transition name="fade" mode="out-in">
        <Shortlist />
      </transition>
    </div>

    <button class="btn btn--blue btn--large btn__small--xl mx-auto" @click="acceptStudents">
      Proceed
    </button>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Shortlist from './Shortlist.vue'

export default {
  name: 'ShortlistIndex',
  layout: 'back',
  middleware: ['auth', 'manager'],
  components: { Shortlist },

  metaInfo () { return { title: 'Applicant Shortlist' } },

  data: () => ({
    applicantDetails: {
      isAccepted: false
    },

  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar',
      project: 'page/project',
      individuals: 'page/shortlistIndividuals',
      teams: 'page/shortlistTeams'
    })
  },

  mounted () {
    this.getShortlist()

  },

  methods: {
    async getShortlist () {
      await this.$store.dispatch('page/fetchShortlist', {
        project_url: this.$route.params.id
      })
    },

    async acceptStudents () {
      const acceptedStudents = {
        individuals: this.individuals.filter(e => e.isAccepted === true),
        teams: this.teams.filter(e => e.isAccepted === true)
      }

      if (acceptedStudents.individuals.length === 0 && acceptedStudents.teams.length === 0) {
        return this.$router.push({ name: 'projectbox' })
      }

      await axios.post('/api/project/' + this.$route.params.id + '/shortlist', {
        'individuals': acceptedStudents.individuals,
        'teams': acceptedStudents.teams
      })
        .then(({ data }) => {
          this.snackbar.open(data.message)

          this.$store.dispatch('notification/updateProjectBox', {
            projectBoxes: data.project_boxes
          })

          this.$router.push({ name: 'projectbox' })
        })
    },
  }

}
</script>

<style>
</style>
