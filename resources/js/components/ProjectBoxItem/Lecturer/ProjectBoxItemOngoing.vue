<template>
  <div>
    <div class="project-box__top-container">
      <router-link :to="{ name: 'offer.details', params: { id: data.id } }">
        <img class="project-box__item--img" :src="getImageUrl(data.photo)" alt="">
      </router-link>
      <div class="project-box__item--container">
        <div>
          <span class="project-box__item--title">{{ data.internship.title }}</span>
        </div>

        <div class="project-box__item--lecture-statuses">
          <div class="project-box__item--status-lecturer">
            <span class="iconify" data-icon="ic:round-access-time" width="12" height="12" />
            <span v-if="$matchMedia.sm" class="pre">Posted on </span> {{ date }}
          </div>
          <div class="project-box__item--status-lecturer">
            <span class="project-box__item--lecturer-icon"><b>O</b></span>
            <span>Ongoing</span>
          </div>
        </div>

        <div v-if="$matchMedia.xl">
          <p class="mb-1_5">
            {{ data.internship.description }}
          </p>
        </div>
        <div v-else class="project-box__details--container" @click="showDetails">
          <span class="project-box__item--details pointer">Details</span>
          <div v-show="show">
            <span class="iconify project-box__close-button" data-icon="ion:close" />
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile User -->
    <div v-show="show && !$matchMedia.xl" class="mt-2">
      <p class="mb-1_5">
        {{ data.internship.description }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProjectBoxItemOngoing',

  middleware: ['auth'],

  props: {
    data: { type: Object, default: null }
  },

  data: () => ({
    date: '',
    show: false
  }),

  setup() {
    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/thumbnail/' + name;
    }

    return { getImageUrl }
  },

  mounted () {
    const date = new Date(this.data.internship.demand_date)
    let options = { day: 'numeric', year: 'numeric', month: 'long' }
    this.date = date.toLocaleString('en-US', options)
  }

}
</script>
