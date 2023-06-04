<template>
  <div>
    <div class="mb-3" :class="{ 'shortlist-container': individuals.length > 0 }">
      <ShortlistItemIndividual v-for="(e, index) in individuals" :key="`ShortlistItemIndividual-${e.id}`" :data="e" :index="index" @click="showDetails" />
      <p v-if="individuals.length === 0" class="info__p">
        No Individual Applicants yet
      </p>
    </div>

    <div v-if="$matchMedia.xl" class="separator-short mb-1" />

    <!-- <paginate
      v-if="$matchMedia.xl"
      :page-count="pageCount"
      :page-range="7"
      :margin-pages="2"
      :click-handler="changePage"
      :prev-text="`<`"
      :next-text="`>`"
      :container-class="'pagination'"
      :page-class="'page-item'"
      :page-link-class="'page-item--link'"
      :prev-class="'page-item'"
      :prev-link-class="'page-item--link'"
      :next-class="'page-item'"
      :next-link-class="'page-item--link'"
      :active-class="'page-item--active'"
    /> -->

    <Modal ref="showApplicantDetails" :type="`medium`">
      <template v-slot:header>
        <!-- <div class="shortlist-modal__stabilizier" /> -->
        <h4 class="post__modal--h4 my-0">
          Details
        </h4>
      </template>

      <template v-slot:body>
        <div class="separator-short mb-1_5" />

        <div class="shortlist-item__container">
          <div class="shortlist-item__left-container mb-1_5">
            <router-link :to="{ name: '@.info', params: { tagname: applicantDetails.id } }">
              <img class="shortlist-avatar" :src="getImageUrl(applicantDetails.photo)" alt="">
            </router-link>
            <div class="shortlist-item__body justify-center">
              <div class="">
                <div class="shortlist-item__name">
                  {{ applicantDetails.first_name }} {{ applicantDetails.family_name }}
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="form__input--group">
          <div class="info-title">
            <h2 class="form-group__input-name form__input-name mb-1">
              Start date:
            </h2>
            <p class="apply__top--p">{{ applicantDetails.start_date }}</p>
          </div>
          <div class="info-title">
            <h2 class="form-group__input-name form__input-name mb-1">
              End date:
            </h2>
            <p class="apply__top--p">{{ applicantDetails.end_date }}</p>
          </div>
        </div>
        <!-- Why you ? -->
        <div class="form-group__container">
          <h4 class="form-group__input-name form__input-name mb-1">
            Why are you interested in joining this internship?
          </h4>
          <div class="">
            <textarea v-model="applicantDetails.motivation" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" readonly />
          </div>
        </div>
      </template>

      <template v-slot:footer>
        <button v-show="!applicantDetails.manager_validation" class="btn btn--blue btn--large ml-auto" @click="acceptIndividualModal()">
          Accept
        </button>
        <button v-show="applicantDetails.manager_validation" class="btn btn--decline btn--large ml-auto" @click="acceptIndividualModal()">
          Cancel
        </button>
      </template>
    </Modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ShortlistItemIndividual from '~/components/ShortlistItemIndividual'
import axios from 'axios'

export default {
  name: 'ShortlistIndividualPage',

  components: { ShortlistItemIndividual },

  metaInfo () { return { title: 'Shortlist' } },

  data: () => ({
    // page: 1,
    // individuals: [],
    applicantDetails: {
      manager_validation: false
    }
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      offer: 'visit/offer',
      individuals: 'page/individuals',
      snackbar: 'notification/snackbar',
    }),

  },

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },


  methods: {
    // async getIndividuals() {

    //   axios.post('/api/getInternshipIterns', {id: this.offer.internship.id})
    //     .then(res => {
    //       console.log(res.data);
    //       this.individuals = res.data
    //     })
    //     .catch( error => {
    //     console.log('Error:', error.response)
    //   console.log('Status:', error.response.status)
    //   console.log('Data:', error.response.data)
    //   })
    // },

    async acceptIndividual (e) {
      this.individuals[e.index].manager_validation = e.manager_validation
    },

    async acceptIndividualModal () {
      this.individuals[this.applicantDetails.index].manager_validation = !this.individuals[this.applicantDetails.index].manager_validation
      this.$refs.showApplicantDetails.closeModal()
    },

    async showDetails (e) {
      this.applicantDetails = e
      this.$refs.showApplicantDetails.openModal()
    },

  }

}
</script>

<style scoped>

.info-title {
  display: flex;
  flex-direction: row;
  align-items: baseline;
  justify-content: space-evenly;
}

.form__input--group {
  margin-bottom: 20px;
}
</style>
