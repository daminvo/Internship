<template>
  <div class="inbox__container">
    <h2 v-if="$matchMedia.xl" class="desktop-inbox__heading">
      {{ internshipBox.internship.title }}
    </h2>
    <div class="inbox__body--container">
      <div class="inbox__info--container">
        <div class="inbox--top-left">
            <h2 class="inbox--heading">
              Your manager
            </h2>
          </div>
        <img class="inbox__info--img" :src="getImageUrl(manager.user.photo)" alt="">
        <div class="inbox__info--desc">
          <p class="inbox__info--name">
            {{ manager.user.first_name }} {{ manager.user.family_name }}
          </p>
          <p class="inbox__info--occupation">
            {{ manager.company.name }}<br>
            {{ manager.adress }}
          </p>
          <!-- <p v-if="!$matchMedia.xl" class="inbox__info--expertise">
            <span class="iconify inbox__info--expertise-icon" data-icon="fa-solid:paint-brush" /> {{ user.expertise }}
          </p>
          <p v-else class="inbox__info--expertise">
            {{ user.expertise }}
          </p> -->
        </div>
      </div>

      <div class="inbox__right--container">

        <div class="project-description">
          <p>
            {{ internshipBox.internship.description }}
          </p>
        </div>
        <div class="inbox--top-left">
          <h2 class="inbox--heading">
            Absences
          </h2>
        </div>



        <div class="inbox--container">
          <!-- <ProjectBoxItem v-for="project in internshipBox" :key="`project-box-${project.id}`" :data="project" :role="user.role" /> -->
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

  metaInfo () { return { title: 'Project Box' } },

  data: () => {
    return {
      internshipBox: {},
      manager: {},
      selected: ''
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
    }),

    isNoProject () {
      if (this.internshipBox.length === 0) {
        if (this.selected) return 'There are no projects to be handled yet with this criteria'
        else return 'There are no projects to be handled yet'
      }

      return ''
    },
  },

  setup() {
    const getImageUrl = (name) => {
      return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  mounted () {
    this.getInternshipBox()
  },

  methods: {
    async getInternshipBox () {
      // this.$store.dispatch('notification/fetchProjectBox')
      console.log(this.user.student.id);
      axios
        .post('/api/getOngoinginternships', { studentId:this.user.student.id })
        .then(res => {
          this.internshipBox = res.data[0]
          console.log(this.internshipBox)

          this.manager = this.internshipBox.internship.manager
          console.log(this.manager)
        })
        .catch( e => console.log(e.response))
    },
  }
}
</script>

<style>
</style>
