import { mapState } from 'vuex'
import OrderService from "~/services/orders/OrderService.js"
import SideBar from '~/components/front/SideBar.vue'

export default {
  middleware: ['auth'],
  components: {
    SideBar
  },
  async asyncData (context) {
    const response = await context.$axios.$get('/orders?type=stores&is_paginated=1').catch(() => {})

    return {
      collection: response?.data || [],
      meta: response?.meta,
      links: response?.links
    }
  },
  data () {
    return {
      titlePage: this.$t('front.myorders'),
      customEvents: [
        { eventName: 'rate-product', callback: this.handleRating },
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
    })
  },
  methods: {
    handleRating (id) {
      // this.collection = this.collection.filter((product) => product.id != id)
    },
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?type=stores&page=${this.meta.current_page}&is_paginated=1`

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
