<template>
  <div class="row m-2">
    <div class="col-12 my-2">
      <h2>イベント情報を編集</h2>
      <p class="text-secondary">
        255文字以下のタイトルを設定することができます。イベントの公開開始日は公開終了日より先の日付を指定することはできません。
      </p>

      <div
        v-if="postStatusMessage"
        class="alert my-2"
        :class="{'alert-success': isUpdateSuccess, 'alert-danger': !isUpdateSuccess}"
      >
        {{ postStatusMessage }}
      </div>

      <div
        v-if="errorMessages.length != 0"
        class="alert my-2 alert-danger"
      >
        <p>不正な値が送信されました。</p>
        <ul>
          <li
            v-for="message in errorMessages"
            :key="message"
          >
            {{ message }}
          </li>
        </ul>
      </div>

      <div class="col-sm-6 px-0">
        <div class="form-group">
          <label>イベントタイトル</label>
          <input
            v-model="title"
            type="text"
            class="form-control"
          >

          <div
            v-if="!validateStatus.title"
            class="alert alert-danger my-2"
            role="alert"
          >
            {{ validateErrorMessages.title }}
          </div>
        </div>

        <div class="form-group">
          <label>公開開始日</label>
          <input
            v-model="release_date"
            type="date"
            class="form-control"
          >

          <div
            v-if="!validateStatus.releaseDate"
            class="alert alert-danger my-2"
            role="alert"
          >
            {{ validateErrorMessages.releaseDate }}
          </div>
        </div>

        <div class="form-group">
          <label>公開終了日</label>
          <input
            v-model="end_date"
            type="date"
            class="form-control"
          >

          <div
            v-if="!validateStatus.endDate"
            class="alert alert-danger my-2"
            role="alert"
          >
            {{ validateErrorMessages.endDate }}
          </div>
        </div>
      </div>

      <button
        type="submit"
        class="col-sm-2 btn btn-primary"
        @click="updateEvent"
      >
        更新
      </button>
    </div>
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
      default: null,
    },
    validateErrorMessages: {
      type: Object,
      require: false,
      default: () => ({
        title: "1文字以上255文字以下のタイトルを入力してください。",
        releaseDate: "公開開始日は公開終了日以前にしてください。",
        endDate: "公開終了日は公開開始日以降にしてください。",
      }),
    },
    postStatusMessages: {
      type: Object,
      require: false,
      default: () => ({
        success: "イベント情報が更新されました",
        failed: "更新できませんでした",
      }),
    },
  },
  data: function () {
    return {
      title : '',
      release_date : '',
      end_date : '',
      errorMessages: [],
      postStatusMessage : '',
      validateStatus: {
        title: true,
        releaseDate: true,
        endDate: true,
      }
    }
  },
  computed: {
    isUpdateSuccess () {
      return this.postStatusMessage === this.postStatusMessages.success;
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
      this.validateStatus.endDate = true;
    },
    end_date: function (newDate) {
      if ( Date.parse(newDate) < Date.parse(this.release_date) ) {
        this.validateStatus.endDate = false;
        return;
      }

      this.validateStatus.endDate = true;
      this.validateStatus.releaseDate = true;
    },
  },
  created: function () {
    if (!this.eventId) {
      return;
    }

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
          updateResponse => {
            const responseDataProperties = Object.getOwnPropertyNames(updateResponse.data);
            const responseData = updateResponse.data;
            
            this.errorMessages = [];

            if (responseDataProperties.includes("messages")) {
              const responseErrors = responseData.messages;

              for (var error in responseErrors) {
                console.error(responseErrors[error].toString());
                this.errorMessages.push(responseErrors[error].toString());
              }

              return;
            }

            this.postStatusMessage = this.postStatusMessages.success;
          },
        )
      } else {
        this.postStatusMessage = this.postStatusMessages.failed;
      }
    }
  },
}
</script>
