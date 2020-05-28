<template>
  <div>
    <p>イベントタイトル</p>
    <input v-model="title">
    <p v-if="!validateStatus.title">
      {{ validateErrorMessages.title }}
    </p>

    <p>公開開始日</p>
    <input type="date" v-model="release_date">
    <p v-if="!validateStatus.releaseDate">
      {{ validateErrorMessages.releaseDate }}
    </p>

    <p>公開終了日</p>
    <input type="date" v-model="end_date">
    <p v-if="!validateStatus.endDate">
      {{ validateErrorMessages.endDate }}
    </p>

    <button type="submit" @click="updateEvent">更新</button>

    <p>{{ postStatusMessage }}</p>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'EventEditorComponent',
  props: {
    eventId: {
      type: Number,
      require: true,
      'default': -1,
    },
    validateErrorMessages: {
      type: Object,
      require: false,
      'default': () => ({
        title: "1文字以上255文字以下のタイトルを入力してください。",
        releaseDate: "公開開始日は公開終了日以前にしてください。",
        endDate: "公開終了日は公開開始日以降にしてください。",
      }),
    },
  },
  data: function () {
    return {
      title : '',
      release_date : '',
      end_date : '',
      postStatusMessage : '',
      validateStatus: {
        title: false,
        releaseDate: false,
        endDate: false,
      }
    }
  },
  watch: {
    title: function (newTitle) {
      if (1 <= newTitle.length && newTitle.length <= 255) {
        this.validateStatus.title = true;
        return;
      }
      this.validateStatus.title = false;
    },
    release_date: function (newDate) {
      if ( Date.parse(newDate) > Date.parse(this.end_date) ) {
        this.validateStatus.releaseDate = false;
        return;
      }

      this.validateStatus.releaseDate = true;
    },
    end_date: function (newDate) {
      if ( Date.parse(newDate) < Date.parse(this.release_date) ) {
        this.validateStatus.endDate = false;
        return;
      }

      this.validateStatus.endDate = true;
    },
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
  methods: {
    updateEvent: function() { 
      const request = {
        id : this.eventId,
        title : this.title,
        release_date : this.release_date,
        end_date : this.end_date
      }
      if (Object.values(this.validateStatus).every(v => v == true)) {
        api.updateEvent(request).then(
          // TODO: この部分、Laravelから更新後の値が返ってきてるし比較してから処理抜けたほうがいいかも？
          () => {
            this.postStatusMessage = "イベント情報が更新されました";
          },
        )
      } else {
        this.postStatusMessage = "更新できませんでした"
      }
    }
  },
}
</script>
