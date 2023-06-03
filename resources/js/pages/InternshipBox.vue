<template>
  <div class="inbox__container">
    <div v-if="internshipBox.internship">
      <h2 v-if="$matchMedia.xl" class="desktop-inbox__heading">
        current internship: {{ internshipBox.internship.title }}
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

          <!-- <div class="project-description">
            <p>
              {{ internshipBox.internship.description }}
            </p>
          </div> -->
          <div class="inbox--top-left">
            <h2 class="inbox--heading">
              Absences
            </h2>
          </div>

          <div class="internships-list">
            <div class="the-table">
              <div class="table-container">
                <table>
                  <tr class="table-header">
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        Date
                      </th>
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        Status
                      </th>
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        Entry time
                      </th>
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        Exit time
                      </th>
                  </tr>
                  <tr class="internship">
                    <td>2023-05-21</td>
                    <td>
                      <p class="present" >Present</p>
                    </td>
                    <td>8:00</td>
                    <td>14:00</td>
                  </tr>
                  <tr class="internship">
                    <td>2023-05-22</td>
                    <td>
                      <p class="absent" >Absent</p>
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="internship">
                    <td>2023-05-23</td>
                    <td>
                      <p class="present" >Present</p>
                    </td>
                    <td>9:00</td>
                    <td>12:00</td>
                  </tr>
                  <tr class="internship">
                    <td>2023-05-24</td>
                    <td>
                      <p class="present" >Present</p>
                    </td>
                    <td>8:30</td>
                    <td>14:00</td>
                  </tr>
                  <tr class="internship">
                    <td>2023-05-25</td>
                    <td>
                      <p class="present" >Present</p>
                    </td>
                    <td>8:00</td>
                    <td>12:00</td>
                  </tr>
                  <!-- <tr
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
                        <p>{{ internship.intern.internship.manager.company.name }}</p>
                      </td>

                      <td>
                        <router-link :to="`/intern=${internship.intern.id}`">
                          <button class="button-4" role="button" >Show</button>
                        </router-link>
                      </td>

                  </tr> -->
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div v-else class="no_internship">
      <h2>
        You did not start any internship yet

      </h2>
      <p class="slide-1__paragraph">Try applying to more internship offers here </p>
    </div>

    <div>
      <ProjectBoxItem v-for="accepted in projectBoxes" :key="`project-box-${accepted.id}`" :data="project" :role="user.role" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import ProjectBoxItem from '~/components/ProjectBoxItem'

export default {
  name: 'ProjectBoxPage',

  middleware: ['auth', 'student'],
  components: { ProjectBoxItem },

  metaInfo () { return { title: 'Project Box' } },

  data: () => {
    return {
      internshipBox: {},
      manager: {},
      selected: '',
      accepted: []
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

    getAccepted () {

    }
  }
}
</script>

<style scoped>

.ongoing-internship-title {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.no_internship {
  min-height: 30vh;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
}

.inbox--heading, .inbox__info--name {
  color: var(--dark-blue);
}

.absent{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #9D2A22;
    padding: 5px;
    background: #F1A4A4;
    border-radius: 5px;
}

.present{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #3D7A47;
    padding: 5px;
    background: #86EFAC;
    border-radius: 5px;
}

.internships-list{
  padding: 0 2vw;
    margin: 0 20px;
  background: #ffffff;
}

.the-table{
  width: 100%;
  height: 340px;
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
    height: 340px;
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
