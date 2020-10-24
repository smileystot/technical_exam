import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

export default new Vuex.Store({
    plugins:[createPersistedState()],
    state:{
        user:{
            FirstName: 'Juan',
            LastName: 'Dela Cruz'
        },
        isLoggedIn: false,
    },
    actions:{},
    mutations:{
        SET_USER_DATA(state,data){
            state.user = data
            state.isLoggedIn = true
            location.replace(`/dashboard`)
        },
        LOGOUT(state){
            state.user = {}
            state.isLoggedIn = false
        }
    },
});