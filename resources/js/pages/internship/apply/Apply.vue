<template>
  <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
    <div class="">

      <!-- <hr class="form--hr"> -->

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
      </div>

      <!-- Why you ? -->
      <div class="form-group__container">
        <h4 class="form-group__input-name form__input-name">
          Why you ? Tell us your motivations
        </h4>
        <div class="">
          <textarea v-model="form.motivation" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
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
  name: 'ApplyPage',

  middleware: ['auth', 'student'],

  metaInfo () { return { title: 'Apply' } },

  data: () => ({
    form: new Form({

    })
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

    internshipId () {
      return this.$route.params.internshipId
    },
  },

  mounted () {
    if (!this.$route.params.title && !this.$route.params.internshipId) {
      this.$router.push({ path: `/offer/${this.$route.params.id}` })
    }

    this.getUser()
  },

  methods: {
    async getUser () {
      console.log(this.internshipId);
      this.form.studentId = this.user.student.id
      // this.form.internshipId = parseInt(this.$route.params.id)
      this.form.internshipId = this.internshipId
    },

    async submit () {
      console.log(this.form)
      await this.form.post('/api/applyOffer')
        .then(({ data }) => {
          this.snackbar.open(data.msg)
        })
        .then(e => {
          this.$router.push({ path: `/offer/${this.$route.params.id}` })
        })
        .catch(e => {
          this.snackbar.open(e.response.data.message)
        })
    }
  }
}
</script>
