<template>
  <div class="ui container animated fadeIn col-lg-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{this.$lang.messages.apps}}
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
  //import Vue from 'vue'
  //Vue.component("datatable", DataTable)

  export default {
    name: 'apps',
    components: {
      DataTable
    },
    data() {
      return {
        options: {
          dataUrl: '/datatable/app',
          searchHint: 'Search Apps',
          actionUrl: '/app',
          fields: [
            {
              name: '__sequence',
              title: '#'
            },
            {
              name:'__slot:view-logo',
              title: this.$lang.messages.logo
            },
            {
              name: 'title',
              title: this.$lang.messages.title
            },
            {
              name: 'bundle_id',
              title: this.$lang.messages.bundle_id
            },
            {
              name: 'layout',
              title: this.$lang.messages.layout
            },
            {
              name: '__slot:view-color',
              title: this.$lang.messages.background
            },
            {
              name: '__slot:custom-actions',
              title: this.$lang.messages.actions
            }
          ],
          rowTemplate: {},
          sortOrder: [
            {field: 'name', direction: 'asc'}
          ],
          sortable: [],
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
      editRow(rowData) {
        alert("You clicked edit on" + JSON.stringify(rowData))
      },
      deleteRow(rowData) {
        alert("You clicked delete on" + JSON.stringify(rowData))
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