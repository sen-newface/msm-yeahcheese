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
    <p v-if="this.getError">
      画像の取得に失敗しました。時間を置いてやりなおしてください。
    </p>
    <p v-if="this.removeError">
      削除に失敗しました。時間を置いてやりなおしてください。
    </p>
    <p v-if="this.storeError">
      画像の保存に失敗しました。時間を置いてやりなおしてください。
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
    eventId: Number,
  },
  data: function() {
    return {
      // eventId: JSON.parse(document.currentScript.dataset.eventId),
      pictures: [],
      uploadImage: null,
      getError: false,
      removeError: false,
      storeError: false,
    };
  },
  computed: {
    // 写真を新しい順に表示
    reversePictures() {
      return this.pictures.slice().reverse();
    }
  },
  created: function () {
    api.getPicturesList(this.eventId).then(
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
          this.pictures.push(picturePostResponse.data.data);
        },
        errors => {
          this.storeError = true;
          console.error(errors);
        },
      )
    }
  },
}
</script>