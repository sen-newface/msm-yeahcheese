<template>
  <div>
    <form @submit.prevent="postPicture">
      <input
        type="file"
        name="file"
        @change="selectedFile"
      >
      <button type="submit">
        送信
      </button>
    </form>

    <p v-if="errorMessage">
      エラー表示 : {{ errorMessage }}
    </p>

    <div class="container-fluid">
      <div class="row">
        <div
          v-for="p in reversePictures"
          class="col-4 my-2"
        >
          <picture-item-component
            :id="p.id"
            :received-path="p.path"
            :remove-error="false"
            @remove-picture="removePicture($event)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';
import Vue from 'vue';
import PictureItemComponent from './PictureItemComponent.vue';
Vue.component('PictureItemComponent', PictureItemComponent);

export default {
  name: "PictureComponent",
  component: {
    PictureItemComponent,
  },
  props: {
    eventId: {
      type: Number,
      require: true,
      'default': -1,
    },
    errorMessages: {
      type: Object,
      require: false,
      'default': () => ({
        getError: "画像の取得に失敗しました。",
        removeError: "削除に失敗しました。",
        storeError: "画像の送信に失敗しました。",
      }),
    },
  },
  data: function() {
    return {
      pictures: [],
      uploadImage: null,
      errorMessage: "",
    };
  },
  computed: {
    // 写真を新しい順に表示
    reversePictures() {
      return this.pictures.slice().reverse();
    }
  },
  created: function () {
    if (this.eventId === -1) {
      return;
    }

    api.getPicturesList(this.eventId).then(
      picturesResponse => {
        this.errorMessage = "";
        this.pictures = picturesResponse.data.data;
      },
      // TODO: API利用に失敗した際の処理を記述する リクエストの再送信など
      errors => {
        this.errorMessage = this.errorMessages.getError;
        console.error(errors);
      }
    );
  },
  methods: {
    removePicture (id) {
      let index = this.pictures.findIndex((p) => p.id === id);

      api.removePicture(id).then(
        () => {
          this.errorMessage = "";
          this.pictures.splice(index, 1);
        },
        // TODO: API利用に失敗した際の処理を記述する
        errors => {
          this.errorMessage = this.errorMessages.removeError;
          console.error(errors);
        },
      );
    },
    selectedFile (e) {
      // 選択された File の情報を保存
      let files = e.target.files;
      this.uploadImage = files[0];
    },
    postPicture () {
      // FormData を利用して File を POST する
      let data = new FormData();

      data.append('event_id', this.eventId);
      data.append('file', this.uploadImage);

      api.postPicture(data).then(
        picturePostResponse => {
          const responseDataProperties = Object.getOwnPropertyNames(picturePostResponse.data);
          const responseData = picturePostResponse.data;

          if (responseDataProperties.includes("messages")) {
            this.errorMessage = responseData.messages.file.toString();
            return;
          }

          this.errorMessage = "";
          this.pictures.push(responseData.data);
        },
        errors => {
          /*
           * TODO: 返ってきたステータスコードで表示を切りかえたい
           * ここのエラー表示についてのメモ
           * 想定しているエラー番号は413(nginxの1MB制限超過)と500
           * 状態としてはどちらもサーバーに画像を送信できなかった、なので
           * エラーメッセージは同じものを出している
           * あんまりよくない状態なのでTODOとしてコメントを残している
           */
          this.errorMessage = this.errorMessages.storeError;
          console.error(errors);
        },
      )
    }
  },
}
</script>
