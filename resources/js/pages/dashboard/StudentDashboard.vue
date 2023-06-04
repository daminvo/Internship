<template>
  <div class="profile--container">
    <div>
      <h2 class="table-title-h2">Pending List</h2>

      <div class="internships-list" v-if="data.pending">
        <div class="the-table">
          <div class="table-container">
            <table>
              <tr class="table-header">
                  <th
                  v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                  :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                  style="width: 40%; cursor:pointer;"
                  >
                  {{column.label}}
                  </th>
                  <th
                      style="width: 40%; cursor:pointer;"
                  >Response
                  </th>
                  <th
                      style="width: 40%; cursor:pointer;"
                  >Visit  -  Delete
                  </th>
              </tr>
              <tr
                  v-for="(internship, index) in data.pending"
                  :key="index"
                  class="internship"
              >
                  <td>
                      <p>{{ internship.internship.title }}</p>
                  </td>

                  <td>
                      <p>{{ internship.internship.manager.company.name }}</p>
                  </td>

                  <td>
                      <p>{{ internship.internship.duration }} months</p>
                  </td>

                  <td>
                    <p>{{ internship.internship.type }}</p>
                    &nbsp;&nbsp;
                    <router-link :to="{ name: 'offer.details', params: { id: 3 } }">
                      <span v-if="internship.internship.type === 'public'"  class="iconify" data-icon="heroicons:information-circle-solid" width="25" height="25" color="#3A455B" />
                    </router-link>
                  </td>

                  <td>
                      <div class="pending" v-if="internship.manager_validation === null">
                          <p>PENDING</p>
                      </div>
                      <div class="refused" v-if="internship.manager_validation === false">
                          <p>REFUSED</p>
                      </div>
                      <div class="accepted" v-if="internship.manager_validation ">
                          <p>ACCEPTED</p>
                      </div>
                      <div @click="submit(internship.id)">
                        <span v-if="internship.manager_validation" class="iconify" data-icon="heroicons:check-circle-solid" width="25" height="25" color="#366A66" />
                      </div>

                      <div @click="refuse(internship.id, internship.internship.type)">
                        <span v-if="internship.manager_validation" class="iconify" data-icon="heroicons:minus-circle-solid" width="25" height="25" color="#c50000" />
                      </div>
                  </td>

                  <td>
                    <div @click="deleteIntern(internship.id, internship.internship.type)">
                      <span class="iconify" data-icon="heroicons:trash-solid" width="25" height="25" color="#c50000" />
                    </div>
                  </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div v-else>
        no pending internships
      </div>

      <h2 class="table-title-h2">Accepted List</h2>

      <div class="internships-list" v-if="data.accepted">
        <div class="the-table">
          <div class="table-container">
            <table>
              <tr class="table-header">
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    Title
                  </th>
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    Company
                  </th>
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    Duration
                  </th>
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    Start Date
                  </th>
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    End Date
                  </th>
                  <th
                    style="width: 40%; cursor:pointer;"
                  >
                    Visit
                  </th>
              </tr>
              <tr
                  v-for="(internship, index) in data.accepted"
                  :key="index"
                  class="internship"
              >
                  <td>
                      <p>{{ internship.internship.title }}</p>
                  </td>

                  <td>
                      <p>{{ internship.internship.manager.company.name }}</p>
                  </td>

                  <td>
                      <p>{{ internship.internship.duration }} months</p>
                  </td>

                  <td>
                    <p>{{ internship.start_date }}</p>
                  </td>

                  <td>
                    <p>{{ internship.end_date }}</p>
                  </td>

                  <td>
                    <div @click="deleteIntern(internship.id, internship.internship.type)">
                      <span class="iconify" data-icon="heroicons:trash-solid" width="25" height="25" color="#c50000" />
                    </div>
                  </td>

              </tr>
            </table>
          </div>
        </div>
      </div>

      <div v-else>
        no pending internships
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
        {label: 'Title', name: 'title', type: 'string' },
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
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      data: 'auth/data',
      snackbar: 'notification/snackbar'
    }),
  },

  created() {
    this.$store.dispatch('auth/getInternships', {studentId: this.user.student.id})
  },

  // watch: {
  //   data(newVal) {
  //     console.log(newVal);
  //     this.internships = newVal.pending
  //   }
  // },

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

    goToOffre (id) {
      console.log('offer/3');
      this.$router.go(`/offer/3`)
    },

    sortBy(key) {
        this.sortKey = key;
        this.sortOrders[key] = this.sortOrders[key] * -1;
    },
    getIndex(array, key, value) {
        return array.findIndex(i => i[key] == value)
    },

    getInternships () {
      axios
        .post('http://localhost:8000/api/getPendingRequests', {studentId: this.user.student.id})
        .then(res => {
          this.internships = res.data
        })
        .catch( error => {
          console.log(error.response);
          console.log(error.response.data);
        })
    }
  },
}
</script>


<style scoped>
.iconify{
  cursor: pointer
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

.refused{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #9D2A22;
    padding: 5px;
    background: #F1A4A4;
    border-radius: 5px;
}

.pending{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #716f31;
    padding: 5px;
    background: #cdce94;
    border-radius: 5px;
}

.accepted{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #3D7A47;
    padding: 5px;
    background: #86EFAC;
    border-radius: 5px;
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
