import axios from 'axios'
import * as types from '../mutation-types'


export const state = {
  universities: [],
  faculties: [],
  departments: [],
  companies: [],
}


export const getters = {
  getUniversities : state => state.universities,
  getFaculties : state => state.faculties,
  getDepartments : state => state.departments,
  getCompanies : state => state.companies,
}


export const mutations = {
  [types.FETCH_UNIVERSITIES] (state, payload) {
    state.universities = payload
  },
  [types.FETCH_FACULTIES] (state, payload) {
    state.faculties = payload
  },
  [types.FETCH_DEPARTMENTS] (state, payload) {
    state.departments = payload
  },
  [types.FETCH_COMPANIES] (state, payload) {
    state.companies = payload
  }
}


export const actions = {
  async fetchUniversities ({ commit }) {
    try {
      const { data } = await axios.get('/api/universities')
      console.log(data);

      commit(types.FETCH_UNIVERSITIES, data)
    } catch (e) {}
  },

  async fetchFaculties ({ commit }) {
    try {
      const { data } = await axios.get('/api/faculties')

      commit(types.FETCH_FACULTIES, data)
    } catch (e) { }
  },

  async fetchDepartments ({ commit }) {
    try {
      const { data } = await axios.get('/api/departments')

      commit(types.FETCH_DEPARTMENTS, data)
    } catch (e) { }
  },

  async fetchCompanies ({ commit }) {
    try {
      const { data } = await axios.get('/api/companies')

      commit(types.FETCH_COMPANIES, data)
    } catch (e) { }
  }
}
