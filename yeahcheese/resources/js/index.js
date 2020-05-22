import Vue from 'vue';
import api from './api';

new Vue(
    {
        el: '#update',
        data: {
            event_id: JSON.parse(document.currentScript.dataset.eventId),
            title : '',
            release_date : '',
            end_date : '',
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
    }
);

Vue.component('picture-item',
    {
        props: [
            'id',
            'receivedPath',
        ],
        data(){
            return {
              path: 'https://yeahcheese.localapp.jp/storage/app/' + this.receivedPath
            };
        },
        template: '\
                <div>\
                    <img v-bind:src="this.path" width="100%" class="img">\
                    <a  v-on:click="$emit(\'remove-picture\', id)"\
                        class="btn btn-primary">削除する</a>\
                </div>\
            ',
    }
);

new Vue(
    {
        el: '#picture-list',
        data: {
            event_id: JSON.parse(document.currentScript.dataset.eventId),
            pictures: [],
            uploadImage: null,
        },
        created: function () {
            api.getPicturesList(this.event_id).then(
                picturesResponse => {
                    this.pictures = picturesResponse.data.data;
                },
                // TODO: API利用に失敗した際の処理を記述する
                errors => console.error(errors)
            );
        },
        methods: {
            removePicture (id) {
                // TODO: 画像を削除する処理を書く
                api.removePicture(id).then(
                    pictureRemoveResponse => {
                        // TODO: 画像を表示しているコンポーネントを除去する処理を書く
                        
                    },
                    // TODO: API利用に失敗した際の処理を記述する
                );
            },
        },
    }
);
