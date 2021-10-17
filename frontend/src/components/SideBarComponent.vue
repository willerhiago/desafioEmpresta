<template>
  <div>
    <b-sidebar id="sidebar-no-header" aria-labelledby="sidebar-no-header-title" no-header shadow bg-variant="dark" text-variant="light" backdrop backdrop-variant="dark">
      <template #default="{ hide }">
        <div class="p-3">
          <h4 id="sidebar-no-header-title">Empresta $</h4>
           <b-img src="../assets/cofre.jpg" fluid ></b-img>
          <nav class="mb-3">
            <b-nav vertical>
              <b-nav-item href="/" text-variant="danger" @click="hide"><b-icon icon="house"/> Home</b-nav-item>
              <b-nav-item href="/simulation" @click="hide"><b-icon icon="calculator"/> Simulação de Parcelas</b-nav-item>
            </b-nav>
          </nav>
          <b-button variant="primary" block @click="hide">Fechar</b-button>
        </div>
      </template>
    </b-sidebar>
  </div>
</template>

<script>
export default {
  name: 'SideBarComponent'
}
</script>

<style scoped>
.nav-item > .nav-link{
  color:white
}
</style>
