<template>
  <div class="shortlist-item__container">
    <div class="shortlist-item__left-container">
      <div class="">
        <img class="shortlist-avatar" :src="getImageUrl(data.student.user.photo)" alt="">
      </div>
      <div class="shortlist-item__body">
        <div class="shortlist-item__body-top">
          <div class="shortlist-item__name">
            {{ data.student.user.first_name }} {{ data.student.user.family_name }}
          </div>
        </div>
        <div class="project-box__details--container" @click="showDetails">
          <span class="shortlist-item__details">Details</span>
        </div>
      </div>
    </div>

    <button :class="btn.class" @click="accept">
      {{ btn.text }}
    </button>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'ShortlistItemIndividual',

  props: {
    data: { type: Object, default: null },
    role: { type: String, default: null },
    index: { type: Number, default: null }
  },

  data: () => ({

  }),

  computed: {
    ...mapGetters({
      // snackbar: 'notification/snackbar'
    }),

    btn () {
      if (this.data.manager_validation) {
        return { text: 'Accepted', class: 'btn--accepted' }
      } else {
        return { text: 'Accept', class: 'btn--accept' }
      }
    }
  },

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  methods: {
    async showDetails () {
      // this.$refs.showApplicantDetails.openModal()
      this.data.index = this.index
      this.$emit('click', this.data)
    },

    async hideDetails () {
      this.$refs.showApplicantDetails.closeModal()
    },

    async accept () {
      this.data.manager_validation = !this.data.manager_validation

      this.$emit('accept', {
        index: this.index,
        manager_validation: this.data.manager_validation
      })
    }
  }
}
</script>

<style scoped>

</style>
