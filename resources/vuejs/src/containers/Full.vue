<template>
  <div class="app">
    <AppHeader/>
    <div class="app-body">
      <Sidebar/>
      <main class="main">
        <!--<Breadcrumb :list="list"/>-->
        <div class="container-fluid" style="margin-top: 1.5rem;">
          <router-view></router-view>
        </div>
      </main>
    </div>
    <AppFooter/>
  </div>
</template>

<script>
  import AppHeader from '../components/Header'
  import Sidebar from '../components/Sidebar'
  import AppFooter from '../components/Footer'
  import Breadcrumb from '../components/Breadcrumb'

  export default {
    name: 'full',
    components: {
      AppHeader,
      Sidebar,
      AppFooter,
      Breadcrumb
    },
    computed: {
      name() {
        return this.$route.name
      },

      list() {
        return this.$route.matched
      }
    }
  }
</script>
