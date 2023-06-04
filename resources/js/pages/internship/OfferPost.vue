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
        <img class="edit-profile--img" :src="getImageUrl(form.photo)" alt="">
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
            <select v-model="form.nmbrPositions">
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
            <select v-model="form.duration">
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
        <div class="btn btn--large btn--blue ml-auto" @click="postInternship()">
          Post Internship
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
      photo: null,
      nmbrPositions: 1,
      duration: 1,
      description: '',
      managerId: '',
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
      user: 'auth/user',
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
            this.form.photo = data.thumbnail
            this.snackbar.open(data.message)
          })
      }
    },

    async deleteThumbnail () {
      this.form2.file = this.form.photo

      this.form2.submit('delete', '/api/project/thumbnail')
        .then(({ data }) => {
          this.form.photo = null

          this.snackbar.open(data.message)
        })
        . catch ((error) => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    },

    async postInternship() {
      this.form.managerId = this.user.manager.id

      this.form.submit('post', '/api/createOffer')
        .then(({ data }) => {
          this.snackbar.open(data.msg)
          this.$router.push({ name: 'manager.projectbox' })
        })
        . catch ((error) => {
          console.log('Error:', error.response)
          console.log('Status:', error.response.status)
          console.log('Data:', error.response.data)
        })
    },


  }
}
</script>
