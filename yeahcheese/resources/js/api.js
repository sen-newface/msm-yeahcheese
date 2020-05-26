import axios from 'axios';

const url = 'https://yeahcheese.localapp.jp/api/';

export default {
  fetchEvent(id) {
    return axios.get(url + 'events/fetch/' + id);
  },

  updateEvent(data) {
    return axios.put(url + 'events/update', data);
  },

  getPicturesList(id) {
    return axios.get(url + 'pictures/list/' + id);
  },

  postPicture(request) {
    return axios.post(url + 'pictures/store', request);
  },

  removePicture(id) {
    return axios.delete(url + 'pictures/destroy/' + id);
  },
}

