import axios from 'axios';
import api from './api';

const url = 'https://yeahcheese.localapp.jp/api/';

export default {
  fetchEvent(id) {
    return axios.get(url + 'events/fetch\/' + id);
  }
}

