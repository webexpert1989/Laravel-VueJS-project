  <template>
    <div class="custom-actions">
      <button class="btn btn-primary btn-sm" @click="itemAction('edit', rowData, rowIndex)">
        <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-danger  btn-sm" @click="itemAction('delete', rowData, rowIndex)">
        <i class="fa fa-trash"></i>
      </button>
    </div>
</template>

  <script>
  import axios from 'axios'
  export default {
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      },
      actionUrl: {
        type: String
      }
    },
    data: () => ({
        headers: {
          'X-CSRF-TOKEN': Laravel.csrfToken,
          'content-type': 'multipart/form-data'
        },
    }),
    methods: {
      itemAction (action, data, index) {
        let v = this;
        if(action=='edit'){
          this.$router.replace(this.actionUrl+'/'+data.id);
        }else if(action=='delete'){
          this.$Progress.start()
          axios.post(
            base_url+v.actionUrl+'/delete',
            {id: data.id},
            this.headers
          ).then((resp) => {
            console.log(resp);
            this.$Progress.finish()
            v.$parent.refresh();        
          }).catch((err) => {
            console.log(err);
            this.$Progress.finish()
          });          
        }
        return;
      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>
