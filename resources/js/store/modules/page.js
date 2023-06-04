import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  individuals: [],
  project: {}
}

// getters
export const getters = {
  individuals: state => state.individuals,
  project: state => state.project
}

// mutations
export const mutations = {
  [types.FETCH_SHORTLIST] (state, payload) {
    console.log(payload);
    state.individuals = payload
  }
}

// actions
export const actions = {
  async fetchShortlist ({ commit }, payload) {
    try {
      console.log('ennttereddd');
      const { data } = await axios.post('/api/getInternshipIterns', { id: payload.id})

      commit(types.FETCH_SHORTLIST, data)
    } catch (e) {
      console.log(e);
    }
  }
}
