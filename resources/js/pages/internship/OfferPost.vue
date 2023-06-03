<template>
  <div class="post__container mx-auto">
    <TopImage :type="2" />

    <h2 class="post__h1">
      Post Your Internship Offer!
    </h2>

    <div class="form-group__container mb-2_5">
      <h4 class="form-group__input-name">
        Offer Thumbnail
      </h4>
      <div class="form-avatar-group__container">
        <img class="edit-profile--img" :src="getImageUrl(form.thumbnail)" alt="">
        <div class="form__file-container">
          <div>
            <label for="form2.avatar" class="btn btn--blue">Upload Photo</label>
            <input id="form2.avatar" class="form__input-file" name="form2.file" type="file" @change="uploadThumbnail">
          </div>
          <button class="btn btn--grey" @click="deleteThumbnail">
            Delete
          </button>
        </div>
      </div>
      <has-error :form="form2" field="file" />
      <p class="form-group__input-info mb-2">
        Max thumbnail size is 516KB
      </p>
    </div>

    <form @submit.prevent="``">
      <div class="">
        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Internship Title
          </h4>
          <div class="">
            <input v-model="form.title" class="form-group__input-text" placeholder="Type your internship title" required>
          </div>
          <has-error :form="form" field="title" />
        </div>

        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Max students
          </h4>
          <div class="select">
            <select v-model="form.max_person">
              <option value="1">
                1 Student
              </option>
              <option value="2">
                2 Students
              </option>
              <option value="3">
                3 Students
              </option>
              <option value="4">
                4 Students
              </option>
              <option value="5">
                5 Students
              </option>
              <option value="6">
                6 Students
              </option>
              <option value="7">
                7 Students
              </option>
              <option value="8">
                8 Students
              </option>
              <option value="9">
                9 Students
              </option>
            </select>
            <span class="focus" />
          </div>
        </div>

        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Duration
          </h4>
          <div class="select">
            <select v-model="form.max_person">
              <option value="1">
                1 Month
              </option>
              <option value="2">
                2 Months
              </option>
              <option value="3">
                3 Months
              </option>
              <option value="4">
                4 Months
              </option>
              <option value="5">
                5 Months
              </option>
              <option value="6">
                6 Months
              </option>
              <option value="7">
                7 Months
              </option>
              <option value="8">
                8 Months
              </option>
              <option value="9">
                9 Months
              </option>
              <option value="9">
                10 Months
              </option>
              <option value="9">
                11 Months
              </option>
              <option value="9">
                12 Months
              </option>
            </select>
            <span class="focus" />
          </div>
        </div>
      </div>



      <hr class="form--hr">

      <div class="form-group__container">
        <h4 class="form-group__input-name">
          Internship Description
        </h4>
        <div class="">
          <textarea v-model="form.description" class="form-group__input-textarea" placeholder="Max. 500 words" rows="5" />
        </div>
      </div>

      <div class="btn--group">
        <!-- Submit Button -->
        <div class="btn btn--large btn--blue ml-auto" @click="postProject('Publish')">
          Post Project
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Form from 'vform'
import { serialize } from 'object-to-formdata'
import { mapGetters } from 'vuex'

export default {
  name: 'PostProject',

  middleware: ['auth', 'manager'],

  metaInfo () { return { title: 'Post Project' } },

  data: () => ({
    thumbnail: '',
    form: new Form({
      title: '',
      location: 'Malang, Indonesia',
      level_applicant: 'Easy',
      max_person: 4,
      ui_ux_designer: false,
      front_end_engineer: false,
      back_end_engineer: false,
      data_expert: false,
      applicant_type: 'Individual & Team',
      description: '',
      interest: '',
      min_points: '',
      skills: [],
      requirements: [],
      salary: false,
      currency: 'IDR',
      salary_amount: '',
      payment_type: 'person',
      certificate: false,
      thumbnail: null
    }),

    form2: new Form({
      file: null
    }),

    salary: false,
    skillLength: 0,
    anotherSkills: '',
    anotherRequirements: ''
  }),

  computed: {
    ...mapGetters({
      snackbar: 'notification/snackbar'
    })
  },

  setup() {
    const getImageUrl = (name) => {
      if (!name) return '/images/post-placeholder-img.png'
      else return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    return { getImageUrl }
  },

  methods: {

    async uploadThumbnail (e) {
      const file = e.target.files[0]

      if (file.size > 516 * 1024) {
        this.form.errors.errors = { file: ['The file may not be greater than 516 kilobytes.'] }

        return
      }

      if (file) {
        this.form2.file = file

        this.form2.submit('post', '/api/project/thumbnail', {
          transformRequest: [function (data, headers) {
            return serialize(data)
          }]
        })
          .then(({ data }) => {
            this.form.thumbnail = data.thumbnail
            this.snackbar.open(data.message)
          })
      }
    },

    async deleteThumbnail () {
      this.form2.file = this.form.thumbnail

      this.form2.submit('delete', '/api/project/thumbnail')
        .then(({ data }) => {
          this.form.thumbnail = null

          this.snackbar.open(data.message)
        })
        . catch ((error) => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    },

    showAddSkill () {
      this.$refs.addSkillModal.openModal()
      this.skillLength = this.form.skills.length
    },

    showAddRequirement () {
      this.$refs.addRequirementModal.openModal()
    },

    addSkill () {
      let oldSkills = this.form.skills.map(skill => skill.name)
      oldSkills.push(...this.anotherSkills.split(',').map(skill => skill.trim()).filter(skill => skill !== ''))

      let skillSet = new Set(oldSkills)

      if (skillSet.size > 20) {
        this.snackbar.open('Can\'t add more than 20 skills')
        return
      }

      let anotherSkills = [...skillSet].map(skill => {
        return { name: skill }
      })

      this.form.skills = anotherSkills
      this.$refs.addSkillModal.closeModal()
      this.anotherSkills = ''
    },

    addRequirement () {
      let requirementSet = new Set(this.anotherRequirements.split('.'))

      let anotherRequirements = [...requirementSet].map(requirement => {
        return { requirement: requirement }
      }).filter(e => e.requirement !== '')

      this.form.requirements.push(...anotherRequirements)
      this.$refs.addRequirementModal.closeModal()
      this.anotherRequirements = ''
    },

    async postProject (status) {
      this.form.status = status

      this.form.submit('post', '/api/project/post')
        .then(({ data }) => {
          this.snackbar.open(data.message)
          this.$router.push({ name: 'projectbox' })
        })
    },

    deleteSkill (e) {
      let abc = this.form.skills.filter(a => a.name !== e)
      this.form.skills = abc
    },

    deleteRequirement (index) {
      this.form.requirements.splice(index, 1)
    }
  }
}
</script>
