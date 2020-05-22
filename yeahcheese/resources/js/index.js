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
                    <a class="btn btn-primary" href="">削除する</a>\
                </div>\
            ',
    }
);

