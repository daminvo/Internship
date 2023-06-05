
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

                @click="selectRating($event, rating, 'desipline')"
              >
                <span class="iconify" :data-icon="rating <= selectedRating ? 'clarity:star-solid': 'clarity:star-line'" width="32" height="32" color="#2b6e91"/>
                &nbsp;
                <!-- <span v-else class="iconify" data-icon="clarity:star-line" width="24" height="24" /> -->
              </span>
            </div>
            <div class="selected-rating">{{ desiplineRemark }}</div>
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

                @click="selectRating($event, rating, 'work')"
              >
                <span class="iconify" :data-icon="rating <= selectedRating ? 'clarity:star-solid': 'clarity:star-line'" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ workRemark }}</div>
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

                @click="selectRating($event, rating, 'initiative')"
              >
                <span class="iconify" :data-icon="rating <= selectedRating ? 'clarity:star-solid': 'clarity:star-line'"  width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ initiativeRemark }}</div>
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

                @click="selectRating($event, rating, 'capacity')"
              >
                <span class="iconify" :data-icon="rating <= selectedRating ? 'clarity:star-solid': 'clarity:star-line'"  width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ capacityRemark }}</div>
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

                @click="selectRating($event, rating, 'acquired')"
              >
                <span class="iconify" :data-icon="rating <= selectedRating ? 'clarity:star-solid': 'clarity:star-line'" width="32" height="32" color="#2b6e91"/>
                &nbsp;
              </span>
            </div>
            <div class="selected-rating">{{ acquiredRemark }}</div>
          </div>
        </div>

      </div>

      <div>
        <div class="mark-container">
          <h6 class="form-group__input-name">
            Total Mark:
        </h6>
          <div>
            <h1 class="total-mark">{{ total }}<span class="project-box__item--p"> /20</span></h1>
          </div>
        </div>
      </div>

      <textarea v-model="appreciation" class="form-group__input-textarea" placeholder="Max. 300 words" rows="5" />

      <div>
        <!-- Submit Button -->
        <div class="btn btn--blue btn--large apply__btn-submit" @click="submit">
          <span>
            Submit
          </span>
          <span class="iconify" data-icon="si-glyph:paper-plane" />
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  name: 'marks Page',

  middleware: ['auth', 'student'],

  metaInfo () { return { title: 'marks' } },

  data: () => {
    // const RatingStars = document.getElementById('stars')
    return{
      maxRating: 5,
      selectedRating: 1,
      remarks: ['Very Weak', 'Weak', 'Good', 'Very Good', 'Excellent'],
      desiplineRemark: 'Very Weak',
      workRemark: 'Very Weak',
      initiativeRemark: 'Very Weak',
      capacityRemark: 'Very Weak',
      acquiredRemark: 'Very Weak',
      desipline: 0,
      work: 0,
      initiative: 0,
      capacity: 0,
      acquired: 0,
      total: 0,
      appreciation: ''
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
    console.log(this.$route.params.internIdTwo);
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
      this[remarkName] = rate - 1
      this[`${remarkName}Remark`] = this.remarks[rate - 1]

      this.total = this.desipline + this.work + this.initiative + this.acquired + this.capacity
    },

    async submit () {
      const data = {
        work_ability: this.work,
        discipline: this.desipline,
        initiative: this.initiative,
        capacity_imagination: this.capacity,
        acquired_knowledge:this.acquired,
        appreciation: this.appreciation,
        internId: this.$route.params.internIdTwo
      }
      axios.post('/api/evaluateIntern', data)
        .then(res => this.snackbar.open(res.data.msg))
        .then(() => this.$router.back())
        .catch(error => console.log(error.response.data))
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

.total-mark {
  font-size: 55px;
    font-weight: 900;
    margin: -7px 15px;
}

.mark-container {
  display: flex;
  flex-direction: row;
  margin-bottom: 20px;
}
</style>






