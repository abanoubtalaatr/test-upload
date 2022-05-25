import { mapState } from 'vuex'
import FavouriteService from "~/services/products/FavouriteService.js"
import SideBar from '~/components/front/SideBar.vue'
import productBlock from '~/pages/products/-product/-index.vue'

export default {
  middleware: ['auth'],
  components: {
    SideBar,
    productBlock
  },
  async asyncData (context) {
    const response = await context.$axios.$get('/favourites?is_paginated=1').catch(() => {})

    return {
      collection: response?.data || [],
      meta: response?.meta,
      links: response?.links
    }
  },
  data () {
    return {
      titlePage: this.$t('front.favourites'),
      customEvents: [
        { eventName: 'remove-fav-product', callback: this.handleDestroy },
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
    handleDestroy (id) {
      this.collection = this.collection.filter((product) => product.id != id)
    },
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1`

      await FavouriteService.getAll(this.queryParam)
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
