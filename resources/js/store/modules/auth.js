import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  user: null,
  data: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => {
    console.log('entered');
    return state.user

  } ,
  data: state => state.data,
  projects: state => state.data.projects,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN] (state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  [types.FETCH_USER_SUCCESS] (state, { user, projects, favorites }) {
    state.user = user
    state.data = {
      // projects: projects,
      favorites: favorites
    }
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.UPDATE_USER] (state, { user }) {
    state.user = user
  },

  [types.UPDATE_USER_AVATAR] (state, { photo }) {
    state.user.photo = photo
  },

  [types.UPDATE_USER_CV] (state, { cv }) {
    state.user.student.cv = cv
  },

  [types.UPDATE_USER_FAVORITES] (state, { favorites }) {
    state.data.favorites = favorites
  },

  [types.UPDATE_USER_NOTIFICATIONS] (state, count) {
    state.user.new_notifications_count = count
  },

  [types.LOGOUT] (state) {
    state.user = null
    state.data = null
    state.token = null

    Cookies.remove('token')
  },

  [types.GET_INTERNSHIPS] (state, { pending, finished, accepted}) {
    state.data = {
      favorites: state.data.favorites,
      pending,
      finished,
      accepted
    }
  }
}

// actions
export const actions = {

  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({commit, dispatch}) {
    try {
      const { data } = await axios.get('/api/user')

      console.log(data);


      commit(types.FETCH_USER_SUCCESS, {
        user: data.user,
        favorites: data.favorites
      })

      if (data.user.role === 'student') {
        dispatch('getInternships', {id: data.user.student.id})
      }

    } catch (error) {
      console.log('Error:', error.response)
      console.log('Status:', error.response.status)
      console.log('Data:', error.response.data)
    }
  },

  async updateAvatar ({ commit }, payload) {
    try {
      commit(types.UPDATE_USER_AVATAR, payload)
    } catch (e) { }
  },

  async updateCv ({ commit }, payload) {
    try {
      commit(types.UPDATE_USER_CV, payload)
    } catch (e) { }
  },

  async updateUser ({ commit }, payload) {
    try {
      commit(types.UPDATE_USER, payload)
    } catch (e) { }
  },

  async updateFavorites ({ commit }, payload) {
    try {
      commit(types.UPDATE_USER_FAVORITES, payload)
    } catch (e) { }
  },

  async updateNotifications ({ commit }, payload) {
    try {
      commit(types.UPDATE_USER_NOTIFICATIONS, payload)
    } catch (e) { }
  },

  async logout ({ commit }) {
    try {
      await axios.post('/api/logout')
    } catch (e) { }

    commit(types.LOGOUT)
  },

  async getInternships ({ commit }, payload) {
    let pending = []
    let finished = []
    let accepted = []

    await axios.get(`/api/getPendingRequests/${payload.studentId}`)
      .then(({ data }) => pending = data)

    await axios.get(`/api/getFinishedinternships/${payload.studentId}`)
    .then(({ data }) => finished = data)

    await axios.get(`/api/getAcceptedinternships/${payload.studentId}`)
      .then(({ data }) => accepted = data)

      // console.log(pending);
    commit(types.GET_INTERNSHIPS, { pending, finished, accepted })
  },
}
