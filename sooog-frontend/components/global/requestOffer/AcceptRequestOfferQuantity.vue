<template>
  <div class="div modal show" id="modal-accept-reply-request-offer">
    <div class="modal-dialog">
      <div class="modal-content">
        <button class="close" type="button" @click="resetForm()" data-dismiss="modal" id="closeAcceptReplyRequestOffer"
                aria-label="Close"><span>&times;</span></button>
        <div class="modal-body">
          <h3>{{ $t('front.accept_reply_request_offer_quantity') }}</h3>

          <textarea class="form-control login-input" required rows="5" v-model="replyRequestOfferQuantity.notes"
                    :placeholder="$t('front.notes')"></textarea>
          <div class="text-center">
            <button @click="acceptReplyRequestOfferQuantity()" class="button btn-gredient big">
              <img
                  src="~/assets/website/imgs/home/arrow-w.svg" alt="">
              {{ $t('front.send') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['myId', 'index'],
  data() {
    return {
      replyRequestOfferQuantity: {
        notes: '',
        reply_request_offer_quantity_id: 0,
      },
    }
  },
  methods: {
    async acceptReplyRequestOfferQuantity() {
      this.replyRequestOfferQuantity.reply_request_offer_quantity_id = this.myId;
      this.$nuxt.$loading.start();
      if (!this.replyRequestOfferQuantity.notes == '') {
        await this.$axios.patch('request-offer-quantity/accept', this.replyRequestOfferQuantity)
            .then(response => {
              this.$toast.success(this.$t('front.added_successfully'));
              this.replyRequestOfferQuantity = {};
              this.$emit('accepted-reply', this.index);
              document.getElementById('closeAcceptReplyRequestOffer').click();
            }).catch(error => {
            })
        this.$nuxt.$loading.finish();
      }
    },
    resetForm() {
      this.replyRequestOfferQuantity = {};
    }

  },
}
</script>

<style scoped>

</style>