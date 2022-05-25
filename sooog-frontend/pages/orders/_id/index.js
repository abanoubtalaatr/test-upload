import { mapState } from 'vuex'
import OrderService from "~/services/orders/OrderService.js"
import SideBar from '~/components/front/SideBar.vue'
import RatingModal from '~/pages/orders/-modal/-rate/-rate.vue'
import CancelModal from '~/pages/orders/-modal/-cancel/-index.vue'

export default {
  middleware: ['auth'],
  scrollToTop: true,
  validate({ params, query, store }) {
    if (params.id) {
      return !isNaN(params.id);
    }
    return true;
  },
  components: {
    SideBar,
    RatingModal,
    CancelModal
  },
  async asyncData (context) {
    const order = await context.$axios.$get(`/orders/${context.params.id}`).catch(() => {})

    return { order }
  },
  data () {
    return {
      titlePage: this.$t('front.order_details'),
      customEvents: [
        { eventName: 'rate-product', callback: this.handleRating },
        { eventName: 'cancel-order', callback: this.handleCancellation },
      ]
    }
  },
  created () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      settings: state => state.localStorage.settings,
    }),
    canRate() {
      if (this.settings) {
        // return rate.body ? true : false
        if (this.settings.can_rate) {
          return true
        }
      }
      return false
    },
  },
  methods: {
    openRateModal (id) {
      this.$EventBus.$emit('open-rating-modal', id)
    },
    handleRating (id) {
      // let itemIndex = this.collection.filter((order) => order.item.service.id != id)
    },
    openCancelModal () {
      this.$EventBus.$emit('open-cancel-modal', this.order.id)
    },
    handleCancellation (data) {
      this.order = data
    },
    async changeStatus () {
      this.$nuxt.$loading.start()
      await OrderService.changeStatus({status: 'delivered'}, this.order.id)
        .then((response) => {
          this.order = response
          this.$toast.success(this.$t('front.updated_successfully'))
        })
        .catch(() => {})
      this.$nuxt.$loading.finish()
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
};
