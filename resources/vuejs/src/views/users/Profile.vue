<template>
  <div class="card">
    <div class="card-header"><strong>{{this.$lang.messages.my_profile}}</strong></div>
    <div class="card-block">
      <form action="/feed/store" method="post" class="form-horizontal" ref="feedsrcForm">
        <div class="form-group row">
          <label for="feedName" class="col-sm-3 form-control-label">{{this.$lang.messages.name}}</label>
          <div class="col-sm-6">
            <input type="text" id="feedName" ref="feedName"
                   :placeholder="this.$lang.messages.name"
                   v-model="feed.title"
                   class="form-control input-sm">
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
  import axios from 'axios'

  export default {
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
        let form = this.$refs.feedsrcForm;
        axios.post(
          form.action,
          this.feed,
          this.headers
        ).then((resp) => {
          console.log(resp);
          this.$router.replace('/feedsrcs');
        }).catch((err) => {
          console.log(err);
        });
      },

      onResetForm(e) {
        this.$refs.feedLogo.removeAllFiles();
        this.$refs.feedName.value = '';
      },
      goToBack: function() {
        this.$router.replace('/feedsrcs');
      }
    }
  }
</script>