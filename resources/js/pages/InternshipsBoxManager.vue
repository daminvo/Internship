<template>
  <div class="inbox__container">
    <div class="inbox__container">
      <div class="explore__main--container mb-0">
        <h2 v-if="$matchMedia.xl" class="desktop-inbox__heading">
          Internship Offers
        </h2>
        <h4>view private internship requests</h4>
      </div>

      <div class="inbox__body--container">
        <div class="inbox__info--container">
          <img class="inbox__info--img" :src="getImageUrl(user.photo)" alt="">
          <div class="inbox__info--desc">
            <p class="inbox__info--name">
              {{ user.first_name }} {{ user.family_name }}
            </p>
            <p class="inbox__info--occupation">
              {{ user.manager.companyName }} <br>
              {{ user.adresss }}
            </p>

            <p v-if="user.manager.validation" class="inbox__info--verified">
              <span class="iconify" data-icon="bi:shield-fill-check" width="15" height="15" />
              Verified
            </p>
          </div>
        </div>

        <div class="inbox__right--container">

          <div class="inbox--container">
            <ProjectBoxItem v-for="project in projectbox" :key="`project-box-${project.id}`" :data="project" :role="user.role" />
            <p v-if="isNoProject" class="info__p">
              {{ isNoProject }}
            </p>
          </div>
        </div>

      </div>

    </div>

    <div class="internships-list">
      <div class="the-table">
        <div class="table-container">
          <table>
            <tr class="table-header">
              <th
                style="width: 40%; cursor:pointer;"
              >
                Student
              </th>
              <th
                style="width: 40%; cursor:pointer;"
              >
                Status
              </th>
              <th
                style="width: 40%; cursor:pointer;"
              >
                Internship
              </th>
              <th
                style="width: 40%; cursor:pointer;"
              >
                <!-- Visit -->
              </th>
            </tr>
            <tr
                v-for="(internship, index) in internships"
                :key="index"
                class="internship"
            >
              <td>
                <router-link :to="`/@/${internship.user.id}`" class="user-link" >
                  <img :src="getImageUrl(internship.user.photo)" class="data-profile-img">
                  <p>{{ internship.user.first_name }} {{ internship.user.family_name }}</p>
                </router-link>
              </td>

              <td>
                <div v-if="internship.available" class="available">
                  <p>Available</p>
                </div>

                <div v-else class="not-available">
                  <p> Not Available</p>
                </div>
              </td>

              <td>
                  <p>{{ internship.intern.internship.title }}</p>
              </td>

              <td>
                <router-link :to="`/intern=${internship.intern.id}`">
                  <button class="button-4" role="button" >Show</button>
                </router-link>
              </td>

            </tr>
          </table>
        </div>
      </div>
    </div>

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
      if (this.projectBox === []) {
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

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  mounted () {
    this.getProjectBox()
  },

  methods: {
    async getProjectBox () {
      axios
        .get('/api/getAllOffres?page=' + 1)
        .then(response => {
          this.projectbox = response.data.data
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

<style scoped>

.button-4 {
  appearance: none;
  background-color: #FAFBFC;
  border: 1px solid rgba(27, 31, 35, 0.15);
  border-radius: 6px;
  box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
  box-sizing: border-box;
  color: #24292E;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
  font-size: 14px;
  font-weight: 500;
  line-height: 20px;
  list-style: none;
  padding: 6px 16px;
  position: relative;
  transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: middle;
  white-space: nowrap;
  word-wrap: break-word;
}

.button-4:hover {
  background-color: #F3F4F6;
  text-decoration: none;
  transition-duration: 0.1s;
}

.button-4:disabled {
  background-color: #FAFBFC;
  border-color: rgba(27, 31, 35, 0.15);
  color: #959DA5;
  cursor: default;
}

.button-4:active {
  background-color: #EDEFF2;
  box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
  transition: none 0s;
}

.button-4:focus {
  outline: 1px transparent;
}

.button-4:before {
  display: none;
}

.button-4:-webkit-details-marker {
  display: none;
}


a.user-link {
  text-decoration: none;
  color: black;
  display: flex;
  flex-direction: row;
  align-content: center;
  align-items: center;
  width: 100%;
}

.user-link p {
  font-size: 16px;
  margin-left: 10px;
  color: var(--dark-blue);
}

.data-profile-img {
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
  -o-object-fit: cover;
  object-fit: cover;
  background-image: url(/images/missing-avatar.svg);
  background-size: cover;
}

.internships-list{
  padding: 0 2vw;
    margin: 0 20px;
  background: #ffffff;
}

.the-table{
  width: 100%;
  height: 420px;
  overflow: hidden;
}

.table-container{
  width: 100%;
  min-width: 420px;
  height: 100%;
  overflow-x: auto;
  padding-bottom: 17px;
  box-sizing: content-box;
  overflow-y: hidden;
}


table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    display: inline-block;
    overflow-y: auto;
    height: 420px;
    border-bottom: 1px solid var(--dark-green);
}

td ,th {
    width: 100%;
    padding-left: 30px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
}

.table-header {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  height: 40px;
  background: #ffffff;
  font-size: 16px;
  color: #000;
  border-bottom: 1px solid var(--dark-green);
  text-align: left;
}

tr {
  width: 100%;
  display: flex;
  align-items: center;
  text-align: left;
}

tr:nth-child(even) {
  background: #f8fdfb;;
}

.internship{
  margin: auto;
  height: 70px;
  /* background-color: #f8fdfb; */
  color: #595959;
  font-weight: 500;
}

@media (max-width: 1425px) {
  table{
      width: 1200px
  }
}
</style>
