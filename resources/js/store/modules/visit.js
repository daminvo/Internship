import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  user: {
    user: {
      avatar: null
    }
  },
  offer: {
    // applicant_type: null,
    user: {
      tagname: 0
    }
  }
}

// getters
export const getters = {
  user: state => state.user,
  offer: state => state.offer

}

// mutations
export const mutations = {
  [types.FETCH_VISITED_USER] (state, { user }) {
    state.user = user
  },
  [types.FETCH_VISITED_OFFER] (state, { offer }) {
    state.offer = offer
  }
}

// actions
export const actions = {
  async fetchVisitedUser ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/user/' + payload.userId)
      // .then(res => console.log(res))
      // .catch(e => {
      //   console.log('Error:', error.response)
      // })

      commit(types.FETCH_VISITED_USER, { user: data })
    } catch (error) {
      console.log('Error:', error.response)
     }
  },

  async fetchVisitedOffer ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/getOffre', payload )


      commit(types.FETCH_VISITED_OFFER, { offer: data[0] })


    } catch (error) {
    }
  }
}
