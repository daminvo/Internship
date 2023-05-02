<template>
  <div class="register-page--container" :class="{ 'lecturer-bg': managerRole }">
    <div v-if="!$matchMedia.xl" class="login-page--logo">
      <router-link :to="{ name: 'index' }">
        <img src="/images/logo.svg" alt="">
      </router-link>
    </div>
    <div v-else class="desktop-login__left--container">
      <div>
        <img :src="role.img.top" alt="" class="desktop-register__left--img desktop-register__left-top--img">
      </div>
      <div class="flex-row space-between mt-1_5" :class="role.class.midImage">
        <div class="flex-column space-between h100">
          <img :src="role.img.midLeft" alt="" class="desktop-register__left--img desktop-register__left-mid-small--img">
        </div>
        <img :src="role.img.midRight" alt="" class="desktop-register__left--img desktop-register__left-mid-big--img ">
      </div>
      <div>
        <h2 class="desktop-login__left--h2 mt-1_5">
          {{ role.text }}
        </h2>
      </div>
    </div>

    <div class="resgiter-form--container">
      <router-link v-if="$matchMedia.xl" :to="{ name: 'index' }" class="mx-auto mb-1">
        <img class="desktop-nav__logo" src="/images/logo-blue.svg" alt="">
      </router-link>

      <section v-if="step == 1">
        <h1 class="login--h1">
          You are?
        </h1>
        <div class="login-role--container">
        <div>
          <input id="login-student" v-model="form.role" class="login-radio" type="radio" value="student">
          <label class="login-radio--label" for="login-student" @click="chooseStudent">Student</label>
        </div>
        <div>
          <input id="login-head" v-model="form.role" class="login-radio" type="radio" value="header">
          <label class="login-radio--label" for="login-head" @click="chooseHead">Head of departement</label>
        </div>
        <div>
          <input id="login-manager" v-model="form.role" class="login-radio" type="radio" value="manager">
          <label class="login-radio--label" for="login-manager" @click="chooseManager">Internship manager</label>
        </div>
      </div>

        <div v-if="!$matchMedia.xl" class="role--choose-effect" :class="{ 'role--student': studentRole, 'role--lecturer': managerRole }" />
        <div v-else class="separator mt-1_5 mb-2">
          Sign Up
        </div>
      </section>

        <form @keydown="form.onKeydown($event)">
          <section v-if="step == 1">
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
                  Last Name
                </h6>
                <div class="">
                  <input v-model="form.lastName" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-group__input-text" type="text" name="last_name" placeholder="e.g., Doe" required>
                  <has-error :form="form" field="last_name" />
                </div>
              </div>
            </div>

            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Email
              </h6>
              <div class="">
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-group__input-text" type="email" name="email" placeholder="example@mail.com" autocomplete="username" required>
                <has-error :form="form" field="email" />
              </div>
            </div>

            <!-- Password -->
            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Password
              </h6>
              <div class="">
                <div class="login-input--container">
                  <div class="right-tag__group">
                    <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="right-tag__input right-tag__input--form" :type="passwordType" name="password" placeholder="At least 8 characters" autocomplete="current-password" required>
                    <div v-show="hidePassword" class="pointer right-tag" @click="togglePassword">
                      <span class="iconify password__hide-icon" data-icon="carbon:view-off-filled" width="20" height="20" />
                    </div>
                    <div v-show="!hidePassword" class="pointer right-tag" @click="togglePassword">
                      <span class="iconify password__hide-icon " data-icon="carbon:view-filled" width="20" height="20" />
                    </div>
                  </div>
                  <has-error :form="form" field="password" />
                </div>
                <has-error :form="form" field="password" />
              </div>
            </div>

          </section>


          <section v-if="step == 2">
            <div class="form__input--group" v-if="studentRole">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Birth date
                </h6>
                <div class="">
                  <input v-model="form.birthDate" :class="{ 'is-invalid': form.errors.has('birthDate') }" class="form-group__input-text" type="date" name="birthDate" placeholder="birthDate">
                  <has-error :form="form" field="birthDate" />
                </div>
              </div>
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                    Birth place
                </h6>
                <div class="">
                  <input v-model="form.birthPlace" :class="{ 'is-invalid': form.errors.has('birthPlace') }" class="form-group__input-text" type="text" name="birthPlace" placeholder="birthPlace">
                  <has-error :form="form" field="birthPlace" />
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

            <h6 class="form-group__input-name" v-if="managerRole">
              Company
            </h6>
            <div class="form__input--group" v-if="managerRole">
              <div class="select select--small select--border form-group__container">
                <select name="" id="" v-model="form.company">
                  <option v-for="company in companies" :key="company.id" :value="company.id">
                    {{ company.name }}
                  </option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="form-group__container" v-if="form.company == 'other'">
                <input v-model="form.newCompany" :class="{ 'is-invalid': form.errors.has('newCompany') }" class="form-group__input-text" type="text" name="newCompany" placeholder="Name">
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

            <div v-if="headRole" class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  University
                </h6>
                <div class="select select--big select--border">
                  <select name="" v-model="form.university">
                    <option value="0" selected>-- Select University --</option>
                    <option v-for="university in universities" :key="university.id" :value="university.id">
                      {{ university.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Faculty
                </h6>
                <div class="select select--big select--border">
                  <select name="" id="" v-model="form.faculty">
                    <option value="0" selected>-- Select Faculty --</option>
                    <option v-for="faculty in faculties" :key="faculty.id" :value="faculty.id">
                      {{ faculty.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div v-if="headRole" class="form-group__container">
              <h6 class="form-group__input-name">
                Department
              </h6>
              <div class="select select--big select--border">
                <select name="" id="" v-model="form.department">
                  <option value="0" selected>-- Select Department --</option>
                  <option v-for="department in departments" :key="department.id" :value="department.id">
                    {{ department.name }}
                  </option>
                </select>
              </div>
            </div>
          </section>

          <section v-if="step == 3">
            <div class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  University
                </h6>
                <div class="select select--big select--border">
                  <select name="" v-model="form.university">
                    <option value="0" selected>-- Select University --</option>
                    <option v-for="university in universities" :key="university.id" :value="university.id">
                      {{ university.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Faculty
                </h6>
                <div class="select select--big select--border">
                  <select name="" id="" v-model="form.faculty">
                    <option value="0" selected>-- Select Faculty --</option>
                    <option v-for="faculty in filteredFaculties" :key="faculty.id" :value="faculty.id">
                      {{ faculty.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>


            <div class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Department
                </h6>
                <div class="select select--big select--border">
                  <select name="" id="" v-model="form.department">
                    <option value="0" selected>-- Select Department --</option>
                    <option v-for="department in filteredDepartments" :key="department.id" :value="department.id">
                      {{ department.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Speciality
                </h6>
                <div class="">
                  <input v-model="form.speciality" :class="{ 'is-invalid': form.errors.has('Speciality') }" class="form-group__input-text" type="text" name="Speciality" placeholder="Speciality" required>
                  <has-error :form="form" field="Speciality" />
                </div>
              </div>
            </div>

            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Grade
              </h6>
              <div class="select select--small select--border">
                <select name="" id="" v-model="form.grade">
                  <option value="0" selected>-- Select grade --</option>
                  <option value="L1" selected>Licence 1</option>
                  <option value="L2" selected>Licence 2</option>
                  <option value="L3" selected>Licence 3</option>
                  <option value="M1" selected>Master 1</option>
                  <option value="M2" selected>Master 2</option>
                </select>
              </div>
            </div>

            <div class="form__input--group">
              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Student card
                </h6>
                <div class="">
                  <input v-model="form.card" :class="{ 'is-invalid': form.errors.has('card') }" class="form-group__input-text" type="text" name="card" placeholder="card" required>
                  <has-error :form="form" field="card" />
                </div>
              </div>

              <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Social Number
                </h6>
                <div class="">
                  <input v-model="form.social" :class="{ 'is-invalid': form.errors.has('social') }" class="form-group__input-text" type="number" name="social" placeholder="social" required>
                  <has-error :form="form" field="social" />
                </div>
              </div>
            </div>


          </section>

          <div class="">
            <div class="form__input--group">
              <button
              class="btn"
                v-if="step != 1"
                @click.prevent="pervStep"
              >
                back
              </button>

              <button
              v-if="step < totalSteps"
              class="login-submit--button"
              @click.prevent="nextStep">
                next
              </button>

              <!-- Submit Button -->
              <button v-if="step == totalSteps" @click.prevent="register" :loading="form.busy" class="login-submit--button">
                Sign Up
              </button>
            </div>

          </div>
        </form>

      <div class="register-extra">
        <h5>
          Already had an account?
          <router-link :to="{ name: 'login' }" class="login-link">
            <b>Sign In</b>
          </router-link>
        </h5>
        <div v-if="$matchMedia.xl" class="desktop-login__footer">
          PHive, All Rights Reserved. &copy; 2021 .
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  name: 'RegisterPage',
  layout: 'wide',
  middleware: 'guest',

  metaInfo () { return { title: 'Sign Up' } },

  data: () => ({
    studentRole: true,
    headRole: false,
    managerRole: false,
    hidePassword: true,
    passwordType: 'password',
    totalSteps: 3,
    step: 1,

    form: new Form({
      role: 'student',
      firstName: '',
      lastName: '',
      email: '',
      password: '',
      birthDate: '',
      birthPlace: '',
      phoneNumber: '',
      gender: '',
      address: '',
      university: 0,
      faculty: 0,
      department: 0,
      grade: 0,
      speciality: '',
      card: '',
      social: '',
      company: '',
      newCompany: ''
    }),
  }),

  computed: {
    filteredFaculties () {
      return this.faculties.filter((option) => option['university_id'] === this.form.university);
    },

    filteredDepartments () {
      console.log(this.form.faculty);
      return this.departments.filter(option => option['faculty_id'] === this.form.faculty);
    },

    role () {
      if (this.form.role === 'Student') {
        return {
          img: {
            top: '/images/register-top-student.png',
            midLeft: '/images/register-mid-left-student.png',
            midRight: '/images/login-mid-right-student.png'
          },
          class: {
            midImage: ''
          },
          text: 'Expand Your Careers.'
        }
      }

      return {
        img: {
          top: '/images/login-top-lecturer.png',
          midLeft: '/images/login-mid-left-1-lecturer.png',
          midRight: '/images/login-mid-right-lecturer.png'
        },
        class: {
          midImage: 'row-reverse'
        },
        text: 'Internships for Everyone'
      }
    },

    ...mapGetters({
      snackbar: 'notification/snackbar',
      // universities: 'selectOptions/getUniversities',
      // faculties: 'selectOptions/getFaculties',
      // departments: 'selectOptions/getDepartments',
      // companies: 'selectOptions/getCompanies',
    }),

    universities () {
      return this.$store.getters['selectOptions/getUniversities']
    },

    faculties () {
      return this.$store.getters['selectOptions/getFaculties']
    },

    departments () {
      return this.$store.getters['selectOptions/getDepartments']
    },

    companies () {
      return this.$store.getters['selectOptions/getCompanies']
    },

  },

  watch: {
    'form.university'() {
      this.form.faculty = 0;
      this.form.department = 0;
    },
    'form.faculty'() {
      this.form.department = 0;
    },
  },

  created() {
    this.$store.dispatch('selectOptions/fetchUniversities')
    this.$store.dispatch('selectOptions/fetchFaculties')
    this.$store.dispatch('selectOptions/fetchDepartments')
    this.$store.dispatch('selectOptions/fetchCompanies')
  },

  methods: {
    register () {

      axios
        .post('/api/register', this.form)
        .then(data => console.log(data))
        .catch(error => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
        // this.$router.push({ name: 'login' })
    },
    chooseStudent () {
      this.totalSteps = 3
      this.studentRole = true
      this.headRole = false
      this.managerRole = false
    },

    chooseHead () {
      this.totalSteps = 2
      this.headRole = true
      this.studentRole = false
      this.managerRole = false
    },

    chooseManager () {
      this.totalSteps = 2
      this.managerRole = true
      this.headRole = false
      this.studentRole = false
    },
    togglePassword () {
      this.hidePassword = !this.hidePassword
      this.passwordType = this.hidePassword ? 'password' : 'text'
    },

    pervStep(){
      this.step--
      this.university = 0
      this.faculty = 0
      this.department = 0
    },

    nextStep(){
      this.step++
      this.university = 0
      this.faculty = 0
      this.department = 0
    }
  }
}
</script>


<style scoped>
.btn{
  width: 100% !important;
}

.phone-number{
  max-width: 250px !important;
}
</style>
