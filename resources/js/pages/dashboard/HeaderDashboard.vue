<template>
  <div class="dashboard-container">
    <div class="right-side">
      <div class="students-component">
        <div class="icon">
          <span class="iconify" data-icon="fluent-emoji:student-medium-light" width="64" height="64" />

        </div>
        <div class="total-students">{{ students }}</div>
        <div class="label">Total Students</div>
      </div>

      <div class="students-component">
        <div class="icon">
          <span class="iconify" data-icon="fluent-emoji:man-office-worker-medium-light" width="64" height="64" />

        </div>
        <div class="total-students">{{ interns }}</div>
        <div class="label">Ongoing Interns</div>
      </div>
    </div>

    <div class="left-side">
      <h2 class="table-title-h2">STUDENT REQUESTS</h2>

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
                        Company
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
                        <p>{{ internship.intern.internship.manager.company.name }}</p>
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

      <h2 class="table-title-h2">INTERNS</h2>

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
                        Company
                      </th>
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        <!-- Visit -->
                      </th>
                  </tr>
                  <tr
                      v-for="(intern, index) in internsList"
                      :key="index"
                      class="internship"
                  >
                      <td>
                        <router-link :to="`/@/${intern.student.user.id}`" class="user-link" >
                          <img :src="getImageUrl(intern.student.user.photo)" class="data-profile-img">
                          <p>{{ intern.student.user.first_name }} {{ intern.student.user.family_name }}</p>
                        </router-link>
                      </td>

                      <td>
                        <div v-if="intern.student.available" class="available">
                          <p>Available</p>
                        </div>

                        <div v-else class="not-available">
                          <p> Not Available</p>
                        </div>
                      </td>

                      <td>
                          <p>{{ intern.internship.title }}</p>
                      </td>

                      <td>
                        <p>{{ intern.internship.manager.company.name }}</p>
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
  </div>
</template>

<script>
import ProjectCard from '~/components/ProjectCard'
import { mapGetters } from 'vuex'
import axios from 'axios'


export default {
  name: 'UserProfileProjectsPage',
  scrollToTop: false,

  components: { ProjectCard },

  metaInfo () { return { title: 'Profile Internships' } },

  data() {
    let sortOrders = {};
    let columns = [
        {label: 'Student', name: 'title', type: 'string' },
        {label: 'Company', name: 'name', type: 'string' },
        {label: 'Duration', name: 'duration', type: 'number' },
        {label: 'Type', name: 'type', type: 'string' },
    ];
    columns.forEach((column) => {
        sortOrders[column.name] = 1;
    });

    return {
      columns: columns,
      sortKey: 'title',
      sortOrders: sortOrders,
      internships: [],
      students: 0,
      interns: 0,
      internsList: []
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),
  },

  setup() {
    const getImageUrl = (name) => {
      return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  mounted() {
    this.getRequests()
    this.getInternsList()
  },


  methods: {
    deleteIntern (id, type){
      axios
        .post('/api/deleteRequest', {id: id, type: type})
        .then( res => console.log(res.data))
        .then( res => {
          this.data.pending = res.data.pending
          this.data.accepted = res.data.accepted
          this.data.finished = res.data.finished
          this.snackbar.open(res.data.msg)
        })
        .catch( e => console.log(e.response))
    },

    refuse (id, type) {
      axios
        .post('/api/studentRefuse', {id: id, type: type})
        .then( res => {
          this.data.pending = res.data.pending
          this.data.accepted = res.data.accepted
          this.data.finished = res.data.finished
          this.snackbar.open(res.data.msg)
        })
        .then( res => console.log(res.data))
        .catch( e => console.log(e.response))
    },

    submit (id) {
      axios
        .post('/api/studentSubmition', {id: id})
        .then( res => {
          this.data.pending = res.data.pending
          this.data.accepted = res.data.accepted
          this.data.finished = res.data.finished
          console.log(this.data);
          this.snackbar.open(res.data.msg)
        })
        .then( res => console.log(res.data))
        .catch( e => console.log(e.response))
    },

    sortBy(key) {
        this.sortKey = key;
        this.sortOrders[key] = this.sortOrders[key] * -1;
    },
    getIndex(array, key, value) {
        return array.findIndex(i => i[key] == value)
    },

    getRequests () {
      axios
        .post('/api/showRequests', {headerId: this.user.header.id})
        .then(res => {
          this.internships = res.data
        })
        .catch( error => {
          console.log(error.response);
          console.log(error.response.data);
        })

      axios
        .post('/api/getAllStudentsNumber', {headerId: this.user.header.id})
        .then(res => {
          this.students = res.data
        })

      axios
        .post('/api/getOngoingInterns', {headerId: this.user.header.id})
        .then(res => {
          if (typeof(res.data) === 'number') {
            this.interns = res.data
          }
        })

    },

    getInternsList() {
      axios
        .post('/api/getOngoingInterns', {headerId: this.user.header.id})
        .then(res => {
          console.log(res)
          this.internsList = res.data
        })
    },

    showDetails(id) {
      this.$router.go('/dashboard/showRequest/' + id)
    }
  },
}
</script>


<style scoped>

.dashboard-container{
  display: flex;
  flex-direction: row-reverse;
  flex-wrap: wrap;
  justify-content: space-around;
}

.left-side {
  min-height: 100vh;
  flex-grow: 1;
}

.right-side {
  min-width: 200px;
  height: 100vh;
  padding: 10px 20px;
}

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


.iconify{
  cursor: pointer
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

.sorting {
  background-image: url('/images/sort_both.png');
  background-repeat: no-repeat;
  background-position: center left;
}
.sorting_asc {
  background-image: url('/images/sort_asc.png');
  background-repeat: no-repeat;
  background-position: center left;
}
.sorting_desc {
  background-image: url('/images/sort_desc.png');
  background-repeat: no-repeat;
  background-position: center left;
}

.not-available{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #9D2A22;
    padding: 5px;
    background: #F1A4A4;
    border-radius: 5px;
}

.available{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #3D7A47;
    padding: 5px;
    background: #86EFAC;
    border-radius: 5px;
}

.students-component {
  margin-top: 5vw;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 16px;
  background-color: #f8fdfb;
  box-shadow: 2px 2px 10px #bfbbbb;
  border-radius: 8px;
  width: 200px;
}

.icon {
  font-size: 5px;
  color: #2B6E91;
}

.total-students {
  font-size: 48px;
  font-weight: bold;
  color: #333;
  margin-top: 8px;
}

.label {
  font-size: 18px;
  color: #777;
  margin-top: 8px;
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
