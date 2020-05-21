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
    const url = new URL(document.location);
    const id = url.pathname.split('/')[3];

    api.fetchEvent(id).then(
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
