import { mapState } from 'vuex'
import ProfileService from "~/services/profile/ProfileService.js"
import SideBar from '~/components/front/SideBar.vue';
import UploaderService from '~/services/uploader/UploaderService.js'
import _ from 'lodash'

export default {
  middleware: ['auth'],
  components: {
    SideBar,
  },
  async asyncData (context) {
    const response = await context.$axios.$get('/user-transactions').catch(() => {})

    return {
      total: response?.total,
      collection: response?.transactions?.data || [],
      meta: response?.transactions?.meta,
      links: response?.transactions?.links
    }
  },
  data () {
    return {
      titlePage: this.$t('front.wallet'),
      queryParam: '',
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  methods: {
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1`

      await ProfileService.getTransactions(this.queryParam)
        .then((response) => {
          this.total = response.total
          this.collection = response.transactions.data

          this.meta = response.transactions.meta
          this.links = response.transactions.links
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
