import Vue from 'vue';
import api from './api';
import Axios from 'axios';

new Vue(
  {
    el: '#update',
    data: {
      event_id: JSON.parse(document.currentScript.dataset.eventId),
      title : '',
      release_date : '',
      end_date : '',
      message : '',
      error_title_msg : '',
      error_release_date_msg : '',
      error_end_date_msg : '',
      error_flag : false,
    },
    created: function () {
      api.fetchEvent(this.event_id).then(
        eventResponse => {
          const data = eventResponse.data.data;
          this.title = data.title;
          this.release_date = data.release_date;
          this.end_date = data.end_date;
        },
        // TODO: API利用に失敗した際の処理を記述する リクエストの再送信など
        errors => console.error(errors)
      );
    },
    watch: {
      title: function (newTitle) {
        if (newTitle.length > 255 || newTitle.length < 1) {
          this.error_title_msg = "255文字以下のタイトルを入力してください"
          this.error_flag = false
        } else {
          this.error_title_msg = ""
          this.error_flag = true
        }
      },
      release_date: function (newDate) {
        /* 開始日を今日以降にするかどうか?
        const today = new Date()
        const YYYY = today.getFullYear()
        const MMint = today.getMonth()+1;
        const MMstr = ('0' + MMint).slice(-2)
        const DD = ('0' + today.getDate()).slice(-2)
        const todaystr = YYYY + '-' + MMstr + '-' + DD
        */
        if ( Date.parse(newDate) > Date.parse(this.end_date) ) {
          this.error_release_date_msg = "公開開始日は公開終了日以前にしてください"
          this.error_flag = false
        } else {
          this.error_release_date_msg = ''
          this.error_end_date_msg = ''
          this.error_flag = true
        }
      },
      end_date: function (newDate) {
        if ( Date.parse(newDate) < Date.parse(this.release_date) ) {
          this.error_end_date_msg = "公開終了日は公開開始日以降にしてください"
          this.error_flag = false
        } else {
          this.error_end_date_msg = ''
          this.error_release_date_msg = ''
          this.error_flag = true
        }
      },
    },
    methods: {
      updateEvent: function() { // 更新ボタンを押したときに呼ばれる
        const request = {
          id : this.event_id,
          title : this.title,
          release_date : this.release_date,
          end_date : this.end_date
        }
        if (this.error_flag) {
          api.updateEvent(request).then(
            response => {
              this.message = "イベント情報が更新されました";
              console.log(new Date());
            },
          )
        } else {
          this.message = "更新できませんでした"
        }
      }
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
      getError: false,
      removeError: false,
    },
    created: function () {
      api.getPicturesList(this.event_id).then(
        picturesResponse => {
          this.getError = false;
          this.pictures = picturesResponse.data.data;
        },
        // TODO: API利用に失敗した際の処理を記述する リクエストの再送信など
        errors => {
          this.getError = true;
          console.error(errors);
        }
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
          // TODO: API利用に失敗した際の処理を記述する
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
          <p v-if="this.getError">画像の取得に失敗しました。時間を置いてやりなおしてください。</p>\
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
