<template>
  <div class="inbox__container">
    <h2 v-if="$matchMedia.xl" class="desktop-inbox__heading">
      Project Box
    </h2>
    <div class="inbox__body--container">
      <div class="inbox__info--container">
        <img class="inbox__info--img" :src="getImageUrl(user.photo)" alt="">
        <div class="inbox__info--desc">
          <p class="inbox__info--name">
            {{ user.firstName }} {{ user.familyName }}
          </p>
          <p class="inbox__info--occupation">
            {{ user.companyName }} <br>
            {{ user.adresss }}
          </p>

          <p v-if="user.manager.validation" class="inbox__info--verified">
            <span class="iconify" data-icon="bi:shield-fill-check" width="15" height="15" />
            Verified
          </p>
        </div>
      </div>

      <div class="inbox__right--container">
        <div class="explore__main--container mb-0">
          <div class="inbox--top-left">
            <span class="iconify inbox--left-icon" data-icon="simple-icons:polymerproject" /> <h2 class="inbox--heading">
              Internships Box
            </h2>
          </div>
          <!-- <button class="btn--clear flex-center" @click="toggleFilter">
            <div class="icon">
              <span class="iconify" data-icon="ic:round-filter-list" height="24" width="24" />
              <span v-if="$matchMedia.xl">Filters</span>
            </div>
          </button> -->
        </div>

        <div v-show="showFilter && $matchMedia.xl" class="explore--filter mb-1_5 ">
          <div class="flex-row space-between">
            <div class="select select--small select--border ml-auto">
              <select v-model="selected">
                <option disabled value="">
                  Project Status:
                </option>
                <option v-for="status in filters" :key="`SelectInbox-${status.name}`">
                  {{ status.name }}
                </option>
              </select>
              <span class="focus" />
            </div>
          </div>
        </div>

        <div class="inbox--container">
          <ProjectBoxItem v-for="project in projectbox" :key="`project-box-${project.id}`" :data="project" :role="user.role" />
          <p v-if="isNoProject" class="info__p">
            {{ isNoProject }}
          </p>
        </div>
      </div>
    </div>

    <Modal v-if="!$matchMedia.xl" ref="filtersModal" :type="`small`">
      <template v-slot:header>
        <h4 class="post__modal--h4 my-0">
          Filters
        </h4>
      </template>

      <template v-slot:body>
        <div class="separator-short my-0 mb-2_5" />
        <div class="select select--small select--border ml-auto">
          <select v-model="selected">
            <option disabled value="">
              Project Status:
            </option>
            <option v-for="category in filters" :key="`SelectInbox-${category.name}`">
              {{ category.name }}
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
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import ProjectBoxItem from '~/components/ProjectBoxItem'

export default {
  name: 'ProjectBoxPage',

  middleware: ['auth'],
  components: { ProjectBoxItem },

  metaInfo () { return { title: 'Internships Box' } },

  data: () => {
    return {
      showFilter: false,
      selected: '',
      projectbox: []
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      // data: 'notification/projectbox'
    }),

    isNoProject () {
      if (this.projectBoxes.length === 0) {
        if (this.selected) return 'There are no projects to be handled yet with this criteria'
        else return 'There are no projects to be handled yet'
      }

      return ''
    },

    // projectBoxes () {
    //   if (this.selected !== '') {
    //     return this.data.filter(projectbox => projectbox.status === this.selected)
    //   }

    //   return this.data
    // },

    filters () {
      if (this.user.role === 'Student') {
        return [
          { name: 'Waiting', count: 0 },
          { name: 'Accepted', count: 0 },
          { name: 'Rejected', count: 0 },
          { name: 'Waiting to Start', count: 0 },
          { name: 'Project Started', count: 0 },
          { name: 'Finished', count: 0 },
          { name: 'Bail Out', count: 0 }
        ]
      }

      return [
        { name: 'Draft', count: 0 },
        { name: 'Hiring', count: 0 },
        { name: 'Ongoing', count: 0 },
        { name: 'Confirmation', count: 0 },
        { name: 'Finished', count: 0 }
      ]
    }
  },

  mounted () {
    this.getProjectBox()
  },

  methods: {
    async getProjectBox () {
      // this.$store.dispatch('notification/fetchProjectBox')
      axios
        .get('/api/getAllOffres?page=' + 1)
        .then(response => {
          this.projectbox = response.data
          console.log(this.projectbox);
        })
    },

    toggleFilter () {
      this.showFilter = !this.showFilter
      if (!this.$matchMedia.xl) this.$refs.filtersModal.openModal()
    },

    clearFilter () {
      this.selected = ''
    }
  }
}
</script>

<style>
</style>
