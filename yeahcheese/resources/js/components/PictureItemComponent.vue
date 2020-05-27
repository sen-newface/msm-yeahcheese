<template>
  <div>
    <img
      class="img"
      width="100%"
      :src="this.path"
    >
    <a
      class="btn btn-primary"
      @click="$emit('remove-picture', id)"
    >削除する</a>
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
