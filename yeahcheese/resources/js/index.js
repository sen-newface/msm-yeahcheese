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
            title_error_msg : '',
            error_release_date_msg : '',
            error_end_date_msg : '',
            error_flag : false,
        },
        watch:{
            title: function (newTitle) {
                if (newTitle.length > 255) {
                    this.title_error_msg = "255文字以下にしてください"
                    this.error_flag = false
                } else {
                    this.title_error_msg = ""
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
                    this.error_release_date_msg = ""
                    this.error_flag = true
                }
            },
            end_date: function (newDate) {
                if ( Date.parse(newDate) < Date.parse(this.release_date) ) {
                    this.error_end_date_msg = "公開終了日は公開開始日以降にしてください"
                    this.error_flag = false
                } else {
                    this.error_end_date_msg = ""
                    this.error_flag = true
                }
            }
        },
        created: function () {
            api.fetchEvent(this.event_id).then(
                ev => {
                const data = ev.data.data;
                this.title = data.title;
                this.release_date = data.release_date;
                this.end_date = data.end_date;
                },
                errors => console.error(errors)
            );
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
        }
    }
);
