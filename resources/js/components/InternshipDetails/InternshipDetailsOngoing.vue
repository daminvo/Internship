<template>
  <div class="project-details--container">
    <div class="details--top-container">
      <div>
        <div class="project-details--image-container">
          <div class="project-details--image">
            <expandable-image
              :src="getThumbnail(offer.photo)"
              :close-on-background-click="true"
              class="details__image"
            />
          </div>
        </div>
      </div>
      <div v-if="$matchMedia.xl" class="details__top--left">
        <div class="z-1">
          <h1 class="project-details--h1 text-outline--thin">
            {{ offer.internship.title }}
          </h1>
        </div>
        <div class="project-details--action-button">
          <router-link class="btn btn--blue btn--large" v-if="user.role != 'manager'" :to="{ name: 'offer.apply' , params: { title: offer.internship.title, internshipId: offer.internship.id } }" tag="button">
            Apply To Offer
          </router-link>
          <button v-debounce:300ms="toggleWishlist" :debounce-events="'click'" class="btn btn--white btn--large" :disabled="user && user.role === 'Lecturer'">
            <div v-show="offer.is_favorited && offer.is_favorited.status" class="flex">
              <span class="iconify" data-icon="ic:round-remove-circle-outline" width="24" height="24" />
            </div>
            <div v-show="!offer.is_favorited || !offer.is_favorited.status" class="flex">
              <span class="iconify" data-icon="ic:round-add-circle-outline" width="24" height="24" />
            </div>
            <span>Favorite</span>
          </button>
        </div>
      </div>
      <div v-else class="mb-2_5">
        <h1 class="project-details--h1">
          {{ offer.internship.title }}
        </h1>
      </div>

      <div v-if="!$matchMedia.xl">
        <div v-if="offer.internship.state === 'available'" class="project-details--action-button">
          <router-link class="btn btn--blue btn--large" v-if="user.role == 'manager'" :to="{ name: 'offer.apply', params: { title: offer.internship.title , internshipId: offer.internship.id } }" tag="button" @click="apply">
            Apply To Offer
          </router-link>
          <button v-debounce:400ms="toggleWishlist" class="btn btn--white btn--large" :disabled="user && user.role === 'Lecturer'" :debounce-events="'click'">
            <div v-show="offer.is_favorited && offer.is_favorited.status" class="flex">
              <span class="iconify" data-icon="ic:round-remove-circle-outline" width="24" height="24" />
            </div>
            <div v-show="!offer.is_favorited || !offer.is_favorited.status" class="flex">
              <span class="iconify" data-icon="ic:round-add-circle-outline" width="24" height="24" />
            </div>
            <span>Favorite</span>
          </button>
        </div>
      </div>

      <div v-if="!$matchMedia.xl">
        <div>
          <h3 class="project-dashboard__h3">
            Project Participants
          </h3>
          <div class="project-dashboard__list-team">
            <div v-for="(e, index) in members" :key="`ProjectParticipant-${index}`" class="project-dashboard__list-team--item">
              <router-link :to="{ path: '/@/' + e.id }">
                <img :src="e.photo" alt="" class="project-dashboard__list-team--img">
              </router-link>

              <div class="">
                <p class="project-dashboard__list-team--name">
                  {{ e.first_name }} {{ e.family_name }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h2 v-if="!$matchMedia.xl" id="project-details" v-scroll-to="'#project-details'" class="project-details--h2">
        <a href="#project-details" class="button__project--more">
          <span class="iconify" data-icon="zmdi:more" />
          <span>Internship Details</span>
        </a>
      </h2>
    </div>

    <hr v-if="$matchMedia.xl" class="form--hr">

    <div class="desktop-details__body">
      <div class="project-details--main-body">
        <div v-if="!$matchMedia.xl" class="project-details__lecturer-info">
          <div class="lecturer-info--left">
            <div class="lecturer-info--image-container mr-1">
              <router-link :to="{ path: '/@/' + offer.internship.manager.user.id}" class="lencturer-text-link">
                <img :src="offer.internship.manager.user.photo">
              </router-link>
            </div>

            <div>
              <div><strong>Posted By</strong></div>
              <div>{{ offer.internship.manager.user.first_name }} {{ offer.internship.manager.user.first_name }}</div>
            </div>
          </div>
          <div class="lecturer-info--right">
            <span class="iconify" data-icon="dashicons:share" width="30" height="30" />
          </div>
        </div>

        <div>
          <div class="project-description">
            <h3>Description</h3>
            <p>{{ offer.internship.description }}</p>
          </div>

        </div>
        <div v-if="!$matchMedia.xl" class="project-summary">
          <h2 class="summary--h2">
            Summary Project
          </h2>
          <div class="summary--items">
            <div v-for="(summary, index) in summaries" :key="`SummaryItem-${index}`" class="summary--item">
              <template v-if="summary.type === 'icon'">
                <div class="summary-icon">
                  <span class="iconify" :data-icon="summary.icon" width="15" height="15" />
                </div> {{ summary.text }}
              </template>
              <template v-else>
                <div class="summary-icon">
                  <span class="summary--text-icon">{{ summary.icon }}</span>
                </div> {{ summary.text }}
              </template>
            </div>
          </div>
        </div>
      </div>
      <div class="desktop__body--right">
        <div v-if="$matchMedia.xl" class="lecturer-info--left">
          <div class="lecturer-info--image-container mr-1">
            <router-link :to="{ path: '/@/' + offer.internship.manager.user.id}" class="lencturer-text-link">
              <img :src="offer.internship.manager.user.photo">
            </router-link>
          </div>

          <div class="details__poster--info">
            <p><strong>Posted By</strong></p>
            <div>{{ offer.internship.manager.user.first_name }} {{ offer.internship.manager.user.family_name }}</div>
          </div>
        </div>
        <div v-if="$matchMedia.xl" class="project-summary">
          <div class="details__share--container">
            <h2 class="">
              Share
            </h2>
            <div class="flex-row share__button--container">
              <div class="details__share--button" @click="copyToClipboard">
                <span class="iconify details__share--icon" data-icon="ic:round-link" />
                <span>{{ copyText }}</span>
              </div>
              <ShareNetwork
                v-for="network in networks" :key="network.network"
                :class="`details__share--button`"
                :network="network.network"
                :url="sharing.url"
                :title="sharing.title"
                :description="sharing.description"
              >
                <span class="iconify details__share--icon" :data-icon="network.icon" />
                <span>{{ network.name }}</span>
              </ShareNetwork>
            </div>
          </div>

          <div>
            <h2 class="summary--h2">
              Summary Project
            </h2>
            <div class="summary--items">
              <div v-for="(summary, index) in summaries" :key="`SummaryItem-${index}`" class="summary--item">
                <template v-if="summary.type === 'icon'">
                  <div class="summary-icon">
                    <span class="iconify" :data-icon="summary.icon" width="24" height="24" />
                  </div> {{ summary.text }}
                </template>
                <template v-else>
                  <div class="summary-icon">
                    <span class="summary--text-icon">{{ summary.icon }}</span>
                  </div> {{ summary.text }}
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="$matchMedia.xl">
      <div>
        <h3 class="project-dashboard__h3 mt-3">
          Project Participants
        </h3>
        <div class="project-dashboard__list-team">
          <div v-for="(e, index) in offer.internship.intern" :key="`ProjectParticipant-${index}`" :class="['project-dashboard__list-team--item', !isSelf ? 'list-team-small' : '']">
            <router-link :to="{ path: '/@/' + e.id }">
              <img :src="getImageUrl(e.student.user.photo)" alt="" class="project-dashboard__list-team--img">
            </router-link>

            <div class="">
              <p class="project-dashboard__list-team--name">
                {{ e.student.user.first_name }} {{ e.student.user.family_name }}
              </p>
            </div>
            <button v-if="isSelf" class="custom-btn btn--border" @click="$router.push(`/presenceIntern=${e.id}`)">
              <span class="iconify" data-icon="carbon:add-alt" width="15" height="15"/>
              &nbsp;
                Add Presence
            </button>
            <button v-if="isSelf" class="custom-btn btn--blue" @click="$router.push(`/noteIntern=${e.id}`)">
              <span class="iconify" data-icon="carbon:add-alt" width="15" height="15" />
              &nbsp;
                Add Marks
            </button>
          </div>
        </div>
      </div>

      <div class="desktop__other-projects">
        <h2 class="other-projects__h2">
          Other Projects You Might Like
        </h2>
        <div class="project--container">
          <content-placeholders
            v-for="i in 3"
            v-show="!projects"
            :key="`placeholder-${i}`"
            class="content-placeholders-container"
            :rounded="true"
          >
            <content-placeholders-img />
            <content-placeholders-heading />
          </content-placeholders>
          <ProjectCard v-for="(project, index) in projects" :key="`ProjectCard-${index}`" :data="project" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as timeago from 'timeago.js'

import { mapGetters } from 'vuex'
import axios from 'axios'
import ProjectCard from '~/components/ProjectCard'
// import snarkdown from 'snarkdown'

export default {
  name: 'InternshipDetailsOngoing',

  components: { ProjectCard },

  metaInfo () {
    return { title: this.offer ? this.offer.internship.title : '' }
  },

  data: () => ({
    projects: null,
    debounceFetchSimilar: '',
    beenFetchSimilar: false,
    bgBubble: 'blue',
    copyText: 'Copy',
    image: '/images/img-placeholder.png',
    networks: [
      { network: 'facebook', name: 'Facebook', icon: 'fa-brands:facebook-f' },
      { network: 'telegram', name: 'Telegram', icon: 'fa-brands:telegram-plane' },
      { network: 'twitter', name: 'Twitter', icon: 'fa-brands:twitter' },
      { network: 'whatsapp', name: 'Whatsapp', icon: 'fa-brands:whatsapp' }
    ]

  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      offer: 'visit/offer',
      snackbar: 'notification/snackbar'
    }),

    sharing () {
      return {
        url: window.location.href,
        title: this.offer.internship.title ? this.offer.internship.title : 'undefined',
        description: this.offer.internship.description
      }
    },

    isSelf () {
      if (this.user) return this.user.id === this.offer.internship.manager.user.id

      return false
    },

    summaries () {
      return [
        // { type: 'icon', icon: 'fa-solid:dollar-sign', text: this.rewards },
        { type: 'icon', icon: 'ic:round-access-time', text: `Posted ${this.getHumanDate(this.offer.internship.demand_date)}` },
        // { type: 'icon', icon: 'ic:baseline-work', text: `${this.totalApplicants} Total Applicants` },
        { type: 'icon', icon: 'ic:round-supervisor-account', text: `Max ${this.offer.nmbr_positions}` },
        { type: 'icon', icon: 'ant-design:star-filled', text: `${this.offer.internship.duration} months` },
        // { type: 'text', icon: 'LVL', text: this.project.level_applicant },
        // { type: 'text', icon: 'Pts', text: `Require Minimal ${this.minimumPoints} Points for each Person` }
      ]
    },

    applyRoute () {
      return 'project.apply.individual'
    },

    rewards () {
      if (this.project.salary) {
        const paymentType = this.project.payment_type === 'person' ? 'for each person' : 'for whole project'

        return `${new Intl.NumberFormat('id-ID').format(this.project.salary_amount)},- ${this.project.currency} ${paymentType} ${this.project.certificate ? `+ Certificate` : ''}`
      }

      return 'Certificate'
    },

    maxPerson () {
      const type = this.project.max_person === 1 ? 'Person' : 'Persons'
      return `Max. ${this.project.max_person} ${type} (${this.project.applicant_type})`
    },

    totalApplicants () {
      return this.project.individual_applicants_count
    },

    projectReview () {
      return { 'icon': 'whh:website',
        'link': this.project.project_review.project_result ? this.project.project_review.project_result : '',
        'linkFiltered': this.project.project_review.project_result ? this.filterLink(this.project.project_review.project_result) : '' }
    }
  },

  watch: {
    $route (to, from) {
      if (to.name === from.name) {
        this.getDetails()
        this.activateOnScroll()
        this.copyText = 'Copy'
      }
    }
  },

  mounted () {
    setTimeout(() => {
      console.log(this.offer.internship.intern)
    }, 1000);
    this.activateOnScroll()
  },

  beforeDestroy () {
    this.beenFetchSimilar = true
    window.onscroll = null
  },

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    const getThumbnail = (name) => {
      if (name === null) return '24expJWNFQ0oAnpzlCNDG0Rs0.png'
      else return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    return { getImageUrl, getThumbnail }
  },

  methods: {
    async similarProjects () {
      await axios.get(`/api/project/${this.$route.params.id}/similar`)
        .then(({ data }) => {
          this.projects = data
        })

      this.beenFetchSimilar = true
      window.onscroll = null
    },

    getHumanDate: function (date) {
      return timeago.format(date)
    },

    async getDetails () {
      await this.$store.dispatch('visit/fetchVisitedProject', {
        id: this.$route.params.id
      })
    },

    async toggleWishlist () {
      const isWished = this.project.is_wished && this.project.is_wished.status

      await axios.post(`/api/project/${this.$route.params.id}/wishlist`, {
        status: !isWished
      })
        .then(({ data }) => {
          this.snackbar.open(data.message)
          this.$store.dispatch('auth/updateFavorites', {
            wishlists: data.wishlists
          })
          if (this.project.is_wished) {
            this.project.is_wished.status = !this.project.is_wished.status
          } else {
            this.project.is_wished = {
              status: true
            }
          }
        }).catch((e) => {
          this.snackbar.open(e.response.data.message)
          this.$router.push({ name: 'login' })
          // console.log(error.response)
        })
    },

    activateOnScroll () {
      this.projects = null
      this.beenFetchSimilar = false
      if (this.$matchMedia.xl) {
        let app = document.getElementsByTagName('html')[0]
        this.debounceFetchSimilar = ''
        window.onscroll = () => {
          clearTimeout(this.debounceFetchSimilar)
          this.debounceFetchSimilar = setTimeout(() => {
            let nearBottom = app.scrollTop + 1200 > app.scrollHeight
            if (nearBottom && !this.beenFetchSimilar) this.similarProjects()
          }, 300)
        }
      }
    },

    copyToClipboard () {
      const el = document.createElement('textarea')
      el.value = window.location.href
      el.setAttribute('readonly', '')
      el.style = { position: 'absolute', left: '-999.9rem' }
      document.body.appendChild(el)
      el.select()
      document.execCommand('copy')
      document.body.removeChild(el)

      this.copyText = 'Copied'
      this.snackbar.open('Project link copied')
    },

    filterLink (link) {
      if (link === '-') return null
      const filter = link.split('//')
      return filter[filter.length - 1]
    }
  }

}
</script>

<style scoped>
.list-team-small {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-around;
  max-width: 10.92rem;
  margin: 1.2rem;
  height: 170px;
}

.custom-btn {
  font-size: 1.5rem;
    font-weight: 400;
    width: 100%;
    border: 0.1rem solid var(--dark-blue);
    border-radius: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 3rem;
    text-decoration: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
    letter-spacing: 0.02em;
}

.custom-btn {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: flex-start;
}
</style>
