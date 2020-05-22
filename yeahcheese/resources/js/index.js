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
                api.updateEvent(request).then(
                    response => {
                        this.message = "イベント情報が更新されました";
                    },
                )
            }
        }
    }
);
