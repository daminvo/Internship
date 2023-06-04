<template>
  <div class="shortlisted__container">
    <div class="shorlisted-top__container">
      <div>
        <div v-show="offer" class="shortlisted-top__image-container mt-2_5">
          <div class="project-details--image shortlisted--image">
            <img
              :src="getImageUrl(offer.photo)"
              alt="Project Photo"
              class="img"
            >
          </div>
        </div>
      </div>

      <div class="shortlisted-top__left">
        <h1 class="shortlisted--h1  mb-1_5 text-outline--thin">
          {{ offer ? offer.internship.title : '' }}
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
      offer: 'visit/offer',
      snackbar: 'notification/snackbar',
      // individuals: 'page/shortlistIndividuals',
      // teams: 'page/shortlistTeams'
    })
  },

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    return { getImageUrl }
  },

  created () {
    this.getDetails()
  },

  methods: {
    async getDetails () {
      await this.$store.dispatch('visit/fetchVisitedOffer', {
        id: this.$route.params.id
      })

      await this.$store.dispatch('page/fetchShortlist', {id: this.offer.internship.id})
    },

    async acceptStudents () {
      const acceptedStudents = this.individuals
      // .filter(e => e.manager_validation === true)

      if (acceptedStudents.individuals.length === 0) {
        return this.$router.push({ name: 'manager.projectbox' })
      }

      for (let i = 0; i < acceptedStudents.length; i++) {
        if (acceptedStudents[i].manager_validation === true) {
          await axios.post('/api/project/', {internId: acceptedStudents[i].id })
        }
        await axios.post('/api/project/', {internId: acceptedStudents[i].id })
      }

        // .then(({ data }) => {
        //   this.snackbar.open(data.message)

        //   this.$store.dispatch('notification/updateProjectBox', {
        //     projectBoxes: data.project_boxes
        //   })

        //   this.$router.push({ name: 'projectbox' })
        // })
    },
  }

}
</script>

<style>
</style>
