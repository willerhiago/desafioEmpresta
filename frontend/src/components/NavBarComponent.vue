<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-button variant="dark" v-b-toggle.sidebar-no-header><b-icon icon="list"></b-icon></b-button>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item href="/">Home</b-nav-item>
          <b-nav-item href="/simulation">Simulação</b-nav-item>
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <span class="text-light bg-dark align-bottom">EMPRESTA</span>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: 'NavBarComponent'
}
</script>

<style scoped>
</style>
