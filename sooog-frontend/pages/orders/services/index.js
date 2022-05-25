import { mapState } from 'vuex'
import OrderService from "~/services/orders/OrderService.js"
import SideBar from '~/components/front/SideBar.vue'
import RatingModal from '~/pages/orders/-modal/-rate/-rate.vue'
import CancelModal from '~/pages/orders/-modal/-cancel/-index.vue'

export default {
  middleware: ['auth'],
  components: {
    SideBar,
    RatingModal,
    CancelModal
  },
  async asyncData (context) {
    const response = await context.$axios.$get('/orders?type=centers&is_paginated=1').catch(() => {})

    return {
      collection: response?.data || [],
      meta: response?.meta,
      links: response?.links
    }
  },
  data () {
    return {
      titlePage: this.$t('front.myservices'),
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
    openCancelModal (id) {
      this.$EventBus.$emit('open-cancel-modal', id)
    },
    handleCancellation (data) {
      let itemIndex = this.collection.findIndex((order) => order.id == data.id)
      debugger
      if (itemIndex >= 0) {
        this.$set(this.collection, itemIndex, data)
      }
    },
    async changeStatus (id) {
      this.$nuxt.$loading.start()
      await OrderService.changeStatus({status: 'delivered'}, id)
        .then((response) => {
          let itemIndex = this.collection.findIndex((order) => order.id == id)
          if (itemIndex >= 0) {
            this.$set(this.collection, itemIndex, response)
          }
          debugger
          this.$toast.success(this.$t('front.updated_successfully'))
        })
        .catch(() => {})
      this.$nuxt.$loading.finish()
    },
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?type=centers&page=${this.meta.current_page}&is_paginated=1`

      await OrderService.getAll(this.queryParam)
        .then((response) => {
          this.collection = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.collection = []
        })
        this.$nuxt.$loading.finish();
    },
    /*
    * Handle page-change event
    */
    onPageChange (page) {
      this.meta.current_page = page
      this.loadAsyncData()
    },
    prevPage() {
      if (this.links.prev_page_url) {
        this.onPageChange(this.meta.current_page - 1)
      }
    },
    nextPage() {
      if (this.links.next_page_url) {
        this.onPageChange(this.meta.current_page + 1)
      }
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
};
