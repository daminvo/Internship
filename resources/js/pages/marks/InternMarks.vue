
<template>
    <div class="">

      <h4 class="form-group__input-name form__input-name h4-title">
        Evaluation
      </h4>

      <div class="group__container">
        <div class="rate-container">
          <h6 class="form-group__input-name">
            Discipline
          </h6>
          <div class="rating-selector">
            <div class="stars">
              <span
                v-for="rating in maxRating"
                :key="rating"

                @click="selectRating($event, rating, 'remarkOne')"
              >
                <span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91"/>
                &nbsp;
                <!-- <span v-else class="iconify" data-icon="clarity:star-line" width="24" height="24" /> -->
              </span>
            </div>
            <div class="selected-rating">{{ remarkOne }}</div>
          </div>
        </div>

        <div class="rate-container">
          <h6 class="form-group__input-name">
            work skills and handling
          </h6>
          <div class="rating-selector">
            <div class="stars">
              <span
                v-for="rating in maxRating"
                :key="rating"

                @click="selectRating($event, rating, 'remarkTwo')"
              >
                <span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ remarkTwo }}</div>
          </div>
        </div>

        <div class="rate-container">
          <h6 class="form-group__input-name">
            Initiative / entrepreneurship
          </h6>
          <div class="rating-selector">
            <div class="stars">
              <span
                v-for="rating in maxRating"
                :key="rating"

                @click="selectRating($event, rating, 'remarkThree')"
              >
                <span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ remarkThree }}</div>
          </div>
        </div>

        <div class="rate-container">
          <h6 class="form-group__input-name">
            Imagination skills and innovation
          </h6>
          <div class="rating-selector">
            <div class="stars">
              <span
                v-for="rating in maxRating"
                :key="rating"

                @click="selectRating($event, rating, 'remarkFour')"
              >
                <span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ remarkFour }}</div>
          </div>
        </div>

        <div class="rate-container">
          <h6 class="form-group__input-name">
            Knowledge acquired on the internship site
          </h6>
          <div class="rating-selector">
            <div class="stars">
              <span
                v-for="rating in maxRating"
                :key="rating"

                @click="selectRating($event, rating, 'remarkFive')"
              >
                <span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ remarkFive }}</div>
          </div>
        </div>

      </div>


        <!-- <section>
          <hr class="form--hr">
          <h4 class="form-group__input-name form__input-name h4-title">
            Inernship Informations
          </h4>

          <div class="form-group__container">
              <h6 class="form-group__input-name">
                  Tell us about it
              </h6>

            </div>

          <div class="form__input--group">
            <div class="form-group__container">
              <h6 class="form-group__input-name">
                Start date
              </h6>

            </div>
            <div class="form-group__container">
              <h6 class="form-group__input-name">
                End date
              </h6>
              <div class="">

              </div>
            </div>

            <div class="form-group__container">
                <h6 class="form-group__input-name">
                  Duration
                </h6>
                <div class="select select--small select--border" required>
                  <select name="" id="" >
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
              <textarea  class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />
            </div>
          </div>
        </section> -->

      <div class="">
        <!-- Submit Button -->
        <v-button class="btn btn--blue btn--large apply__btn-submit">
          <span>
            Submit
          </span>
          <span class="iconify" data-icon="si-glyph:paper-plane" />
        </v-button>
      </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'marks Page',

  middleware: ['auth', 'student'],

  metaInfo () { return { title: 'marks' } },

  data: () => {
    // const RatingStars = document.getElementById('stars')
    return{
      maxRating: 4,
      selectedRating: 2,
      remarks: ['Very Weak', 'Weak', 'Good', 'Very Good', 'Excellent'],
      remarkOne: 'Very Weak',
      remarkTwo: 'Very Weak',
      remarkThree: 'Very Weak',
      remarkFour: 'Very Weak',
      remarkFive: 'Very Weak',
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      snackbar: 'notification/snackbar'
    }),

  },

  watch: {
    selectedRating() {
      return this.selectedRating
    }
  },

  created() {

  },

  mounted () {


  },

  methods: {
    selectRating($event, rate, remarkName) {
      const stars = $event.currentTarget.parentElement.children
      for (let i = 0; i < stars.length; i++) {
        if (i + 1  <= rate) {
          stars[i].firstChild.innerHTML = `<span class="iconify" data-icon="clarity:star-solid" width="32" height="32" color="#2b6e91" @click="selectRating(rating)"/>`
        }
        else {
          stars[i].firstChild.innerHTML = `<span class="iconify" data-icon="clarity:star-line" width="32" height="32" color="#2b6e91" @click="selectRating(rating)"/>`
        }

      }
      this.selectedRating = rate;
      this[remarkName] = this.remarks[rate]
    },

    async submit () {

    }
  }
}
</script>


<style scoped>

.rate-container {
  margin-bottom: 4rem;
  width: 100%;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: center;
}

.rate-container h6 {
  margin-top: 1rem;
  max-width: 550px;
  min-width: 300px;
  flex-grow: 1;
}

.group__container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.h4-title {
  margin: 3vw 0;
  font-weight: 700;
  text-align: center;
}

select {
  text-align: center;
}

.rating-selector {
  display: flex;
  align-items: center;
  flex-direction: column;
}

.stars {
  display: flex;
}

.selected-rating {
  font-size: 24px;
  font-weight: bold;
  margin-left: 8px;
  color: #0f3755;
}
</style>






