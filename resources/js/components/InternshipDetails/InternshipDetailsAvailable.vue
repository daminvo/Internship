<template>
  <div class="project-details--container">
    <div class="details--top-container">
      <div>
        <div class="project-details--image-container">
          <div class="project-details--image">
            <expandable-image
              :src="gethumbnail(offer.photo)"
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
          <router-link class="btn btn--blue btn--large" :to="{ name: 'offer.apply' , params: { title: offer.internship.title, internshipId: offer.internship.id } }" tag="button">
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
          <router-link class="btn btn--blue btn--large" :to="{ name: 'offer.apply', params: { title: offer.internship.title , internshipId: offer.internship.id } }" tag="button" @click="apply">
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
      <h2 v-if="!$matchMedia.xl" id="project-details" v-scroll-to="'#project-details'" class="project-details--h2">
        <a href="#project-details" class="button__project--more">
          <span class="iconify" data-icon="zmdi:more" />
          <span>Offer Details</span>
        </a>
      </h2>
    </div>

    <hr v-if="$matchMedia.xl" class="form--hr">

    <div class="desktop-details__body">
      <div class="project-details--main-body">
        <div v-if="!$matchMedia.xl" class="project-details__lecturer-info">
          <div class="lecturer-info--left">
            <div class="lecturer-info--image-container mr-1">
              <router-link :to="{ path: '/@/' + offer.internship.manager.user.id }" class="lencturer-text-link">
                <img :src="getImageUrl(offer.internship.manager.user.photo)" alt="">
              </router-link>
            </div>

            <div>
              <div><strong>Posted By</strong></div>
              <div>{{ offer.internship.manager.user.first_name }} {{ offer.internship.manager.user.family_name }}</div>
              <div>{{ offer.internship.manager.company_id }}</div>
              <!-- <div>{{ project.user.expertise }}</div> -->
            </div>
          </div>
          <div class="lecturer-info--right">
            <span class="iconify" data-icon="dashicons:share" width="30" height="30" />
          </div>
        </div>

        <div>
          <div class="project-description">
            <h3>Description</h3>
            <p>{{ offer.internship.description || "-" }}</p>
          </div>
          <div>
            <div class="project-requirements">
              <h3>Requirements</h3>
              <ul v-if="project && project.requirements && project.requirements.length > 0" class="requirements--container">
                <li v-for="req in project.requirements" :key="req.id">
                  {{ req.requirement }}
                </li>
              </ul>
              <p v-else>
                -
              </p>
            </div>
            <div class="project-skills">
              <h3>Skills</h3>
              <div v-if="project && project.skills && project.skills.length > 0" class="skills--container">
                <BubbleSkill v-for="skill in project.skills" :key="skill.id" :color="bgBubble" :name="skill.name" />
              </div>
              <p v-else>
                -
              </p>
            </div>
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
            <router-link :to="{ path: '/@/' + offer.internship.manager.user.id }" class="lencturer-text-link">
              <img :src="getImageUrl(offer.internship.manager.user.photo)" alt="">
            </router-link>
          </div>

          <div class="details__poster--info">
            <p><strong>Posted By</strong></p>
            <div>{{ offer.internship.manager.user.first_name }} {{ offer.internship.manager.user.family_name }}</div>
            <div>{{ offer.internship.manager.company_id }}</div>
            <!-- <p>{{ project.user.expertise }}</p> -->
          </div>
        </div>
        <!-- <router-link :to="{ name: 'message', params: { tagname: project.user.tagname } }" class="btn btn--blue btn--large" tag="button" :disabled="isSelf">
          Contact Lecturer
        </router-link> -->
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
              Summary Offer
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
      <div class="desktop__other-projects">
        <h2 class="other-projects__h2">
          Other Offers You Might Like
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
  name: 'InternshipDetailsAvailable',

  components: {
    ProjectCard
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

    members () {
      if (this.project.project_team) return this.project.project_team.members
      return []
    },

    sharing () {
      return {
        url: window.location.href,
        title: this.offer.internship.title ? this.offer.internship.title : 'undefined',
        description: this.offer.internship.description
      }
    },

    isSelf () {
      if (this.user) return this.user.tagname === this.project.user.tagname

      return false
    },

    summaries () {
      return [
        // { type: 'icon', icon: 'bi:brush', text: `Expertise in ${this.expertiseIn}` },
        // { type: 'icon', icon: 'fa-solid:dollar-sign', text: this.rewards },
        { type: 'icon', icon: 'ic:round-access-time', text: `Posted ${this.getHumanDate(this.offer.internship.demand_date)}` },
        // { type: 'icon', icon: 'ic:baseline-work', text: `${this.totalApplicants} Total Applicants` },
        // { type: 'icon', icon: 'ant-design:star-filled', text: `Joining Project Grant up to ${this.grantMaximumPoints} Points` },
        { type: 'icon', icon: 'ic:round-supervisor-account', text: `Max ${this.offer.nmbr_positions}` },
        { type: 'icon', icon: 'ant-design:star-filled', text: `${this.offer.internship.duration} months` },
        // { type: 'text', icon: 'Pts', text: `Require Minimal ${this.minimumPoints} Points for each Person` }
      ]
    },

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

  setup() {

    const gethumbnail = (name) => {
      return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    const getImageUrl = (name) => {
      return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { gethumbnail, getImageUrl}
  },

  mounted () {
    this.activateOnScroll()
  },

  beforeDestroy () {
    this.beenFetchSimilar = true
    window.onscroll = null
  },

  methods: {
    apply() {

    },

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
        // this.$router.push({ name: 'login' })
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
