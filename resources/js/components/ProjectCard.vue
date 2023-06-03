<template>
  <div class="project__card--container">
    <div class="project__card--top-container pointer">
      <router-link :to="{ name: 'offer.details', params: { id: offer.id } }">
        <img :src="getImageUrl(offer.photo)" height="150">
        <!-- loading="lazy" -->
      </router-link>
    </div>

    <div class="project__card--body-container">

      <div class="project__card--info-container">
        <h2 class="project__card--name">
          {{ offer.internship.title }}
        </h2>
        <div class="project__card--info--consistency">
          <div class="project__card--post-info">
            <div class="ellipsies">
              Posted by : {{ offer.internship.manager.user.first_name }} {{ offer.internship.manager.user.family_name }}
            </div>
            <div class="ellipsies">
              <!-- Applicant : {{ project.applicant_type }} -->
            </div>
          </div>
          <div>
            <div class="project__card--bounty-info">
              <div class="info-item--container">
                <span>
                  <span
                    class="iconify info-item--icon"
                    data-icon="fa-solid:building"

                    width="15"
                    height="15"
                  />
                </span>
                <span>{{ offer.internship.manager.company.name }}</span>
              </div>
              <div class="info-item--container">
                <span>
                  <span
                    class="iconify info-item--icon"
                    data-icon="mdi:location"

                    width="8"
                    height="15"
                  />
                </span>
                <span>{{ offer.internship.manager.company.address }}</span>
              </div>
            </div>
            <div class="project-card__extra-info--container">
              <div class="project-card__extra-info">
                <div>&bull; Posted {{ getHumanDate(offer.internship.demand_date) }}</div>
                <div>&bull; Max. {{ offer.nmbr_postions }} Person</div>
              </div>
              <button v-if="$matchMedia.xl && (!user || user.role === 'student' )" class="btn--clear" @click="showWishlist">
                <span class="iconify project-card__wish" data-icon="mdi:dots-horizontal" width="22" />
              </button>
              <div v-show="showWish" class="card-wish__container">
                <button v-debounce:400ms="toggleWishlist" class="btn btn--clear card-wish__button" :debounce-events="'click'">
                 {{ wishText }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as timeago from 'timeago.js'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'ProjectCard',

  props: {
    data: { type: Object, default: null }
  },

  data: () => {
    return {
      showWish: ''
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

    offer () {
      console.log(this.data);
      return this.data
    },

    wishText () {
      if (this.offer.is_favorited && this.offer.is_favorited.status) {
        return 'Remove from Wishlist'
      }

      return 'Add to Wishlist'
    }
  },

  setup() {

    const getImageUrl = (name) => {
      return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    return { getImageUrl }
  },

  methods: {

    getHumanDate: function (date) {
      return timeago.format(date)
    },

    showWishlist () {
      this.showWish = !this.showWish
    },

    async toggleWishlist () {
      const isWished = this.offer.is_favorited && this.offer.is_favorited.status

      await axios.post(`/api/${this.offer.id}/favorite`, {
        status: !isWished
      })
        .then(({ data }) => {
          console.log(data);
          this.snackbar.open(data.message)
          this.$store.dispatch('auth/updateFavorites', {
            favorites: data.favorites
          })
          if (this.offer.is_favorited) {
            this.offer.is_favorited.status = !this.offer.is_favorited.status
          } else {
            this.offer.is_favorited = {
              status: true
            }
          }
        }).catch( error => {
        console.log('Error:', error.response)
      console.log('Status:', error.response.status)
      console.log('Data:', error.response.data)
      })

    }
  }
}
</script>
