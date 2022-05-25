<template>
  <b-modal id="modal-preview-image" :title="$t('admin.image')">
    <div class="custom-file-upload">
      <img v-if="typeOFImages.includes(type)" :src="file"  alt="">
      <div v-else>
        <a :href="file" target="_blank">Click here to show your invoice</a>
      </div>

    </div>
  </b-modal>
</template>

<script>
export default {
  props: ['file', 'type'],
  data(){
    return {
      typeOFImages : ['png', 'jpg', 'jpeg'],
    }
  },
}
</script>

<style scoped>

</style>
