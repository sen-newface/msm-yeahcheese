import axios from 'axios';
import api from './api';

const url = 'https://yeahcheese.localapp.jp/api/';

export default {
  fetchEvent(auth_key) {
    return axios.get(url + 'events/fetch\/' + auth_key);
  }
}

