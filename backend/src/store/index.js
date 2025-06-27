import {createStore} from "vuex";

import * as action from "./actions";
import * as mutation from "./mutations";
import state from './state.js'

const store = createStore({
    state,
    getters: {},
    actions: action,
    mutations: mutation

})

export default store;
