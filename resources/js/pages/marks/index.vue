<template>
  <div class="apply__container">
    <div class="apply__top--container">
      <TopImage :type="1" />
      <h2 class="apply__top--h1"></h2>
      <p class="apply__top--p">
        <!-- You need to fill up the form below about yourself / team who wants to applied to <strong>{{ title }}.</strong> -->
      </p>
    </div>

    <div>
      <transition name="fade" mode="out-in">
        <InternMarks />
      </transition>
    </div>
  </div>
</template>

<script>

import InternMarks from './InternMarks.vue'

export default {
  name: 'MarksIndex',

  middleware: ['auth', 'manager'],

  components: {
    InternMarks
  },

  methods: {
  }
}
</script>
