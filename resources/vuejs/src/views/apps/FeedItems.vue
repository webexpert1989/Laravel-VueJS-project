<template>
  <div class="ui container animated fadeIn col-lg-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{this.$lang.messages.feed_items}}
        <div class="card-actions">
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
    name: 'feeditem',
    components: {
      DataTable
    },
    data() {
      return {
        options: {
          dataUrl: '/datatable/feeditem',
          searchHint: 'Search Feeds',
          actionUrl: '/feeditem',
          fields: [
            {
              name: '__sequence',
              title: 'No'
            },
            {
              name: '__slot:view-logo',
              title: this.$lang.messages.feed_logo
            },
            {
            	name: 'feed_title',
            	title: this.$lang.messages.feed_title
            },
            {
            	name: 'app_title',
            	title: this.$lang.messages.app_title
            },
            {
            	name: 'team_name',
            	title: this.$lang.messages.team_name
            },
            {
              name: 'link',
              title: this.$lang.messages.link
            },{
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
