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

    <p>{{ message }}</p>
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
      message : '',
      validateStatus: {
        title: false,
        releaseDate: false,
        endDate: false,
      }
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
        this.validateStatus.title = false;
      } else {
        this.validateStatus.title = true;
      }
    },
    release_date: function (newDate) {
      if ( Date.parse(newDate) > Date.parse(this.end_date) ) {
        this.validateStatus.releaseDate = false;
      } else {
        this.validateStatus.releaseDate = true;
      }
    },
    end_date: function (newDate) {
      if ( Date.parse(newDate) < Date.parse(this.release_date) ) {
        this.validateStatus.endDate = false;
      } else {
        this.validateStatus.endDate = true;
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
      if (Object.values(this.validateStatus).every(v => v == true)) {
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
