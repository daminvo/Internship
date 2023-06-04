<template>
  <div class="project-box__container">
    <template v-if="role === 'student'">
      <!-- <ProjectBoxItemWaiting v-if="data.status === 'Waiting'" :data="data" /> -->
      <!-- <ProjectBoxItemAccepted v-else-if="data.status === 'Accepted'" :data="data" /> -->
      <!-- <ProjectBoxItemRejected v-else-if="data.status === 'Rejected'" :data="data" /> -->
      <ProjectBoxItemWaitingToStart :data="data" v-if="status === 'Accepted'"/>
      <!-- <ProjectBoxItemProjectStarted v-else-if="data.status === 'Project Started'" :data="data" /> -->
      <!-- <ProjectBoxItemFinished v-else-if="data.status === 'Finished'" :data="data" /> -->
      <!-- <ProjectBoxItemBailOut v-else-if="data.status === 'Bail Out'" :data="data" /> -->
    </template>
    <template v-else>
      <ProjectBoxItemHiring v-if="data.internship.state === 'available'" :data="data" />
      <ProjectBoxItemOngoing v-else-if="data.internship.state === 'ongoing'" :data="data" />
      <ProjectBoxItemConfirmation v-else-if="data.internship.state === 'Confirmation'" :data="data" />
      <ProjectBoxItemFinished v-else-if="data.internship.state === 'Finished'" :data="data" />
    </template>
  </div>
</template>

<script>
import ProjectBoxItemWaiting from '~/components/ProjectBoxItem/Student/ProjectBoxItemWaiting'
import ProjectBoxItemAccepted from '~/components/ProjectBoxItem/Student/ProjectBoxItemAccepted'
import ProjectBoxItemRejected from '~/components/ProjectBoxItem/Student/ProjectBoxItemRejected'
import ProjectBoxItemWaitingToStart from '~/components/ProjectBoxItem/Student/ProjectBoxItemWaitingToStart'
import ProjectBoxItemProjectStarted from '~/components/ProjectBoxItem/Student/ProjectBoxItemProjectStarted'
import ProjectBoxItemBailOut from '~/components/ProjectBoxItem/Student/ProjectBoxItemBailOut'
import ProjectBoxItemHiring from '~/components/ProjectBoxItem/Lecturer/ProjectBoxItemHiring'
import ProjectBoxItemOngoing from '~/components/ProjectBoxItem/Lecturer/ProjectBoxItemOngoing'
import ProjectBoxItemConfirmation from '~/components/ProjectBoxItem/Lecturer/ProjectBoxItemConfirmation'
import ProjectBoxItemFinished from '~/components/ProjectBoxItem/Lecturer/ProjectBoxItemFinished'

export default {
  name: 'ProjectBoxItem',

  middleware: ['auth'],

  components: {
    ProjectBoxItemWaiting,
    ProjectBoxItemAccepted,
    ProjectBoxItemRejected,
    ProjectBoxItemWaitingToStart,
    ProjectBoxItemProjectStarted,
    ProjectBoxItemBailOut,
    ProjectBoxItemHiring,
    ProjectBoxItemOngoing,
    ProjectBoxItemConfirmation,
    ProjectBoxItemFinished,
  },

  props: {
    data: { type: Object, default: null },
    status: { type: String, default: null },
    role: { type: String, default: null }
  },

  mounted() {
    console.log(this.data.internship.state);
  },
}
</script>

<style scoped>

</style>
