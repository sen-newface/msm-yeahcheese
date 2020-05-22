import axios from 'axios';

const url = 'https://yeahcheese.localapp.jp/api/';

export default {
    fetchEvent(id) {
        return axios.get(url + 'events/fetch\/' + id);
    },
    updateEvent(data) {
        return axios.put(url + 'events/update', data);
    }
}

