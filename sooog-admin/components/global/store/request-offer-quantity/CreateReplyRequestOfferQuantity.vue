<template>
  <div>
    <b-modal id="modal-1" :title="$t('admin.create_reply_request_offer_quantity')">
      <div class="custom-file-upload">
        <input type="file" ref="file" @change="handleImage()">
        <img v-show="showUploadImage" src="~/assets/website/imgs/account/upload.svg" class="w-25 h-25" alt="">
        <img v-show="!showUploadImage" src="" id="createOfferRequestImage" class="w-25 h-25" alt="">
        <span>{{ $t('admin.invoice') }}</span>
      </div>

      <textarea class="form-control login-input" rows="5" v-model="replyRequestOfferQuantity.offer_price"
                :placeholder="$t('admin.offer_price')"></textarea>
      <div class="text-center">
        <button @click="createRequestOfferQuantity()" class="button btn-gredient big">{{ $t('admin.send') }}<img
          src="~/assets/website/imgs/home/arrow-w.svg" alt=""></button>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ['request_offer_id'],
  data() {
    return {
      replyRequestOfferQuantity: {
        request_offer_quantity_id: 0,
        offer_price: '',
      },
      showUploadImage: true
    }
  },
  methods: {
    async createRequestOfferQuantity() {
      let formData = new FormData();
      formData.append('invoice', this.replyRequestOfferQuantity.invoice);
      formData.append('request_offer_quantity_id', this.request_offer_id);
      formData.append('offer_price', this.replyRequestOfferQuantity.offer_price);

      this.$nuxt.$loading.start();
      await this.$axios.post('store/request-offer-quantity/reply', formData).then(response => {
        this.$toast.success(this.$t('admin.added_successfully'));
        this.replyRequestOfferQuantity = {};
        this.showUploadImage = true;
      }).catch(error => {
        this.replyRequestOfferQuantity = {}
      });
      this.$nuxt.$loading.finish();
    },
    handleImage(e) {
      let file = this.$refs.file.files[0];
      this.showUploadImage = false;
      this.replyRequestOfferQuantity.invoice = file;
      document.getElementById('createOfferRequestImage').src = URL.createObjectURL(file);
    },
    resetForm() {
      this.replyRequestOfferQuantity = {};
      this.showUploadImage = true;
    }
  },
}
</script>

<style>
.modal-footer, .modal-header {
  display: none !important;
}
</style>
