<template>
  <div class="row m-2">
    <div class="col-12">
      <h2 class="my-2">写真を登録</h2>
      <p class="text-secondary">データサイズが1MB以下の写真を登録することができます。</p>
      
        <form @submit.prevent="postPicture" class="col-sm-6 px-0">
          <div class="input-group">
            <div class="custom-file">
              <input
                type="file"
                name="file"
                @change="selectedFile"
                class="custom-file-input"
                id="customFile"
              >
              <label class="custom-file-label" for="customFile" data-browse="参照">ファイルを選択</label>
            </div>
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">登録</button>
            </div>
          </div>
        </form>
      
    </div>

    <div class="col my-2">
      <div class="alert alert-danger" v-if="this.getError">
        画像の取得に失敗しました。時間を置いてやりなおしてください。
      </div>
      <div class="alert alert-danger" v-if="this.removeError">
        削除に失敗しました。時間を置いてやりなおしてください。
      </div>
      <div class="alert alert-danger" v-if="this.storeError">
        画像の保存に失敗しました。時間を置いてやりなおしてください。
      </div>
    </div>


    <div class="container-fluid">
      <div class="row">
        <div
          v-for="p in reversePictures"
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
    eventId: Number,
  },
  data: function() {
    return {
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
