import EditReplyRequestOfferQuantity
  from "../../../../../components/global/store/request-offer-quantity/EditReplyRequestOfferQuantity";
import PreviewImage from "../../../../../components/global/PreviewImage";

export default {
  layout: 'store',
  components: {
    EditReplyRequestOfferQuantity,
    PreviewImage,
  },
  async asyncData(context) {
    const response = await Promise.all([
      context.$axios.$get(`store/request-offer-quantity/reply/` + context.params.id).catch(() => {
      }),
    ])

    return {
      reply: response[0],
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.details_request_offer_quantity'),
      reply: {},
      idReplyRequestOfferQuantity: 0,
      typeOfFile : '',
      fileSrc : '',
    }
  },
  methods: {
    setIdReplyRequestOfferQuantity(id) {
      this.idReplyRequestOfferQuantity = id;
    },
    async deliveryReplyRequestOfferQuantity(id) {
      let data = {request_offer_quantity_id: id}
      this.$nuxt.$loading.start();
      await this.$axios.patch('store/request-offer-quantity/reply/delivered', data).then(response => {
        this.$toast.success(this.$t('admin.added_successfully'));
        this.reply.can_delivery = false;
      }).catch(error => {
      });
      this.$nuxt.$loading.finish();
    },
    setPreviewFile(fileSrc) {
      this.typeOfFile = fileSrc.split('.').pop();
      this.fileSrc = fileSrc;
    }
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
