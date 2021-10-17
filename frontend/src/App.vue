<template>
  <div id="app">
    <NavBarComponent/>
    <SideBarComponent/>
    <router-view/>
  </div>
</template>

<script>
import NavBarComponent from "./components/NavBarComponent"
import SideBarComponent from "./components/SideBarComponent"
export default {
  components: {
    NavBarComponent,
    SideBarComponent
  }
}
</script>

<style>
</style>
