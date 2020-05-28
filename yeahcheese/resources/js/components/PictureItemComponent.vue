<template>
  <div class="card card-body">
    <img
      class="img"
      width="100%"
      :src="this.path"
    >
    <button
      class="btn btn-primary my-2"
      @click="$emit('remove-picture', id)"
    >削除する</button>
  </div>
</template>

<script>
export default {
  name: "PictureItemComponent",
  props: {
    id: Number,
    receivedPath: String,
  },
  computed: {
    path: function () {
      return 'https://yeahcheese.localapp.jp/storage/app/' + this.receivedPath;
    },
  },
}
</script>
