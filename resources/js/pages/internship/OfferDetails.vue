<template>
  <div>
    <InternshipDetailsAvailable v-if="project.status === 'Hiring'" />
    <InternshipDetailsOngoing v-else-if="project.status === 'Ongoing'" />
    <InternshipDetailsFinished v-else-if="project.status === 'Finished'" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import InternshipDetailsAvailable from '~/components/InternshipDetails/InternshipDetailsHiring'
import InternshipDetailsOngoing from '~/components/InternshipDetails/InternshipDetailsOngoing'
import InternshipDetailsFinished from '~/components/InternshipDetails/InternshipDetailsFinished'

export default {
  name: 'OfferDetailsPage',

  components: { InternshipDetailsAvailable, InternshipDetailsOngoing, InternshipDetailsFinished },

  metaInfo () { return { title: this.offer.internship.title } },

  computed: {
    ...mapGetters({
      project: 'visit/project'
    })
  },

  mounted () {
    this.getDetails()
  },

  methods: {
    async getDetails () {
      await this.$store.dispatch('visit/fetchVisitedProject', {
        id: this.$route.params.id
      })
    }
  }

}
</script>
