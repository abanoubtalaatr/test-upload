<template>
  <div>
    <b-modal id="modal-edit-reply-request-offer-quantity" :title="$t('admin.edit_reply_request_offer_quantity')">
      <div class="custom-file-upload">
        <input type="file" ref="editReply" @change="handleImage()">
        <img :src="invoice? invoice:'~/assets/website/imgs/home/arrow-w.svg'" id="editReplyRequestOfferRequestImage" class="w-25 h-25" alt="">
        <span>{{ $t('admin.invoice') }}</span>
      </div>

      <textarea :class="$i18n.locale == 'en' ? 'level-right' : 'level-left'" class="form-control login-input" rows="5" v-model="replyRequestOfferQuantity.offer_price"
                :placeholder="$t('admin.offer_price')">{{replyRequestOfferQuantity.offer_price}}</textarea>
      <div class="text-center">
        <button @click="editReplyRequestOfferQuantity()" class="button btn-gredient big">{{ $t('admin.send') }}<img
          src="~/assets/website/imgs/home/arrow-w.svg" alt=""></button>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ['invoice', 'offer_price', 'id_reply'],
  data() {
    return {
      replyRequestOfferQuantity: {
        reply_request_offer_quantity_id: 0,
        offer_price: '',
        invoice: ''
      },
    }
  },
  methods: {
    async editReplyRequestOfferQuantity() {
      let formData = new FormData();
      formData.append('invoice', this.replyRequestOfferQuantity.invoice);
      formData.append('reply_request_offer_quantity_id', this.id_reply);
      formData.append('offer_price',this.replyRequestOfferQuantity.offer_price);

      this.$nuxt.$loading.start();
      await this.$axios.$put('store/request-offer-quantity/reply/update', formData).then(response => {
        this.$toast.success(this.$t('admin.added_successfully'));
        this.replyRequestOfferQuantity = {};
        document.getElementById('editReplyRequestOfferRequestImage').src = "~/assets/website/imgs/account/upload.svg";
        document.getElementById('editReplyRequestOfferRequestImage').click();
      }).catch(error => {
        console.log(error)
      });
      this.$nuxt.$loading.finish();
    },
    handleImage(e) {
      let file = this.$refs.editReply.files[0];
      this.replyRequestOfferQuantity.invoice = file;
      console.log(this.replyRequestOfferQuantity.invoice)
      document.getElementById('editReplyRequestOfferRequestImage').src = URL.createObjectURL(file);
    },
    resetForm() {
      this.replyRequestOfferQuantity = {};
      document.getElementById('editReplyRequestOfferRequestImage').src = "~/assets/website/imgs/account/upload.svg";
    }
  },
}
</script>

<style>
.modal-footer, .modal-header {
  display: none !important;
}
</style>
