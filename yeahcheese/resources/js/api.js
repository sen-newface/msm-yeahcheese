import axios from 'axios';

const url = 'https://yeahcheese.localapp.jp/api/';

export default {
    fetchEvent(id) {
        return axios.get(url + 'events/fetch\/' + id);
    },

    getPicturesList(id) {
        return axios.get(url + 'pictures/list\/' + id);
    },

    postPicture(image) {
        return axios.post(url + 'pictures/store', image);
    },
}

