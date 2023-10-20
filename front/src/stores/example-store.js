import { defineStore } from 'pinia'

export const useCounterStore = defineStore('counter', {
  state: () => ({
    counter: 0,
    user: {},
    pedido: {},
    selectEmpresa: -1,
    permisos: [],
    menus: [],
    isLoggedIn: !!localStorage.getItem('tokenFolleto'),
    env: {}
  }),
  getters: {
    doubleCount: (state) => state.counter * 2
  },
  actions: {
    increment () {
      this.counter++
    }
  }
})
