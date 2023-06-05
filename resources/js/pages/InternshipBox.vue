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
            <h2 class="table-title-h2">
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
                  <tr class="internship" v-for=" abs in internshipBox.presence" :key="abs.id" >
                    <td>{{ abs.date }}</td>
                    <td>
                      <p  v-if="!abs.state" class="absent" >Absent</p>
                      <p   v-if="abs.state" class="present" >Present</p>
                    </td>
                    <td>{{ abs.entry_time }}</td>
                    <td>{{abs.exit_time }}</td>
                  </tr>
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

    <h2 class="table-title-h2">Next Internships</h2>
    <div class="internship-container">
      <ProjectBoxItem v-for="accepted in data.accepted" :key="`project-box-${accepted.id}`"  :data="accepted" :role="user.role" status="Accepted"/>
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
      data: 'auth/data',
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

  created() {
    this.$store.dispatch('auth/getInternships', {studentId: this.user.student.id})
    setTimeout(() => {
      console.log(this.internshipBox.presence);

    }, 1000);
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

          this.manager = this.internshipBox.internship.manager
        })
        .catch( e => console.log(e.response))
    },
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
  height: 295px;
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
    height: 295px;
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

.internship-container {
  display: grid;
  grid-template-columns: 1fr 1fr ;
  grid-gap: 20px;
  margin-top: 10px;
}

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

.table-title-h2 {
  font-size: 2.8rem;
  font-weight: 300;
  text-align: center;
  margin-top: 5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: var(--dark-green);
  align-items: center;
}


</style>
