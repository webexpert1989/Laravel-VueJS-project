<template>
  <navbar>
    <a class="navbar-brand" href="#"></a>

    <ul class="nav navbar-nav ml-auto">
      <Dropdown transition="fade">
        <button data-role="trigger" class="btn btn-default dropdown-menu-btn dropdown-toggle" type="button">
          <img src="static/img/earth-spinning.gif"> Language
        </button>
        <template slot="dropdown" v-on:input="onChange" >
          <li value="en"><a class="dropdown-item" href="#"><img src="static/img/flags/USA.png" class="lang-item"> English</a></li>
          <li value="fi"><a class="dropdown-item" href="#"><img src="static/img/flags/Finland.png" class="lang-item"> Finnish</a></li>
          <li value="sv"><a class="dropdown-item" href="#"><img src="static/img/flags/Sweden.png" class="lang-item"> Swedish</a></li>
        </template>
      </Dropdown>
    </ul>

  </navbar>
</template>
<script>

  import navbar from './Navbar'
  import {Dropdown} from 'uiv'

  export default {
    name: 'header',
    components: {
      navbar,
      Dropdown
    },
    methods: {
      onChange(e) {
        console.log(e);
      },
      click() {
        // do nothing
      },
      sidebarToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-hidden')
      },
      sidebarMinimize(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-minimized')
      },
      mobileSidebarToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-mobile-show')
      },
      asideToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('aside-menu-hidden')
      }
    }
  }
</script>
<style>
  .dropdown-menu-btn {
    border: transparent;
    background: transparent;
  }
  .lang-item {
    width: 15px;
    height: 15px;
  }
</style>
