<template>
  <div>
    <div class="form-avatar-group__container">
      <img class="edit-profile--img" :src="getImageUrl(data.photo)" alt="">
      <div class=" form__file-container">
        <div>
          <label for="form2.file" class="btn btn--blue">Upload Photo</label>
          <input id="form2.file" class="form__input-file" name="form2.file" type="file" @change="uploadAvatar">
        </div>
        <button class="btn btn--grey" @click="deleteAvatar">
          Delete
        </button>
      </div>
    </div>

    <has-error :form="form2" field="file" />
    <p class="form-group__input-info mb-2">
      Max avatar size is 516KB
    </p>

    <form @submit.prevent="saveProfile" @keydown="form.onKeydown($event)">
      <div class="">
        <div class="form__input--group">
          <div class="form-group__container">
            <h4 class="form-group__input-name">
              First Name
            </h4>
            <div class="">
              <input v-model="form.user.first_name" class="form-group__input-text">
            </div>
          </div>

          <div class="form-group__container">
            <h4 class="form-group__input-name">
              Family Name
            </h4>
            <div class="">
              <input v-model="form.user.family_name" class="form-group__input-text">
            </div>
          </div>
        </div>

        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Status
          </h4>
          <div class="">
            <input v-model="form.user.role" class="form-group__input-text" disabled>
          </div>
        </div>

        <div class="form__input--group">
          <div class="form-group__container">
            <h4 class="form-group__input-name">
              Email
            </h4>
            <div class="">
              <input v-model="form.user.email" class="form-group__input-text" disabled>
            </div>
          </div>

          <div class="form-group__container">
            <h4 class="form-group__input-name">
              Phone Number
            </h4>
            <div class="">
              <input v-model="form.user.phone" class="form-group__input-text">
            </div>
          </div>
        </div>

        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Address
          </h4>
          <div class="">
            <input v-model="form.user.address" class="form-group__input-text" placeholder="e.g., Malang, Indonesia">
          </div>
        </div>

        <!-- Tell me about yourself! -->
        <div class="form-group__container">
          <h4 class="form-group__input-name">
            Biography
          </h4>
          <div class="">
            <textarea v-model="form.user.biography" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
          </div>
        </div>

        <hr class="form--hr">

        <h2 class="social-media__heading">
          Experience
        </h2>

        <label class="edit__cv--container pointer">
          <p class="edit__cv--heading">
            Upload CV Document
          </p>
          <p>File must be .pdf and the size must not more than 1MB </p>
          <input id="form2.file" class="form__input-file" name="form2.file" type="file" @change="uploadCV">
          <has-error :form="form2" field="file" />
        </label>

        <label class="edit__cv--container pointer" @click="deleteCV" v-if="form.user.student.cv">
          <p class="edit__cv--heading">
            Delete CV Document
          </p>
        </label>

        <hr class="form--hr">

        <div>
          <h2 class="social-media__heading">
            Social Media
          </h2>
          <div class="social-media__edit--container">
            <div class="social-media__edit-input--container">
              <span class="iconify social-media__edit--icon" data-icon="ant-design:github-filled" />
              <input v-model="form.user.github" type="url" class="social-media__input" :placeholder="`e.g., github.com/${firstName}`">
            </div>

            <div class="social-media__edit-input--container">
              <span class="iconify social-media__edit--icon" data-icon="bx-bxl-linkedin" />
              <input v-model="form.user.linkedin" type="url" class="social-media__input" :placeholder="`e.g., linkedin.com/in/${firstName}`">
            </div>
          </div>
        </div>

        <hr class="form--hr">



        <div class="mb-1_5 mt-5 edit-profile__buttons">
          <v-button :loading="form.busy" class="btn btn--blue">
            Save Changes
          </v-button>
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
  name: 'EditProfile1Page',

  metaInfo () { return { title: 'Edit Profile Page 1' } },

  data: () => ({
    form: new Form({
      user: {
        // first_name: '',
        // family_name: '',
        // address: '',
        // phone: '',
      }
    }),

    form2: new Form({
      file: null
    })
  }),

  computed: {
    ...mapGetters({
      data: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

    firstName () {
      return this.data.first_name.toLowerCase()
    }
  },

  setup() {

    const getImageUrl = (name) => {
      return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  },

  mounted: function () {
    this.getUser()
  },

  methods: {
    async getUser () {
      this.form.user = this.data
    },

    async uploadAvatar (e) {
      const file = e.target.files[0]

      // Do some client side validation...

      this.form2.file = file

      this.form2.submit('post', '/api/user/avatar', {
        transformRequest: [function (data, headers) {
          return serialize(data)
        }]
      })
        .then(({ data }) => {
          console.log(data);
          this.$store.dispatch('auth/updateAvatar', {
            photo: data.photo
          })

          this.snackbar.open(data.message)
        })
        .catch(e => {
          console.log(e);

          this.snackbar.open(e.response.data.message)
        })
    },

    async deleteAvatar (e) {
      this.form.submit('delete', '/api/user/avatar')
        .then(({ data }) => {
          this.$store.dispatch('auth/updateAvatar', {
            photo: data.photo
          })

          this.snackbar.open(data.message)
        })
    },

    async saveProfile (e) {
      // this.form.user.biography = snarkdown(this.form.user.biography)

      await this.form.post('/api/user/saveprofile/1')
        .then(({ data }) => {
          console.log(data);
          this.$store.dispatch('auth/updateUser', {
            user: data.user
          })

          this.snackbar.open(data.message)
        })
        .catch(e => {
          console.log(e.response);
          this.snackbar.open(e.response.data.message)
        })
    },

    async uploadCV (e) {
      const file = e.target.files[0]

      // Do some client side validation...

      this.form2.file = file

      this.form2.submit('post', '/api/user/cv', {
        transformRequest: [function (data, headers) {
          return serialize(data)
        }]
      })
        .then(({ data }) => {
          console.log(data);
          this.$store.dispatch('auth/updateCV', {
            cv: data.cv
          })

          this.snackbar.open(data.message)
        })
        .catch(e => {
          console.log(e.response);
          this.snackbar.open(e.response.data.message)
        })
    },

    async deleteCV () {
      this.form.submit('delete', '/api/user/cv')
        .then(({ data }) => {
          this.$store.dispatch('auth/updateCV', {
            cv: null
          })

          this.snackbar.open(data.message)
        })
        .catch(e => {
          console.log(e.response);
          this.snackbar.open(e.response.data.message)
        })
    }


  }

}
</script>
