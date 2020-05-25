import Vue from 'vue';
import api from './api';

new Vue(
  {
    el: '#update',
    data: {
      event_id: JSON.parse(document.currentScript.dataset.eventId),
      title : '',
      release_date : '',
      end_date : '',
    },
    created: function () {
      api.fetchEvent(this.event_id).then(
        ev => {
          const data = ev.data.data;
          this.title = data.title;
          this.release_date = data.release_date;
          this.end_date = data.end_date;
        },
        errors => console.error(errors)
      );
    },
  }
);

Vue.component('picture-item',
  {
    props: {
      id: Number,
      receivedPath: String,
    },
    computed: {
      path: function () {
        return 'https://yeahcheese.localapp.jp/storage/app/' + this.receivedPath;
      },
    },
    template: '\
              <div>\
                  <img v-bind:src="this.path" width="100%" class="img">\
                  <a  v-on:click="$emit(\'remove-picture\', id)"\
                      class="btn btn-primary">削除する</a>\
              </div>\
          ',
  }
);

new Vue(
  {
    el: '#picture-list',
    data: {
      event_id: JSON.parse(document.currentScript.dataset.eventId),
      pictures: [],
      uploadImage: null,
      removeError: false,
    },
    created: function () {
      api.getPicturesList(this.event_id).then(
        picturesResponse => {
          this.pictures = picturesResponse.data.data;
        },
        // TODO: API利用に失敗した際の処理を記述する
        errors => console.error(errors)
      );
    },
    methods: {
      removePicture (id) {
        let index = this.pictures.findIndex((p) => p.id === id);
        api.removePicture(id).then(
          pictureRemoveResponse => {
            this.pictures.splice(index, 1);
            this.removeError = false;
          },
          errors => {
            this.removeError = true;
            console.error(errors);
          },
        );
      },
    },
    template: '\
        <div>\
          <input v-on:change="" type="file">\
          <p v-if="this.removeError">削除に失敗しました。時間を置いてやりなおしてください。</p>\
          <div class="container-fluid">\
              <div class="row">\
                  <div class="col-4 my-2" v-for="p in pictures">\
                      <picture-item\
                          :id = "p.id"\
                          :received-path = "p.path"\
                          :remove-error = false\
                          @remove-picture="removePicture($event)"\
                      ></picture-item>\
                  </div>\
              </div>\
          </div>\
        </div>\
    '
  }
);
