<template>
  <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
    <div class="">

      <!-- <hr class="form--hr"> -->

      <div class="form__input--group" >
        <div class="select select--big select--border">
          <select v-model="form.state">
            <option disabled value="">
              Absence state:
            </option>
            <option value="true">
              Present
            </option>
            <option value="false">
              absent
            </option>
          </select>
          <!-- <input type="radio" value="true"> -->
        </div>
      </div>



      <div class="form__input--group" v-if="form.state === 'true'">
        <div class="form-group__container">
          <h6 class="form-group__input-name">
            Entry Time
          </h6>
          <div class="">
            <input v-model="form.entry_time" :class="{ 'is-invalid': form.errors.has('startDate') }" class="form-group__input-text" type="time" name="startDate" placeholder="">
            <has-error :form="form" field="startDate" />
          </div>
        </div>
        <div class="form-group__container">
          <h6 class="form-group__input-name">
            Exit Time
          </h6>
          <div class="">
            <input v-model="form.exit_time" :class="{ 'is-invalid': form.errors.has('endDate') }" class="form-group__input-text" type="time" name="endDate" placeholder="">
            <has-error :form="form" field="endDate" />
          </div>
        </div>
      </div>

      <div class="form__input--group" v-if="form.state === 'true'">
        <h6 class="form-group__input-name">
            Presence Date
          </h6>
          <div class="">
            <input v-model="form.date" :class="{ 'is-invalid': form.errors.has('endDate') }" class="form-group__input-text" type="date" name="endDate" placeholder="">
            <has-error :form="form" field="endDate" />
          </div>
      </div>

      <!-- Why you ? -->
      <div class="form__input--group" >
        <div class="form-group__container">
          <h4 class="form-group__input-name form__input-name">
            Observation
          </h4>
          <div class="">
            <textarea v-model="form.observation" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
          </div>
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

  middleware: ['auth', 'manager'],

  metaInfo () { return { title: 'Apply' } },

  data: () => ({
    form: new Form({
      state: 'true',
      date: '',
      entry_time: '',
      exit_time: '',
      observation: ''
    })
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

  },

  mounted () {
  },

  methods: {

    async submit () {
      this.form.internId = this.$route.params.internIdThree
      console.log(this.form)
      if (this.form.state === "true") {
        this.form.state = true
      } else this.form.state = false
      await this.form.post('/api/internPresence')
        .then(({ data }) => {
          this.snackbar.open(data.msg)
        })
        .then(e => {
          this.$router.back()
        })
        .catch(e => {
          this.snackbar.open(e.response.data.message)
        })
    }
  }
}
</script>
