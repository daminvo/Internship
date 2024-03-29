<template>
  <div class="profile--container">
    <div class="profile__info--container">
      <img class="profile__info--img" :src="getImageUrl(user.photo)" alt="">

      <div class="profile__info--desc" v-if="user.role === 'student'">
        <p class="profile__info--name">
          {{ user.first_name }} {{ user.family_name }}
        </p>
        <p class="profile__info--expertise">
          <span class="iconify" data-icon="fa-solid:paint-brush" width="15" height="10" /> {{ user.role }}
        </p>
        <p v-if="!$matchMedia.xl" class="profile__info--occupation">
          <!-- {{ major }} <br> -->
          {{ user.student.universityName }} <br>
          {{ user.address }}
        </p>
        <p v-else class="profile__info--occupation">
          {{ user.student.speciality }} /
          {{ user.student.universityName }} <br>
          {{ user.address }}
        </p>

        <div v-if="$matchMedia.xl" class="profile__info--buttons">
          <router-link :to="{ path: '/profile/edit' }" class="profile__info--edit-profile" tag="button">
            Edit Profile
          </router-link>
        </div>

        <p v-if="user.role === 'student'" :class="userStatus.class">
          <span class="iconify profile__info--icon" data-icon="carbon:dot-mark" />
          <span>{{ userStatus.text }}</span>
        </p>
        <p v-else-if="user.role === 'Lecturer'" :class="userStatus.class">
          <span class="iconify profile__info--icon" data-icon="bi:shield-fill-check" />
          <span>{{ userStatus.text }}</span>
        </p>
      </div>

      <div class="profile__info--desc" v-if="user.role === 'header'">
        <p class="profile__info--name">
          {{ user.first_name }} {{ user.family_name }}
        </p>
        <p class="profile__info--expertise">
          <span class="iconify" data-icon="fa-solid:paint-brush" width="15" height="10" /> {{ user.role }}
        </p>
        <p v-if="!$matchMedia.xl" class="profile__info--occupation">
          <!-- {{ major }} <br> -->
          {{ user.header.universityName }} <br>
          {{ user.address }}
        </p>
        <p v-else class="profile__info--occupation">
          {{ user.header.universityName }} <br>
          {{ user.address }}
        </p>

        <div v-if="$matchMedia.xl" class="profile__info--buttons">
          <router-link :to="{ path: '/profile/edit' }" class="profile__info--edit-profile" tag="button">
            Edit Profile
          </router-link>
        </div>

        <p v-if="user.role === 'student'" :class="userStatus.class">
          <span class="iconify profile__info--icon" data-icon="carbon:dot-mark" />
          <span>{{ userStatus.text }}</span>
        </p>
        <p v-else-if="user.role === 'Lecturer'" :class="userStatus.class">
          <span class="iconify profile__info--icon" data-icon="bi:shield-fill-check" />
          <span>{{ userStatus.text }}</span>
        </p>
      </div>

    </div>

    <router-link v-if="!$matchMedia.xl" :to="{ path: '/profile/edit' }" class="edit-profile__link">
      <div class="profile__info--edit-profile">
        Edit Profile
      </div>
    </router-link>

    <div v-if="!$matchMedia.xl" class="user__sub-menu--container">
      <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }" class="user__sub-menu--item" active-class="user__sub-menu--active">
        {{ tab.name }}
      </router-link>
    </div>

    <div v-if="$matchMedia.xl" class="user__sub-menu">
      <div class="user__sub-menu--left">
        <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }" class="user__sub-menu--item" active-class="user__sub-menu--active">
          {{ tab.name }}
        </router-link>
      </div>
      <!-- <div class="user__sub-menu--right">
        <div>filter</div>
        <div>time</div>
      </div> -->
    </div>

    <hr v-if="$matchMedia.xl" class="separator-short mt-2_5 mb-3">

    <div class="">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'UserProfileIndex',

  middleware: ['auth'],

  computed: {
    ...mapGetters({
      user: 'auth/user'
    }),

    tabs () {
      if (this.user.role === 'student') {
        return [
          { name: 'Info', route: 'profile.info' },
          { name: 'Favorites', route: 'profile.favorites' },
        ]
      }

      return [
        { name: 'Info', route: 'profile.info' },
        { name: 'Projects', route: 'profile.projects' },
      ]
    },

    major () {
      if (this.user.role === 'student') return this.user.major + ' Major'
      else return this.user.major
    },

    userStatus () {
      if (this.user.role === 'student') {
        return {
          class: this.user.student.available ? 'profile__info--available' : 'profile__info--unavailable',
          text: this.user.student.available ? 'Available' : 'Unavailable' }
      }

      return { class: 'profile__info--verified', text: 'Verified' }
    },
  },

  setup() {

    const getImageUrl = (name) => {
      if (name === null) return '/images/missing-avatar.svg'
      else return window.location.origin + '/storage/images/avatar/' + name;
    }

    return { getImageUrl }
  }
}
</script>

<style>
</style>
