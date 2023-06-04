<template>
  <div>
    <InternshipDetailsAvailable  v-if="offer.internship.state === 'available'"/>
    <InternshipDetailsOngoing v-else-if="offer.internship.state === 'ongoing'" />
    <!-- <InternshipDetailsFinished v-else-if="offer.internship.state === 'Finished'" /> -->
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import InternshipDetailsAvailable from '~/components/InternshipDetails/InternshipDetailsAvailable.vue'
import InternshipDetailsOngoing from '~/components/InternshipDetails/InternshipDetailsOngoing.vue'
// import InternshipDetailsFinished from '~/components/InternshipDetails/InternshipDetailsFinished.vue'

export default {
  name: 'OfferDetailsPage',

  components: {
    InternshipDetailsAvailable,
    InternshipDetailsOngoing,
    // InternshipDetailsFinished
  },

  // metaInfo () { return { title: this.offer.internship.title } },

  computed: {
    ...mapGetters({
      offer: 'visit/offer'
    })
  },

  watch: {
    offer () {
      return this.offer
    }
  },

  created () {
    this.getDetails()
  },

  methods: {
    async getDetails () {
      await this.$store.dispatch('visit/fetchVisitedOffer', {
        id: this.$route.params.id
      })
    }
  }

}
</script>
