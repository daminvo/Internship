<template>
    <div class="">


        <section class="intern-container">

          <div class="nav--profile">
            <p class="nav--profile-expertise">
              <span class="iconify" data-icon="fa-solid:paint-brush" width="10" height="10" />
              <span>Posted By :</span>
            </p>
            <router-link :to="`/@/${intern.student.user.id}`">
              <div class="user-container">
                <img class="nav--profile-img" :src="getImageUrl(intern.student.user.photo)" alt="">
                <p class="nav--profile-name">
                  {{ intern.student.user.first_name }} {{ intern.student.user.family_name }}
                </p>
              </div>
            </router-link>
          </div>
        </section>

          <!-- <hr class="form--hr"> -->

      <h4 class="form-group__input-name form__input-name h4-title">
        Company Informations
      </h4>

        <div class="form__input--group">
          <div class="info-title">
            <h2>
              Name
            </h2>
            <p class="apply__top--p">{{ intern.internship.manager.company.name }}</p>
          </div>

          <div class="info-title">
            <h2>
              Address
            </h2>
            <p class="apply__top--p">{{ intern.internship.manager.company.address }}</p>
          </div>

        </div>

        <section v-if="user.role == 'header'">
          <hr class="form--hr">
          <h4 class="form-group__input-name form__input-name h4-title">
            Manager Informations
          </h4>

          <div class="form__input--group">
            <div class="info-title">
              <h2>
                First Name
              </h2>
              <p class="apply__top--p" >{{ intern.internship.manager.user.first_name }}</p>
            </div>

              <div class="info-title">
                <h2>
                  Family Name
                </h2>
                <p class="apply__top--p">{{ intern.internship.manager.user.family_name }}</p>
              </div>
            </div>

          <div class="form__input--group">

            <div class="info-title">
              <h2>
                Gender
              </h2>
              <p class="apply__top--p">{{ intern.internship.manager.user.gender }}</p>
            </div>

              <div class="info-title">
                <h2>
                  Phone number
                </h2>
                <p class="apply__top--p">{{ intern.internship.manager.user.phone }}</p>
              </div>

            </div>


          <div class="info-title">
              <h2>
                Email
              </h2>
              <p class="apply__top--p">{{ intern.internship.manager.user.email }}</p>
          </div>
        </section>

        <section>
          <hr class="form--hr">
          <h4 class="form-group__input-name form__input-name h4-title">
            Inernship Informations
          </h4>

          <div class="form__input--group">
            <div class="info-title">
              <h2>
                Start date:
              </h2>
              <p class="apply__top--p">{{ intern.start_date }}</p>
            </div>
            <div class="info-title">
              <h2 class="">
                End date:
              </h2>
              <p class="apply__top--p">{{ intern.end_date }}</p>
            </div>
          </div>

          <div class="info-title">
            <h2>
              Duration
            </h2>
            <p class="apply__top--p">{{ intern.internship.duration }} months</p>
          </div>
          <fieldset>
            <legend>
              Cover letter
            </legend>
            <!-- <p class="apply__top--p">{{ intern }}</p> -->
            <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis nisi vel mollitia eius, sequi necessitatibus! Temporibus commodi nobis iste dolorem culpa dolores, perferendis corporis maxime nemo doloribus, eligendi error quo?
              . <br>
              . <br>
              . <br>
            </p>
          </fieldset>
        </section>


      <div class="buttons-container">
        <div class="mt-3" v-if="this.user.role == 'header'">
          <div>
            <h6 class="form-group__input-name">
              Explane why this has been refused
            </h6>
            <input class="form-group__input-text" type="text" placeholder="Refuse motif" v-model="motif">
          </div>
          <button class="btn btn--decline mt-3" :disabled="!motif">Refuse</button>
        </div>
        <div v-else>
          <button class="btn btn--decline mt-3" :disabled="!motif">Refuse</button>
        </div>

        <button class="btn btn--blue mt-3" @click="submit()" >
          <span>
            Accept
          </span>
          <span class="iconify" data-icon="si-glyph:paper-plane" />
        </button>
      </div>

    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'Internship Informations Page',

  middleware: ['auth', 'header'],

  metaInfo () { return { title: 'New Internship Request' } },

  data: () => ({
    intern: {},
    toggleMotif: false,
    motif: ''
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    })
  },

  created() {

  },

  mounted () {
    axios.post('api/getIntern', {internId: this.$route.params.internId})
      .then(res => this.intern = res.data)
      .then( () => console.log(this.intern))

  },

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  methods: {
    submit () {
      if (this.user.role == 'header'){
        axios
          .post('/api/newRequest', {internId: this.intern.id})
          .then(({ data }) => {
            console.log(data);
          })
          .then(e => {
            this.$router.push({ path: '/' })
          })
          .catch(error => {
            console.log('Error:', error)
            console.log('Status:', error.response.status)
            console.log('Data:', error.response.data)
          })
      }
      else {
        axios
          .post('/api/newRequest', {internId: this.intern.id})
          .then(({ data }) => {
            console.log(data);
          })
          .then(e => {
            this.$router.push({ path: '/' })
          })

      }
    },

    refuse() {
      if (this.user.role == 'header') {
        let dataSent = {
          internId: this.intern.id,
          motif: this.motif
        }

        axios
          .post('/api/refuseRequest', dataSent)
          .then(({ data }) => {
            console.log(data);
          })
          .then(e => {
            this.$router.push({ path: '/' })
          })
      }
      else {
        axios
          .post('/api/refuseRequest', dataSent)
          .then(({ data }) => {
            console.log(data);
          })
          .then(e => {
            this.$router.push({ path: '/' })
          })
      }
    }
  }
}
</script>


<style scoped>
a, a:visited {
  text-decoration: none;
  color: var(--dark-blue);
}

fieldset{
  border: 1px solid #b6b4b4;
  padding: 12px;
  border-radius: 8px;
}

fieldset p {
  font-size: 16px;
}

legend {
  font-size: 18px;
  font-weight: bold;
  padding: 10px;
}

.user-container {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.user-container p {
  margin-left: 1rem;
  color: var(--dark-blue);
}

.h4-title {
  margin: 3vw auto;
  font-weight: 700;
}

select {
  text-align: center;
}

.info-title{
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-start;
}

.info-title p {
  margin-left: 20px;
}

.buttons-container {
  align-items: center;
  justify-items: center;
}

.send-btn{
  font-size: 1.8rem;
  font-weight: 700;
  width: 4.5rem;
  border: none;
  border-radius: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 4.5rem;
  text-decoration: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  cursor: pointer;
  letter-spacing: 0.02em;
  margin-top: 3.4rem !important;
}

.buttons-container{
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
}
</style>
