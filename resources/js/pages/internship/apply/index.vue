<template>
  <div class="apply__container">
    <div class="apply__top--container">
      <TopImage :type="1" />
      <h2 class="apply__top--h1">
        Applying form
      </h2>
      <p class="apply__top--p">
        You need to fill up the form below to applie to <strong>{{ title }}.</strong>
      </p>
    </div>

    <div>
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>

export default {
  name: 'ApplyIndex',

  middleware: ['auth', 'student'],

  computed: {
    title () {
      return this.$route.params.title
    },

  },
}
</script>
