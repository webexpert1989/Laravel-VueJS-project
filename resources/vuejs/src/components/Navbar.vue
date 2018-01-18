<template>
  <header class="app-header navbar">
    <slot></slot>
  </header>
</template>
<script>
export default {
  name: 'navbar',
  created () {
    this._navbar = true
  },
  watch: {
    '$route' (to, from) {
      console.log('To ' + to);
      console.log('From ' + from);
    }
  }
}
</script>
