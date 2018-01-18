<template>
  <div>
    <FilterBar :searchHint="options.searchHint"></FilterBar>
    <vuetable
      ref="vuetable"
      :api-url="options.dataUrl"
      :fields="options.fields"
      pagination-path=""
      :css="css.table"
      :append-params="options.moreParams"
      @vuetable:cell-clicked="onCellClicked"
      @vuetable:pagination-data="onPaginationData">
      <template slot="view-logo" scope="props">
         <div>
            <img :src="props.rowData.logo" height=32>
         </div>
      </template>
      <template slot="view-color" scope="props">
        <div>
            <div style="width:48px;height:32px;border:1px solid #ccc" :style="'background-color:'+'rgba('+props.rowData.background+')'"></div>
         </div>
      </template>
      <template slot="custom-actions" scope="props">
       <CustomActions :rowData="props.rowData" :rowIndex="props.rowIndex" :actionUrl="options.actionUrl"></CustomActions>
      </template>
    </vuetable>

    <div class="vuetable-pagination">
      <vuetable-pagination-info
        ref="paginationInfo"
        info-class="pagination-info">
      </vuetable-pagination-info>

      <vuetable-pagination
        ref="pagination"
        :css="css.pagination"
        @vuetable-pagination:change-page="onChangePage">
      </vuetable-pagination>
    </div>
  </div>
</template>

<script>
  import {install} from 'vuetable-2'
  import Vue from 'vue'
  import VueEvents from 'vue-events'
  import CustomActions from './CustomActions'
  import FilterBar from './FilterBar'

  Vue.use(VueEvents)
  install(Vue);
  Vue.component('CustomActions', CustomActions);

  export default {
    props: {
      options: Object
    },
    components: {
      FilterBar
    },
    data: function () {
      return {
        css: {
          table: {
            tableClass: 'table table-striped table-hover',
            ascendingIcon: 'fa fa-sort-asc',
            descendingIcon: 'fa fa-sort-desc'
          },
          pagination: {
            wrapperClass: 'pagination',
            activeClass: 'active',
            disabledClass: 'disabled',
            pageClass: 'page',
            linkClass: 'link',
            icons: {
              first: 'fa fa-fast-backward',
              prev: 'fa fa-backward',
              next: 'fa fa-forward',
              last: 'fa fa-fast-forward',
            }
          }
        }
      }
    },
    methods: {
      onPaginationData(paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
        this.$refs.paginationInfo.setPaginationData(paginationData)
      },
      onChangePage(page) {
        this.$refs.vuetable.changePage(page)
      },
      onCellClicked(data, field, event) {
        console.log('cellClicked: ', field.name)
        this.$refs.vuetable.toggleDetailRow(data.id)
      },
      drawStatus(value) {
        return value ?
          '<span class="badge badge-success"><i class="fa fa-check"></i> Enabled</span>' :
          '<span class="badge badge-danger"><i class="fa fa-ban"></i> Disabled</span>';
      },
    },
    events: {
      'filter-set'(filterText) {
        this.moreParams = {
          filter: filterText
        }
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      'filter-reset'() {
        this.moreParams = {}
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      }
    }
  }
</script>

<style>
  .pagination {
    margin: 0;
    float: right;
  }

  .pagination a.page {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
  }

  .pagination a.page.active {
    color: white;
    background-color: #337ab7;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
  }

  .pagination a.btn-nav {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
  }

  .pagination a.btn-nav.disabled {
    color: lightgray;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
    cursor: not-allowed;
  }

  .pagination-info {
    float: left;
  }
</style>