<template>
  <div class="row m-2">
    <div class="col-12 my-2">
      <h2>イベント情報を編集</h2>
      <p class="text-secondary">255文字以下のタイトルを設定することができます。イベントの公開開始日は公開終了日より先の日付を指定することはできません。</p>

      <div class="alert alert-success my-2" v-if="message === 'イベント情報が更新されました'">{{ message }}</div>
      <div class="alert alert-danger my-2" v-if="message === '更新できませんでした'">{{ message }}</div>

      <div class="col-sm-6 px-0">
      <div class="form-group">
        <label>イベントタイトル</label>
        <input type="text" class="form-control" v-model="title">
        <div class="alert alert-danger my-2" role="alert" v-if="error_title_msg">{{ error_title_msg }}</div>
      </div>

      <div class="form-group">
        <label>公開開始日</label>
        <input type="date" class="form-control"  v-model="release_date">
        <div class="alert alert-danger my-2" role="alert" v-if="error_release_date_msg">{{ error_release_date_msg }}</div>
      </div>

      <div class="form-group">
        <label>公開終了日</label>
        <input type="date" class="form-control" v-model="end_date">
        <div class="alert alert-danger my-2" role="alert" v-if="error_end_date_msg">{{ error_end_date_msg }}</div>
      </div>
      </div>

      <button type="submit" class="col-sm-2 btn btn-primary" @click="updateEvent">更新</button>
    </div>
  </div>
</template>

<script>
import api from '../api';
import Vue from 'vue';

export default {
  name: 'EventEditorComponent',
  props: {
    eventId: Number,
  },
  data: function () {
    return {
      title : '',
      release_date : '',
      end_date : '',
      message : '',
      error_title_msg : '',
      error_release_date_msg : '',
      error_end_date_msg : '',
      error_flag : false,
    }
  },
  created: function () {
    api.fetchEvent(this.eventId).then(
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
        // TODO: 1 < newTitle.length < 255でよくない？
        this.error_title_msg = "255文字以下のタイトルを入力してください"
        this.error_flag = false
      } else {
        this.error_title_msg = ""
        this.error_flag = true
      }
    },
    release_date: function (newDate) {
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
    updateEvent: function() {
      const request = {
        id : this.eventId,
        title : this.title,
        release_date : this.release_date,
        end_date : this.end_date
      }
      if (this.error_flag) {
        api.updateEvent(request).then(
          response => {
            this.message = "イベント情報が更新されました";
          },
        )
      } else {
        this.message = "更新できませんでした"
      }
    }
  },
}
</script>
