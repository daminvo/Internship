<template>
  <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
    <div class="">

      <h4 class="form-group__input-name form__input-name h4-title">
        Company Informations
      </h4>

      <div class="form-group__container">
        <h6 class="form-group__input-name">
          Company
        </h6>
        <div class="select select--big select--border">
          <select name="" v-model="form.companyId">
            <option value="" selected>-- Select Company --</option>
            <option v-for="company in companies" :key="company.id" :value="company.id">
              {{ company.name }}
            </option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>

        <div class="form__input--group" v-if="form.companyId === 'other'">
          <div class="form-group__container">
            <h6 class="form-group__input-name">
                Name
            </h6>
            <div>
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('newCompany') }" class="form-group__input-text" type="text" name="newCompany" placeholder="Name">
              <has-error :form="form" field="newCompany" />
            </div>
          </div>

          <div class="form-group__container">
          <h6 class="form-group__input-name">
              Address
          </h6>
          <div class="">
            <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-group__input-text" type="text" name="address" placeholder="Address" >
            <has-error :form="form" field="address" />
          </div>
        </div>

        </div>

        <div class="form-group__container" v-if="form.companyId !== 'other'">
          <h6 class="form-group__input-name">
            Manager
          </h6>
          <div class="select select--big select--border">
            <select name="" id="" v-model="form.managerId">
              <option value="" selected>-- Select Manager --</option>
              <option v-for="manager in filteredManagers" :key="manager.id" :value="manager.id">
                {{ manager.user.first_name }} {{ manager.user.family_name }}
              </option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <section v-if="form.managerId === 'other' || form.companyId === 'other'">
          <hr class="form--hr">
          <h4 class="form-group__input-name form__input-name h4-title">
            Manager Informations
          </h4>

          <div class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  First Name
                </h6>
                <div class="">
                  <input v-model="form.firstName" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-group__input-text" type="text" name="first_name" placeholder="e.g., John">
                  <has-error :form="form" field="first_name" />
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Family Name
                </h6>
                <div class="">
                  <input v-model="form.familyName" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-group__input-text" type="text" name="last_name" placeholder="e.g., Doe">
                  <has-error :form="form" field="last_name" />
                </div>
              </div>
            </div>

          <div class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  gender
                </h6>
                <div class="select select--small select--border" required>
                  <select name="" id="" v-model="form.gender">
                    <option value="male">Male</option>
                    <option value="female">female</option>
                  </select>
                </div>
              </div>
              <div class="form-group__container phone-number">
                <h6 class="form-group__input-name">
                  Phone number
                </h6>
                <div class="">
                  <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone_number') }" class="form-group__input-text" type="number" name="phone_number" placeholder="02 11664916">
                  <has-error :form="form" field="phone_number" />
                </div>
              </div>
            </div>

            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Email
              </h6>
              <div class="">
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-group__input-text" type="email" name="email" placeholder="example@mail.com" autocomplete="username">
                <has-error :form="form" field="email" />
              </div>
            </div>
        </section>

        <section>
          <hr class="form--hr">
          <h4 class="form-group__input-name form__input-name h4-title">
            Inernship Informations
          </h4>

          <div class="form-group__container">
              <h6 class="form-group__input-name">
                  Tell us about it
              </h6>
              <div class="">
                <input v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" class="form-group__input-text" type="text" name="title" placeholder="Title">
                <has-error :form="form" field="title" />
              </div>
            </div>

          <div class="form__input--group">
            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Start date
              </h6>
              <div class="">
                <input v-model="form.startDate" :class="{ 'is-invalid': form.errors.has('startDate') }" class="form-group__input-text" type="date" name="startDate" placeholder="">
                <has-error :form="form" field="startDate" />
              </div>
            </div>
            <div class="form-group__container">
              <h6 class="form-group__input-name">
                End date
              </h6>
              <div class="">
                <input v-model="form.endDate" :class="{ 'is-invalid': form.errors.has('endDate') }" class="form-group__input-text" type="date" name="endDate" placeholder="">
                <has-error :form="form" field="endDate" />
              </div>
            </div>

            <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Duration
                </h6>
                <div class="select select--small select--border" required>
                  <select name="" id="" v-model="form.duration">
                    <option value="1">1 Month</option>
                    <option value="2">2 Months</option>
                    <option value="3">3 Months</option>
                    <option value="4">4 Months</option>
                    <option value="5">5 Months</option>
                    <option value="6">6 Months</option>
                    <option value="7">7 Months</option>
                    <option value="8">8 Months</option>
                    <option value="9">9 Months</option>
                    <option value="10">10 Months</option>
                    <option value="11">11 Months</option>
                    <option value="12">12 Months</option>
                  </select>
                </div>
              </div>
          </div>
          <div class="form-group__container">
            <h4 class="form-group__input-name form__input-name">
              Tell us your motivations
            </h4>
            <div class="">
              <textarea v-model="form.motivation" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
            </div>
          </div>
        </section>


      <div class="">
        <!-- Submit Button -->
        <v-button :loading="form.busy" class="btn btn--blue btn--large apply__btn-submit">
          <span>
            Submit
          </span>
          <span class="iconify" data-icon="si-glyph:paper-plane" />
        </v-button>
      </div>
    </div>
  </form>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  name: 'ApplyIndividualPage',

  middleware: ['auth', 'student'],

  metaInfo () { return { title: 'Apply - Individual' } },

  data: () => ({
    form: new Form({
      studentId: '',
      companyId: '',
      managerId: '',
      name: '',
      address: '',
      firstName: '',
      familyName: '',
      phone: '',
      gender: 'male',
      title:'',
      startDate:'',
      endDate:'',
      duration: 1,
      motivation: '',
      demandDate: '2023-05-05'
    })
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

    companies () {
      return this.$store.getters['selectOptions/getCompanies']
    },

    managers () {
      return this.$store.getters['selectOptions/getManagers']
    },

    filteredManagers () {
      return this.managers.filter(option => option['company_id'] === this.form.companyId);
    },
  },

  watch: {
    'form.company'() {
      this.form.managerId = "";
    },
  },

  created() {
    this.$store.dispatch('selectOptions/fetchCompanies')
    this.$store.dispatch('selectOptions/fetchManagers')
  },

  mounted () {

    this.form.studentId = this.user.student.id;

  },

  methods: {
    // async getUser () {
    //   this.form.apply = {
    //     expertise: this.user.expertise,
    //     tagname: this.user.tagname,
    //     self_describe: '',
    //     apply_reason: '',
    //     project_id: this.$route.params.id
    //   }
    // },

    async submit () {
      console.log(this.form);
      await this.form.post('/api/newRequest')
        .then(({ data }) => {
          // this.snackbar.open(data.message)
          console.log(data);
        })
        .then(e => {
          this.$router.push({ path: `/` })
        })
        .catch(e => {
          this.snackbar.open(e.response.data.msg)
        })
        .catch(error => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    }
  }
}
</script>


<style scoped>
.h4-title {
  margin: 3vw 0;
  font-weight: 700;
}

select {
  text-align: center;
}
</style>
