<template>
  <div class="card">
    <div class="card-header"><strong>{{this.$lang.messages.feed_source}}</strong></div>
    <div class="card-block">
      <form action="/feed/store" method="post" class="form-horizontal" ref="feedsrcForm">
        <div class="form-group row" :class="{'has-danger':errors.has('feedName')}">
          <label for="feedName" class="col-sm-3 form-control-label">{{this.$lang.messages.feed_name}}</label>
          <div class="col-sm-6">
            <input type="text" id="feedName" ref="feedName"  v-validate="'required'" name="feedName"
                   :placeholder="this.$lang.messages.feed_name"
                   v-model="feed.title"
                   class="form-control input-sm">
            <span v-show="errors.has('feedName')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
          </div>
        </div>
        <div class="form-group row" :class="{'has-danger':errors.has('feedUrl')}">
          <label class="col-sm-3 form-control-label" for="logo-select">{{this.$lang.messages.feed_logo}}</label>
          <div class="col-sm-6" id="logo-select">
            <Dropzone
              id="feedLogo"
              ref="feedLogo"
              url="/feed/upload"
              @vdropzone-success="showSuccess"
              @vdropzone-mounted = "mountedDropzone"
              :max-number-of-files="1"
              :add-remove-links="true"
              :headers="headers"
              :resize-width="256"
              :resize-height="256"
              :accepted-file-types="'image/*'"
              :duplicate-check="true"
              :preview-template="template">
            </Dropzone>
            <span>(If you want to change Logo, please upload image here)</span>
            <input v-model="feed.url" hidden v-validate="'required'" name="feedUrl"/>
            <span v-show="errors.has('feedUrl')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button class="btn btn-sm btn-primary" @click.prevent="onSubmit">
        <i class="fa fa-dot-circle-o"></i> {{this.$lang.messages.submit}}
      </button>
      <button type="reset" class="btn btn-sm btn-danger" @click="onResetForm">
        <i class="fa fa-ban"></i> {{this.$lang.messages.reset}}
      </button>
      <button class="btn btn-sm btn-success pull-right" v-on:click="goToBack">{{this.$lang.messages.back}}</button>
    </div>
  </div>
</template>

<script>
  import Dropzone from 'vue2-dropzone';
  import axios from 'axios'

  export default {
    components: {
      Dropzone,
    },
    name: 'feedsrc_crud',
    data() {
      return {
        headers: {
          'X-CSRF-TOKEN': Laravel.csrfToken
        },
        feed: {
          title: '',
          url: ''
        }
      }
    },
    methods: {
      onSubmit(e) {
        let vm = this;
        this.$validator.validateAll().then(function(result){
          if(result){
            this.$Progress.start();
            let form = vm.$refs.feedsrcForm;
            let data = {
              title: vm.feed.title,
              url: vm.feed.url,
              id: vm.$route.params.id?vm.$route.params.id:''
            }
            axios.post(
              form.action,
              data,
              vm.headers
            ).then((resp) => {
              this.$Progress.finish();
              vm.$swal({title: "Good job!",
                text: "Your request has done successfully!",
                type: "success",
                confirmButtonColor: "#007AFF"}).then(function(){
                    vm.$router.replace('/feedsrcs');
                });
            }).catch((err) => {
              this.$Progress.finish();
              vm.$swal({
                  title: "Failed!",
                  text: "Your reuest have been failed!",
                  type: "warning",
                  confirmButtonColor: "#007AFF"
              });
            });
          }
        });        
      },

      onResetForm(e) {      
        this.$refs.feedLogo.removeAllFiles();
        this.$refs.feedName.value = '';
      },

      showSuccess(file) {
        let json = JSON.parse(file.xhr.response);
        this.feed.url = json.url;
      },
      goToBack: function() {
        this.$router.replace('/feedsrcs');
      },

      template() {
        return `
          <div class="dz-preview dz-file-preview">
            <div class="dz-image" style="width: 200px;height: 200px">
                <img data-dz-thumbnail /></div>
            <div class="dz-details">
              <div class="dz-size"><span data-dz-size></span></div>
              <div class="dz-filename"><span data-dz-name></span></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="dz-success-mark"><i class="fa fa-check"></i></div>
            <div class="dz-error-mark"><i class="fa fa-close"></i></div>
          </div>`;
      },
      mountedDropzone: function(){
        if(this.$route.params.id){
          this.$Progress.start();
          axios.post(
            base_url+'/feed/get_feed',
            {id: this.$route.params.id},
            this.headers
          ).then((resp) => {
            console.log(resp);
            this.feed.title = resp.data.feed.title;
            this.feed.url = resp.data.feed.logo;
            let filename = resp.data.feed.logo.split("/")[1];
            this.$refs.feedLogo.manuallyAddFile(
              {
                 name: filename, size: resp.data.feed.filesize
             },
             resp.data.feed.logo,
             null,
             null,
            {
             dontSubstractMaxFiles: true,
             addToFiles: true
            });
            this.$Progress.finish();
            
          }).catch((err) => {
            console.log(err);
            this.$Progress.finish();
          });
        }
      }
    },
    mounted: function() {
      console.log(this.$route.params.id);      
    }
  }
</script>