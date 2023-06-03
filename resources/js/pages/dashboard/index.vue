<template>
  <div>
    <StudentDashboard v-if="user.role === 'student'" />
    <HeaderDashboardVue v-if="user.role === 'header'" />
    <ManagerDashboardVue v-if="user.role === 'manager'"/>

  </div>
</template>

<script>
import HeaderDashboardVue from './HeaderDashboard.vue'
import ManagerDashboardVue from './ManagerDashboard.vue'
import StudentDashboard from './StudentDashboard.vue'
import { mapGetters } from 'vuex'


export default {

  components: {
    StudentDashboard,
    ManagerDashboardVue,
    HeaderDashboardVue
  },

  name: 'UserDashboardIndex',

  middleware: ['auth'],

  computed: {
    ...mapGetters({
      user: 'auth/user'
    }),
  },
}



</script>

<style>
</style>
