<template>
  <div>
    <p>イベントタイトル</p>
    <input v-model="title">
    <p>{{ error_title_msg }}</p>

    <p>公開開始日</p>
    <input type="date" v-model="release_date">
    <p>{{ error_release_date_msg }}</p>

    <p>公開終了日</p>
    <input type="date" v-model="end_date">
    <p>{{ error_end_date_msg }}</p>

    <button type="submit" @click="updateEvent">更新</button>

    <p>{{ message }}</p>
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
