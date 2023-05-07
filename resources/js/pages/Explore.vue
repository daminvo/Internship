<template>
  <div class="explore--container">
    <div class="explore__top--container">
      <h1 class="explore__top--h1">
        Explore for Your Internships
      </h1>

      <div class="explore__search--container">
        <div class="form-tag__group explore__search--form">
          <input
            v-if="$matchMedia.xl" v-model="query" type="search"
            class="form-tag__input"
            placeholder="Search by Project Titles"
            @keyup.enter="search"
          >
          <input
            v-else v-model="query" type="search"
            class="form-tag__input"
            placeholder="Explore by projects" @change="search"
          >
          <label for="form.user.tagname" class="form-tag"><span class="iconify" data-icon="ic:round-search" width="30" height="30" /></label>
        </div>
        <button v-if="$matchMedia.xl" v-debounce:600ms="search" :debounce-events="'click'" class="btn explore__search--button ml-1" :disabled="query.length === 0">
          Explore
        </button>
      </div>
    </div>

    <div class="explore__main--container">
      <h2 class="explore__main--h2">
        Available Internships
      </h2>
      <button class="btn--clear flex-center" @click="toggleFilter">
        <div class="icon">
          <span class="iconify" data-icon="ic:round-filter-list" height="24" width="24" />
          <span v-if="$matchMedia.xl">Filters</span>
        </div>
      </button>
    </div>

    <Modal v-if="!$matchMedia.xl" ref="filtersModal" :type="`small`">
      <template v-slot:header>
        <h4 class="post__modal--h4 my-0">
          Filters
        </h4>
      </template>

      <template v-slot:body>
        <div class="separator-short my-0 mb-2_5" />

        <div class="select select--small select--border mb-2">
          <select v-model="filters.selected.status" @change="filterProjects">
            <option disabled value="">
              Status Project:
            </option>
            <option v-for="status in filters.statuses" :key="`SelectStatus-${status.name}`">
              {{ status.name }}
            </option>
          </select>
          <span class="focus" />
        </div>


      </template>

      <template v-slot:footer>
        <button class="btn btn--clear mx-auto" @click="clearFilter">
          Clear Filter
        </button>
      </template>
    </Modal>

    <div v-show="showFilter && $matchMedia.xl" class="explore--filter mb-1_5 ">
      <div class="flex-row space-between">
        <div class="select select--small select--border">
          <select v-model="filters.selected.status" @change="filterProjects">
            <option disabled value="">
              Status Project:
            </option>
            <option v-for="status in filters.statuses" :key="`SelectStatus-${status.name}`">
              {{ status.name }}
            </option>
          </select>
          <span class="focus" />
        </div>
      </div>
    </div>

    <div class="project--container">
      <template v-if="loading">
        <content-placeholders
          v-for="i in 9"
          :key="`placeholder-${i}`"
          class="content-placeholders-container"
          :rounded="true"
        >
          <content-placeholders-img />
          <content-placeholders-heading />
        </content-placeholders>
      </template>
      <ProjectCard v-for="(offer) in offers" :key="`ProjectCard-${offer.id}`" :data="offer" />
      <p v-if="!loading && offers.length === 0" class="info__p">
        There are no projects with these criteria
      </p>
    </div>

    <button v-if="canLoadMore && offers.length !== 0" class="btn btn--blue btn__load-more" @click="loadMore">
      <span>Load More</span><span v-if="$matchMedia.xl">Projects</span>
    </button>
  </div>
</template>

<script>
import axios from 'axios'
import ProjectCard from '~/components/ProjectCard'

export default {
  name: 'ExplorePage',

  components: { ProjectCard },

  metaInfo () {
    return {
      title: 'Explore',
      meta: [
        { name: 'description', content: 'PHive Explore: Search the latest posted projects for you to apply or peek up the best projects that have been finished.' }
      ]
    }
  },

  data: () => {
    return {
      loadMoreType: 'auto', // manual or auto
      debounceAutoMore: '',
      loading: true,
      beforeFilterProjects: [],
      offers: [],
      query: '',
      page: 1,
      canLoadMore: true,
      showFilter: false,
      filters: {
        statuses: [
          { name: 'Hiring', count: 0 },
          { name: 'Ongoing', count: 0 },
          { name: 'Finished', count: 0 }
        ],
        selected: {
          applicantType: '',
          reward: '',
          status: ''
        }
      }

    }
  },

  mounted () {
    if (this.$route.query.query) {
      console.log(this.$route);
      this.query = this.$route.query.query
      this.searchQuery()
    } else this.getAll()

    if (this.loadMoreType === 'auto') {
      let app = document.querySelector('html')
      this.debounceAutoMore = ''
      window.onscroll = () => {
        clearTimeout(this.debounceAutoMore)
        this.debounceAutoMore = setTimeout(() => {
          let nearBottom = app.scrollTop + 1200 > app.scrollHeight
          if (nearBottom && this.canLoadMore) this.loadMore()
        }, 300)
      }
    }
  },

  beforeDestroy  () {
    window.onscroll = null
    clearTimeout(this.debounceAutoMore)
  },

  methods: {

    async search () {
      if (this.query !== this.$route.query.search) {
        this.$router.push({ name: 'explore', query: { search: this.query } })
        this.page = 1
        this.searchQuery()
      }
    },

    async searchQuery () {
      await axios.get('/api/search?page=' + this.page, {
        params: {
          query: this.query
        }
      })
        .then(response => {
          console.log(response);
          this.loading = false
          this.beforeFilterProjects = response.data.data
          // this.orderProjects()
          this.offers = this.beforeFilterProjects
          this.page++
          // this.filterProjects()
          if (response.data.next_page_url === null) this.canLoadMore = false
          else this.canLoadMore = true
          console.log(this.offers)
        })
        .catch(error => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    },

    async getAll () {
      await axios.get('/api/getAllOffres?page=' + this.page)
        .then(response => {
          this.loading = false
          this.beforeFilterProjects = response.data.data
          // this.orderProjects()
          this.offers = this.beforeFilterProjects

          this.page++
          // this.filterProjects()
          if (response.data.next_page_url === null) this.canLoadMore = false
        })
        .catch(error => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    },

    async loadMore () {
      let api = ''

      if (this.$route.query) {
        api = `/api/search?page=${this.page}&query=${this.query}`
      } else api = '/api/getAllOffres?page=' + this.page

      await axios.get(api)
        .then(response => {
          // this.projects.push(...response.data.data)
          this.beforeFilterProjects.push(...response.data.data)
          // this.orderProjects()
          // this.filterProjects()
          this.page++
          if (response.data.next_page_url === null) this.canLoadMore = false
        })
    },

    toggleFilter () {
      this.showFilter = !this.showFilter
      if (!this.$matchMedia.xl) this.$refs.filtersModal.openModal()
    },

    async filterProjects () {
      let filteredProjects = [...this.beforeFilterProjects]

      if (this.filters.selected.reward === 'Salary & Certificate') {
        for (const reward of this.filters.rewards.slice(1)) {
          filteredProjects = filteredProjects.filter(project => project[reward.apiName] === true)
        }
      } else if (this.filters.selected.reward === 'Salary') {
        filteredProjects = filteredProjects.filter(project => project.salary === true)
      } else if (this.filters.selected.reward === 'Certificate') {
        filteredProjects = filteredProjects.filter(project => project.certificate === true)
      }

      if (this.filters.selected.status !== '') {
        filteredProjects = filteredProjects.filter(project => project.status === this.filters.selected.status)
      }

      this.offers = filteredProjects
    },

    clearFilter () {
      this.filters.selected.reward = ''
      this.filters.selected.status = ''

      this.projects = [...this.beforeFilterProjects]
    },

    orderProjects () {
      const hiringProjects = this.beforeFilterProjects.filter(project => project.status === 'Hiring')
      const ongoingProjects = this.beforeFilterProjects.filter(project => project.status === 'Ongoing')
      const finishedProjects = this.beforeFilterProjects.filter(project => project.status === 'Finished')

      this.beforeFilterProjects = [...hiringProjects, ...ongoingProjects, ...finishedProjects]
    }
  }

}
</script>
