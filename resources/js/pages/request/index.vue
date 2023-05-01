<template>
  <div class="apply__container">
    <div class="apply__top--container">
      <TopImage :type="1" />
      <h2 class="apply__top--h1">
        You Almost There!
      </h2>
      <p class="apply__top--p">
        You need to fill up the form below about yourself / team who wants to applied to <strong>{{ title }}.</strong>
      </p>
    </div>

    <div>
      <transition name="fade" mode="out-in">
        <request-page />
      </transition>
    </div>
  </div>
</template>

<script>
// import Form from 'vform'
import RequestPage from './Request.vue'

export default {
  name: 'ApplyIndex',

  middleware: ['auth', 'student'],

  components: {
    RequestPage
  },

  methods: {
    async update () {
      await this.form.post('/api/project/')

      this.form.reset()
    }
  }
}
</script>
