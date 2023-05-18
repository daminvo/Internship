<template>
  <div>
    <div>
      <h2 class="project-details--h2">Pending List</h2>

      <div class="internships-list">
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
                      <th
                        style="width: 40%; cursor:pointer;"
                      >
                        Submittion
                      </th>
                  </tr>
                  <tr
                      v-for="(internship, index) in filteredInternships"
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
                              <div>
                                <span class="iconify" data-icon="heroicons:information-circle-solid" width="25" height="25" color="#3A455B"/>
                              </div>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <div>
                                <span class="iconify" data-icon="heroicons:minus-circle-solid" width="25" height="25" color="#c50000"/>
                              </div>
                          </div>
                      </td>

                      <td>
                        <div>
                          <span class="iconify" data-icon="heroicons:information-circle-solid" width="25" height="25" color="#3A455B"/>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div>
                          <span class="iconify" data-icon="heroicons:trash-solid" width="25" height="25" color="#c50000"/>
                        </div>
                      </td>
                      <td>

                      </td>

                      <!-- <td>
                          <p>{{ internship.response }}</p>
                      </td> -->

                  </tr>
                </table>
            </div>
        </div>

        </div>

      <!-- <ProjectCard v-for="internship in internships" :key="`project-${internship.id}`"
                   :data="internship"
      />
      <p v-if="internships.length === 0" class="info__p">
        Let fill this page with some projects
      </p> -->
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
      internships:[
      ],

      columns: columns,
      sortKey: 'title',
      sortOrders: sortOrders,
    }
  },

  mounted() {
    this.getInternships()
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      data: 'auth/data'
    }),

    // internships () {
    //   if (this.user.role === 'student') {
    //     return this.data.internships.map(e => e.internship)
    //   }

    //   return this.data.internships
    // },

    filteredInternships() {
      let internships = this.internships;
      if (this.search) {
        internships = internships.filter((row) => {
              return Object.keys(row).some((key) => {
                  return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
              })
          });
      }
      let sortKey = this.sortKey;
      let order = this.sortOrders[sortKey] || 1;
      if (sortKey) {
        internships = internships.slice().sort((a, b) => {
              let index = this.getIndex(this.columns, 'name', sortKey);
              a = String(a[sortKey]).toLowerCase();
              b = String(b[sortKey]).toLowerCase();
              if (this.columns[index].type && this.columns[index].type === 'date') {
                  return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
              } else if (this.columns[index].type && this.columns[index].type === 'number') {
                  return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
              } else {
                  return (a === b ? 0 : a > b ? 1 : -1) * order;
              }
          });
      }
      return internships;
    },

  },

  methods: {
    sortBy(key) {
        this.sortKey = key;
        this.sortOrders[key] = this.sortOrders[key] * -1;
    },
    getIndex(array, key, value) {
        return array.findIndex(i => i[key] == value)
    },

    getInternships () {
      console.log(this.user.student.id);
      axios
        .post('http://localhost:8000/api/getPendingRequests', {studentId: this.user.student.id})
        .then(res => {
          this.internships = res.data
          console.log(res)
        })
        .catch( error => {
          console.log(error.response);
          console.log(error.response.data);
        })
    }
  },
}
</script>


<style>
.internships-list{
  padding: 20px 2vw;
  margin: 20px;
  background: #ffffff;
  /* border-radius: 15px; */
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
    /* border-radius: 15px; */
}

td ,th {
    width: 100%;
    padding-left: 30px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}

.table-header {
    position: sticky;
    top: 0;
    height: 40px;
    background: var(--dark-green);
    font-size: 14px;
    /* background: var(--dark-blue); */
    color: #fff;
}

tr {
    width: 100%;
    display: flex;
    align-items: center;
    text-align: left;
}

.internship{
    margin: auto;
    height: 70px;
    background-color: #f8fdfb;
    color: #595959;
    margin-bottom: 10px;
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

</style>
