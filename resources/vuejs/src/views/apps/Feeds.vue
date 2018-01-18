<template>
  <div class="ui container animated fadeIn col-lg-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{this.$lang.messages.feed_sources}}
        <div class="card-actions">
          <router-link :to="'create'" append>
            <i class="fa fa-plus"></i>
          </router-link>
        </div>
      </div>
      <div class="card-block">
        <DataTable :options="options"></DataTable>
      </div>
    </div>
  </div>
</template>
<script>
  import DataTable from '../datatable/Datatable'

  export default {
    name: 'feedsrc',
    components: {
      DataTable
    },
    data() {
      return {
        options: {
          dataUrl: '/datatable/feed',
          searchHint: 'Search Feeds',
          actionUrl: '/feed',
          fields: [
            {
              name: '__sequence',
              title: '#'
            },
            {
              name: '__slot:view-logo',
              title: this.$lang.messages.logo
            },
            {
              name: 'title',
              title: this.$lang.messages.title
            },
            {
              name: '__slot:custom-actions',
              title: this.$lang.messages.actions
            }
          ],
        }
      };
    },
    methods: {
      onPaginationData(paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
      },
      onChangePage(page) {
        this.$refs.vuetable.changePage(page)
      },
      onLoading() {
        console.log('loading... show your spinner here')
      },
      onLoaded() {
        console.log('loaded! .. hide your spinner here')
      }
    }
  }
</script>