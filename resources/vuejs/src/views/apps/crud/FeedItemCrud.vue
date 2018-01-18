<template>
  <div class="card">
    <div class="card-header"><strong>{{this.$lang.messages.feed_source}}</strong></div>
    <div class="card-block">
      <form action="/feeditem/update" method="post" class="form-horizontal" ref="feedsrcForm">
        <div class="form-group row">
          <label for="feedName" class="col-sm-3 form-control-label">{{this.$lang.messages.feed_name}}</label>
          <div class="col-sm-6">
            <input type="text" id="feedName" ref="feedName" name="feedName"
                   :placeholder="this.$lang.messages.feed_name"
                   v-model="feed.title"
                   class="form-control input-sm">            
          </div>
        </div>
        <div class="form-group row" :class="{'has-danger':errors.has('feedLink')}">
          <label for="feedName" class="col-sm-3 form-control-label">{{this.$lang.messages.link}}</label>
          <div class="col-sm-6">
            <input type="text" id="feedLink" ref="feedLink" name="feedLink" v-validate="'required'" 
                   :placeholder="this.$lang.messages.link"
                   v-model="feed.link"
                   class="form-control input-sm">
            <span v-show="errors.has('feedLink')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
          </div>
        </div>
        <div class="form-group row" :class="{'has-danger':errors.has('feedTeamName')}">
          <label for="feedName" class="col-sm-3 form-control-label">{{this.$lang.messages.team_name}}</label>
          <div class="col-sm-6">
            <input type="text" id="feedTeamName" ref="feedTeamName" v-validate="'required'" name="feedTeamName" 
                   :placeholder="this.$lang.messages.team_name"
                   v-model="feed.team_name"
                   class="form-control input-sm">
            <span v-show="errors.has('feedTeamName')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
          </div>
        </div>
        <div class="form-group row">
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
            <input v-model="feed.url" hidden/>
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
          logo: '',
          team_name: '',
          link: ''
        },
        default_title:''
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
              title: ((vm.feed.title==vm.default_title)||(!vm.feed.title.length)?'':vm.feed.title),
              team_name: vm.feed.team_name,
              logo: vm.feed.logo,
              link: vm.feed.link,
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
                  vm.$router.replace('/feeditems');
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
        this.feed.logo = json.url;
      },
      goToBack: function() {
        this.$router.replace('/feeditems');
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
          axios.post(
            base_url+'/feeditem/get_feed_item',
            {id: this.$route.params.id},
            this.headers
          ).then((resp) => {
            console.log(resp);
            this.feed.title = resp.data.feeditem.feed_title;
            this.feed.team_name = resp.data.feeditem.team_name;
            this.feed.link = resp.data.feeditem.link;
            this.default_title = resp.data.feeditem.default_title;
            let filename = resp.data.feeditem.logo.split("/")[1];
            this.$refs.feedLogo.manuallyAddFile(
              {
                 name: filename, size: resp.data.feeditem.filesize
             },
             resp.data.feeditem.logo,
             null,
             null,
            {
             dontSubstractMaxFiles: true,
             addToFiles: true
            });
            
          }).catch((err) => {
            console.log(err);
          });
        }
      }
    },
    mounted: function() {
      console.log(this.$route.params.id);
      
    }
  }
</script>