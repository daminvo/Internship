<template>
  <form @submit.prevent="submitIndividual" @keydown="form.onKeydown($event)">
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
            <option value="0" selected>-- Select Company --</option>
            <option v-for="company in companies" :key="company.id" :value="company.id">
              {{ company.name }}
            </option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>

        <div class="select select--big select--border" v-if="form.company == 'other'">
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
            <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-group__input-text" type="text" name="address" placeholder="Address" required>
            <has-error :form="form" field="address" />
          </div>
        </div>

        </div>

        <div class="form-group__container" v-if="form.companyId != 'other'">
          <h6 class="form-group__input-name">
            Manager
          </h6>
          <div class="select select--small select--border">
            <select name="" id="" v-model="form.managerId">
              <option value="0" selected>-- Select Manager --</option>
              <option v-for="manager in filteredManagers" :key="manager.id" :value="manager.id">
                {{ manager.user.first_name }} {{ manager.user.family_name }}
              </option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <section v-if="form.managerId != 'other'">
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
                  <input v-model="form.firstName" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-group__input-text" type="text" name="first_name" placeholder="e.g., John" required>
                  <has-error :form="form" field="first_name" />
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Family Name
                </h6>
                <div class="">
                  <input v-model="form.lastName" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-group__input-text" type="text" name="last_name" placeholder="e.g., Doe" required>
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
                  <input v-model="form.phoneNumber" :class="{ 'is-invalid': form.errors.has('phone_number') }" class="form-group__input-text" type="number" name="phone_number" placeholder="02 11664916" required>
                  <has-error :form="form" field="phone_number" />
                </div>
              </div>
            </div>
        </section>


      <hr class="form--hr">

      <!-- Tell me about yourself! -->
      <div class="form-group__container">
        <h4 class="form-group__input-name form__input-name">
          Tell me about yourself!
        </h4>
        <div class="">
          <textarea v-model="form.apply.self_describe" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
        </div>
      </div>

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
      companyId: 0,
      managerId: 0,
      name: '',
      address: '',
      firstName: '',
      familyName: '',
      phone: '',
      gender: '',

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
      console.log(this.$store.getters['selectOptions/getCompanies']);
      return this.managers.filter(option => option['company_id'] === this.form.companyId);
    },
  },

  watch: {
    'form.company'() {
      this.form.managerId = 0;
    },
  },

  created() {
    this.$store.dispatch('selectOptions/fetchCompanies')
    this.$store.dispatch('selectOptions/fetchManagers')
  },

  mounted () {
    this.getUser()
    console.log(this.companies);

  },

  methods: {
    async getUser () {
      this.form.apply = {
        expertise: this.user.expertise,
        tagname: this.user.tagname,
        self_describe: '',
        apply_reason: '',
        project_id: this.$route.params.id
      }
    },

    async submitIndividual () {
      await this.form.post('/api' + this.$route.path)
        .then(({ data }) => {
          this.snackbar.open(data.message)
        })
        .then(e => {
          this.$router.push({ path: `/project/${this.$route.params.id}` })
        })
        .catch(e => {
          this.snackbar.open(e.response.data.message)
        })
    }
  }
}
</script>


<style scoped>
.h4-title {
  margin-bottom: 3vw;
  font-weight: 700;
}

select {
  text-align: center;
}
</style>
