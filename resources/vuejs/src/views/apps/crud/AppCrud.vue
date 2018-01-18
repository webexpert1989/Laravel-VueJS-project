<template>
    <div>
        <modal :title="modal.title" v-model="modal.visible" :modal-id="1" :bg-click="false" :verify="true" @MODAL_OK_EVENT="MODAL_OK_EVENT" @MODAL_CANCEL_EVENT="MODAL_CANCEL_EVENT">
            <form class="form-horizontal">
                <div class="form-group row" :class="{'has-danger':!modalErrors.link.valid}">
                    <label class="col-sm-3 form-control-label text-right">{{this.$lang.messages.link}}</label>
                    <div class="col-sm-6">
                        <input type="text" v-model="modal.link" class="form-control">
                        <span v-show="!modalErrors.link.valid" class="form-check-label">{{modalErrors.link.error}}</span>
                    </div>
                </div>
                <div class="form-group row" :class="{'has-danger':!modalErrors.name.valid}">
                    <label class="col-sm-3 form-control-label text-right">{{this.$lang.messages.team_name}}</label>
                    <div class="col-sm-6">
                        <input type="text" v-model="modal.team_name" class="form-control">
                        <span v-show="!modalErrors.name.valid" class="form-check-label">{{modalErrors.name.error}}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 form-control-label text-right">{{this.$lang.messages.title}}</label>
                    <div class="col-sm-6">
                        <input type="text" v-model="feed.title" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label text-right" for="logo-select">{{this.$lang.messages.feed_logo}}</label>
                  <div class="col-sm-6" id="logo-select">
                    <Dropzone
                      id="feedLogo"
                      ref="feedLogo"
                      url="/feed/upload"
                      @vdropzone-success="showSuccess"
                      :max-number-of-files="1"
                      :add-remove-links="true"
                      :headers="headerwith"
                      :resize-width="256"
                      :resize-height="256"
                      :accepted-file-types="'image/*'"
                      :duplicate-check="true"
                      :preview-template="template">
                    </Dropzone>
                    <input v-model="feed.url" hidden/>
                    <span> (If you want to change feed logo, please upload image)</span>
                  </div>
                </div>
            </form>
        </modal>
        <div class="card">
            <div class="card-header">
                <strong>{{this.$lang.messages.create_app}}</strong>
            </div>
            <div class="card-block">
                <form-wizard @on-complete="onComplete" :title="this.$lang.messages.create_app_wizard" subtitle="">

                  <tab-content :title="this.$lang.messages.app_title_bundle_id" :before-change="goToStep2">
                    <h4>{{this.$lang.messages.app_title_bundle_id}}</h4>
                    <hr>
                    <form action="" method="post" class="form-horizontal ">
                        <div class="form-group row" :class="{'has-danger':errors.has('app_name')}">
                            <label for="app_name" class="col-sm-3 form-control-label text-right">{{this.$lang.messages.app_title}}</label>
                            <div class="col-sm-6">
                                <input type="text" v-validate="'required'" v-model="app_name" id="app_name" name="app_name" :placeholder="this.$lang.messages.app_title" class="form-control">
                                <span v-show="errors.has('app_name')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
                            </div>
                        </div>
                        <div class="form-group row" :class="{'has-danger':errors.has('bundle_id')}">
                            <label for="bundle_id" class="col-sm-3 form-control-label text-right">{{this.$lang.messages.bundle_id}}</label>
                            <div class="col-sm-6">
                                <input type="text" id="bundle_id" v-validate="'required'" v-model="bundle_id" name="bundle_id" :placeholder="this.$lang.messages.bundle_id" class="form-control">
                                <span v-show="errors.has('bundle_id')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
                            </div>
                        </div>
                        <div class="form-group row" :class="{'has-danger':errors.has('fcm_key')}">
                            <label for="fcm_key" class="col-sm-3 form-control-label text-right">{{this.$lang.messages.fcm_key}}</label>
                            <div class="col-sm-6">
                                <input type="text" id="fcm_key" v-validate="'required'" v-model="fcm_key" name="fcm_key" :placeholder="this.$lang.messages.fcm_key" class="form-control">
                                <span v-show="errors.has('fcm_key')" class="form-check-label">{{this.$lang.messages.valid1}}</span>
                            </div>
                        </div>
                    </form>
                  </tab-content>
                  <tab-content :title="this.$lang.messages.select_layout" :before-change="goToStep3">
                    <h4>{{this.$lang.messages.layout}}</h4>
                    <hr>
                        <div class="bg-danger warning" v-show="warnLayout">Please Select Layout!</div>
                        <div class="row">
                          <ul class="choose-prototype">
                            <li v-on:click="prototype='grid'" :class="{'active':prototype=='grid'}">
                                <img src="static/img/prototype/grid.png" class="prototype-img">
                                 <span class="text-center" style="display:list-item;">{{this.$lang.messages.grid_view}}</span>
                            </li>
                            <li v-on:click="prototype='list'" :class="{'active':prototype=='list'}">
                                <img src="static/img/prototype/list.png" class="prototype-img">
                                <span class="text-center" style="display:list-item;">{{this.$lang.messages.list_view}}</span>
                            </li>
                          </ul>                          
                      </div>
                   </tab-content>
                   <tab-content :title="this.$lang.messages.select_services">
                    <div class="bg-danger warning" v-if="warn">Please add service and App Logo</div>
                    <h4>{{this.$lang.messages.select_services}}</h4>
                    <hr>
                     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="emulator" :class="{'grid-view':prototype=='grid','list-view':prototype=='list'}">
                                <div class="draggable-wrap" :style="'background-color:rgba('+colors.rgba.r+','+colors.rgba.g+','+colors.rgba.b+','+colors.rgba.a+')'">
                                    <div class="blank-wrap">                                    
                                        <div class="blank-item" v-for="i in viewCount"><i class="fa fa-plus"></i> Drop Here</div>
                                    </div>
                                    <div class="logo-area-blank" v-show="!logo">Logo</div>                  
                                    <div class="logo-area text-center" v-show="logo"><img :src="logo" height=32></div>
                                    <draggable class="warp-dest" v-model="takenServices" :options="{group:'services'}" @start="drag=true" @end="onDestDrapStop" @add="onAddedService">
                                      <div class="dest-item" :style="'background-color:rgba('+colors.rgba.r+','+colors.rgba.g+','+colors.rgba.b+','+colors.rgba.a+')'" v-for="(element,index) in takenServices" @click="editDestItem(index)"><img :src="element.logo"></img><span>{{element.title}}</span></div>
                                    </draggable>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <draggable class="wrap-source" v-model="provideServices" :options="{group:'services'}" @start="drag=true" @end="drag=false">
                                <div class="src-item" v-for="element in provideServices"><img :src="element.logo"></img><span>{{element.title}}</span></div>
                            </draggable>
                            <div class="row">
                                <button type="button" class="btn btn-secondary btn-lg col-md-6" v-on:click="viewCount+=1">{{this.$lang.messages.increase_view}}</button>
                                <button type="button" class="btn btn-secondary btn-lg col-md-6" :class="{'disabled':viewCount==takenServices.length}"  v-on:click="descreaseCount">{{this.$lang.messages.decrease_view}}</button>
                                <div class="col-md-12">
                                    <div class="row">
                                        <button type="button" class="btn btn-secondary btn-lg btn-block" v-on:click="showPicker = !showPicker">{{this.$lang.messages.change_back}}</button>
                                        <div class="picker-area text-center" style="margin:0 auto; margin-top:5px; margin-bottom: 5px" v-show="showPicker">
                                            <chrome-picker v-model="colors" />
                                        </div>
                                    </div>
                                </div>
                                <div class="Image-input__input-wrapper">
                                    {{this.$lang.messages.change_logo}}
                                    <input v-on:change="previewThumbnail" class="Image-input__input" name="thumbnail" type="file">
                                </div>
                            </div>
                        </div>
                     </div>
                   </tab-content>                      
                </form-wizard>
            </div>        
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { Chrome } from 'vue-color'
import Dropzone from 'vue2-dropzone';
export default {
    name: 'app_crud',
    components: {
        'chrome-picker': Chrome,
        Dropzone
    },
    data: () => ({
        headers: {
          'X-CSRF-TOKEN': Laravel.csrfToken,
          'content-type': 'multipart/form-data'
        },
        headerwith: {
            'X-CSRF-TOKEN': Laravel.csrfToken,
        },
        app_name: '',
        fcm_key:'',
        bundle_id: '',
        prototype: '',
        viewCount: 4,
        logo:'',
        modalErrors:{
            link: {
                valid: true,
                error:''
            },
            name: {
                valid: true,
                error: ''
            }
        },
        logoFile:null,
        warn:false,
        warnLayout: false,
        showPicker:false,
        provideServices: [
        ],
        takenServices: [
        ],
        feed: {
            url:'',
            title: ''
        },
        modal:{
            title:'',
            visible:false,
            text:'',
            newIndex:0,
            oldIndex:1,
            link:'',
            team_name:''
        },
        colors: {
          hex: '#FFFFFF',
          hsl: {
            h: 150,
            s: 0.5,
            l: 0.2,
            a: 1
          },
          hsv: {
            h: 150,
            s: 0.66,
            v: 0.30,
            a: 1
          },
          rgba: {
            r: 255,
            g: 255,
            b: 255,
            a: 1
          },
          a: 1
        }
    }),
    watch: {
        logo: function(val){
            this.$Progress.finish();
        }
    },
    methods: {
        goToStep2: function() {
            var result = this.$validator.validateAll();
            return result;
        },
        goToStep3: function() {
            if(this.prototype){
                return true;
            }
            else
                this.warnLayout = true;
            return false;
        },
        onComplete: function() {
            if(!this.takenServices.length || !this.logo)
                this.warn = true;
            else{
                this.$Progress.start();
                let data = new FormData();
                if(this.$route.params.id){
                    data.append('id',this.$route.params.id);
                }
                data.append('title',this.app_name);
                data.append('fcm_key', this.fcm_key);
                data.append('bundle_id',this.bundle_id);
                data.append('layout',this.prototype);
                data.append('logo',this.logoFile);
                data.append('background',this.colors.rgba.r+','+this.colors.rgba.g+','+this.colors.rgba.b+','+this.colors.rgba.a);
                data.append('services',JSON.stringify(this.takenServices));
                let v = this;
                axios.post(
                  base_url+'/app/store',
                  data,
                  this.headers
                ).then((resp) => {
                    this.$Progress.finish();
                  this.$swal({title: "Good job!",
                    text: "Your request has done successfully!",
                    type: "success",
                    confirmButtonColor: "#007AFF"}).then(function(){
                        v.$router.replace('/apps');
                    });                  
                }).catch((err) => {
                    this.$Progress.finish();
                  console.log(err);
                  vm.$swal({
                  title: "Failed!",
                  text: "Your reuest have been failed!",
                  type: "warning",
                  confirmButtonColor: "#007AFF"
              });
                });
            }
            return true;
        },
        onDestDrapStop: function(e) {
            this.drag = false;
            console.log(e);
        },
        onAddedService: function(evt) {
            this.modal.title = this.takenServices[evt.newIndex].title;
            this.feed.title = this.takenServices[evt.newIndex].title;
            this.modal.newIndex = evt.newIndex;
            this.modal.oldIndex = evt.oldIndex;
            this.modal.visible = !this.modal.visible;
        },
        descreaseCount: function() {
            if(this.viewCount>this.takenServices.length && this.viewCount>1)
                this.viewCount -= 1;
            console.log(this.colors);
        },
        MODAL_OK_EVENT(){
            // you can set modal show or hide with the variable 'this.modal.visible' manually 
            // this.modal.visible = false;
            if(!this.modal.link.length){
                this.modalErrors.link.valid = false;
                this.modalErrors.link.error = this.$lang.messages.valid1;
            }else{
                let res = this.modal.link.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
                if(!res){
                    this.modalErrors.link.valid = false;
                    this.modalErrors.link.error = this.$lang.messages.valid2;
                }else{
                    this.modalErrors.link.valid = true;
                    this.modalErrors.link.error = '';
                }
            }
            if(!this.modal.team_name.length){
                this.modalErrors.name.valid = false;
                this.modalErrors.name.error = this.$lang.messages.valid1;
            }else{
                this.modalErrors.name.valid = true;
                this.modalErrors.name.error = '';
            }
            if(this.modalErrors.name.valid && this.modalErrors.link.valid){
                if(this.modal.oldIndex){
                    this.takenServices[this.modal.newIndex].link = this.modal.link;
                    this.takenServices[this.modal.newIndex].team_name = this.modal.team_name;
                    if(this.feed.url){
                        this.takenServices[this.modal.newIndex].logo = this.feed.url;
                    }
                    this.takenServices[this.modal.newIndex].title = this.feed.title;
                } else{
                    this.takenServices[this.modal.newIndex].link = this.modal.link;
                    this.takenServices[this.modal.newIndex].team_name = this.modal.team_name;
                    if(this.feed.url){
                        console.log(this.feed.url);
                        this.takenServices[this.modal.newIndex].logo = this.feed.url;
                    }
                    this.takenServices[this.modal.newIndex].title = this.feed.title;
                }
                this.modal.visible = false;
                this.modal.link = '';
                this.modal.team_name = '';
                this.feed.title = '';
                this.$refs.feedLogo.removeAllFiles();
            }
            console.log(this.takenServices);
        },
        MODAL_CANCEL_EVENT(){
            if(this.modal.oldIndex){
                this.provideServices.splice(this.modal.oldIndex, 0, this.takenServices[this.modal.newIndex]);
                this.takenServices.splice(this.modal.newIndex,1);
            } else{

            }
        },
        previewThumbnail: function(event) {
            var input = event.target;

            if (input.files && input.files[0]) {
                
                this.$Progress.start();
                var reader = new FileReader();
                this.logoFile = input.files[0];
                var vm = this;

                reader.onload = function(e) {
                    vm.logo = e.target.result;                    
                }

                reader.readAsDataURL(input.files[0]);
            }
        },
        showSuccess(file) {
            let json = JSON.parse(file.xhr.response);
            this.feed.url = json.url;
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
      editDestItem: function(e) {
        this.modal.title = this.takenServices[e].title;
        this.feed.title = this.takenServices[e].title;
        this.modal.link = this.takenServices[e].link;
        this.modal.team_name = this.takenServices[e].team_name;
        this.modal.newIndex = e;
        this.modal.oldIndex = '';
        this.modal.visible = !this.modal.visible;
      }
    },
    mounted: function() {    
        var v = this; 
        this.$Progress.start();
        if(this.$route.params.id){
            axios.post(
                base_url+'/app/get_app_infos',{'id':this.$route.params.id},this.headers
            ).then((resp) => {
              v.app_name = resp.data.app.title;
              v.bundle_id = resp.data.app.bundle_id;
              v.prototype = resp.data.app.layout;
              v.fcm_key = resp.data.app.fcm_key;
              v.logo = resp.data.app.logo;
              let rgba = resp.data.app.background.split(',');
              v.colors.rgba.r = rgba[0];
              v.colors.rgba.g = rgba[1];
              v.colors.rgba.b = rgba[2];
              v.colors.rgba.a = rgba[3];
              for(var i in resp.data.provideFeeds){
                v.provideServices.push(
                    {
                        id: resp.data.provideFeeds[i].id,
                        logo: resp.data.provideFeeds[i].logo,
                        title: resp.data.provideFeeds[i].title,
                        default_logo: resp.data.provideFeeds[i].logo,
                        default_title: resp.data.provideFeeds[i].title
                    }
                );
                }
              for(var i in resp.data.feedItems){
                v.takenServices.push(
                    {
                        id: resp.data.feedItems[i].feed_id,
                        logo: resp.data.feedItems[i].customed_logo?resp.data.feedItems[i].customed_logo:resp.data.feedItems[i].default_logo,
                        title: resp.data.feedItems[i].customed_title?resp.data.feedItems[i].customed_title:resp.data.feedItems[i].default_title,
                        link: resp.data.feedItems[i].link,
                        team_name: resp.data.feedItems[i].team_name,
                        default_logo: resp.data.feedItems[i].default_logo,
                        default_title: resp.data.feedItems[i].default_title,
                        item_id: resp.data.feedItems[i].id
                    }
                );
              }
              v.viewCount = v.viewCount<v.takenServices.length?v.takenServices.length+1: v.viewCount;
              this.$Progress.finish()
            }).catch((err) => {
              console.log(err);
            });
        }else{
            axios.post(
              base_url+'/feed/get_source',this.headers
            ).then((resp) => {
            console.log(resp.data);          
              for(var i in resp.data.feeds){
                v.provideServices.push(
                    {
                        id: resp.data.feeds[i].id,
                        logo: resp.data.feeds[i].logo,
                        title: resp.data.feeds[i].title,
                        default_logo: resp.data.feeds[i].logo,
                        default_title: resp.data.feeds[i].title
                    }
                );
            }
            this.$Progress.finish()
            }).catch((err) => {
              console.log(err);
              this.$Progress.finish()
            });
        }
    }
}
</script>

<style>

</style>