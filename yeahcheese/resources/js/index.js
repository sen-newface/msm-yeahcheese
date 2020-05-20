import Vue from 'vue';
import api from './api';

new Vue({
  el: '#update',
  data: {
    title : '',
    release_date : '',
    end_date : '',
  },
  created: function() {
    let params = (new URL(document.location)).searchParams;
    let auth_key = params.get('auth_key');

    api.fetchEvent(auth_key).then(
      ev => {
        const data = ev.data.data;
        this.title = data.title;
        this.release_date = data.release_date;
        this.end_date = data.end_date;
      },
      errors => console.error(errors)
    );
  },
});
