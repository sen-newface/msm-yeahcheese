<template>
  <div class="row m-2">
    <div class="col-12">
      <h2 class="my-2">
        写真を登録
      </h2>
      <p class="text-secondary">
        データサイズが1MB以下の写真を登録することができます。
      </p>
      <form
        class="col-sm-6 px-0"
        @submit.prevent="postPicture"
      >
        <div class="input-group">
          <div class="custom-file">
            <input
              id="customFile"
              type="file"
              name="file"
              class="custom-file-input"
              @change="selectedFile"
            >
            <label
              class="custom-file-label"
              for="customFile"
              data-browse="参照"
            >
              ファイルを選択
            </label>
          </div>

          <div class="input-group-append">
            <button
              type="submit"
              class="btn btn-primary"
            >
              登録
            </button>
          </div>
        </div>
      </form>
    </div>

    <div
      v-if="errorMessage"
      class="col my-2"
    >
      <div class="alert alert-danger">
        {{ errorMessage }}
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div
          v-for="p in reversePictures"
          :key="p.id"
          class="col-sm-4 my-2"
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
