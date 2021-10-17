import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Simulation from '../views/Simulation.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/simulation',
    name: 'Simulacao',
    component: Simulation
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
