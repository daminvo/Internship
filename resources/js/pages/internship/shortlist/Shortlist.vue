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
              <img class="shortlist-avatar" :src="applicantDetails.photo" alt="">
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
        <button v-show="!applicantDetails.isAccepted" class="btn btn--blue btn--large ml-auto" @click="acceptIndividualModal()">
          Accept
        </button>
        <button v-show="applicantDetails.isAccepted" class="btn btn--decline btn--large ml-auto" @click="acceptIndividualModal()">
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

  metaInfo () { return { title: 'Shortlist Individual' } },

  data: () => ({
    // page: 1,
    individuals: [],
    applicantDetails: {
      isAccepted: false
    }
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar',
      // data: 'page/shortlistIndividuals'
    }),

  },

  mounted () {
    this.getIndividuals()
  },

  methods: {
    getIndividuals() {
      axios.post('')
    },

    async acceptIndividual (e) {
      this.individuals[e.index].isAccepted = e.isAccepted
    },

    async acceptIndividualModal () {
      this.individuals[this.applicantDetails.index].isAccepted = !this.individuals[this.applicantDetails.index].isAccepted
      this.$refs.showApplicantDetails.closeModal()
    },

    async showDetails (e) {
      this.applicantDetails = e
      this.$refs.showApplicantDetails.openModal()
    },

  }

}
</script>

<style>
</style>
