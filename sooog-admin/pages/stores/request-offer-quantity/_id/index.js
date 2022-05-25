import CreateReplyRequestOfferQuantity
  from "../../../../components/global/store/request-offer-quantity/CreateReplyRequestOfferQuantity";
import PreviewImage from "../../../../components/global/PreviewImage";

export default {
  layout: 'store',
  components: {
    CreateReplyRequestOfferQuantity,
    PreviewImage,
  },
  async asyncData(context) {
    const response = await Promise.all([
      context.$axios.$get(`store/request-offer-quantity/` + context.params.id).catch(() => {
      }),
    ])
    return {
      requestOfferQuantity: response[0],
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.details_request_offer_quantity'),
      requestOfferQuantity: {},
      idRequestOfferQuantity : 0,
      typeOfFile : '',
      fileSrc : '',
    }
  },
  methods: {
    setIdRequestOfferQuantity(id){
      this.idRequestOfferQuantity = id;
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
  },
  watch: {
    // '$route.query': '$fetch'
    '$route.query': function (val, oldVal) {
      debugger
      if (val.search) {
        this.loadAsyncData()
      }
    },
    deep: true
  }
}
