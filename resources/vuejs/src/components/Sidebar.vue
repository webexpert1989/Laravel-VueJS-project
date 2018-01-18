<template>
  <div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <!--=====================================================================================-->
        <li class="nav-title">App Elements</li>
        <li class="nav-item">
          <router-link :to="'/apps'" class="nav-link" exact>
            <i class="fa fa-tablet"></i> Apps
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="'/feedsrcs'" class="nav-link" exact>
            <i class="fa fa-feed"></i> Feed Sources
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="'/feeditems'" class="nav-link" exact>
            <i class="fa fa-feed"></i> Feed Items
          </router-link>
        </li>

        <!--=====================================================================================-->
        <li class="divider"></li>
        <li class="nav-title">Users</li>
        <li class="nav-item">
          <router-link :to="'/profile'" class="nav-link" exact>
            <i class="fa fa-user"></i> My Profile
          </router-link>
        </li>
        <li class="nav-item">
          <router-link :to="'/users'" class="nav-link" exact>
            <i class="fa fa-users"></i> Users
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="#" class="nav-link" @click.native="logout">
            <i class="fa fa-sign-out"></i> Logout
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>

  export default {
    name: 'sidebar',
    methods: {
      handleClick(e) {
        e.preventDefault();
        e.target.parentElement.classList.toggle('open');
      },

      logout(e) {
        e.preventDefault();
        document.getElementById('logout-form').submit();
      }
    }
  }
</script>

<style lang="css">
  .nav-link {
    cursor: pointer;
  }
</style>
