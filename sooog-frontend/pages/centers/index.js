
import CenterService from "~/services/centers/CenterService.js"

export default {
  async asyncData (context) {
    const response = await context.$axios.$get(`/stores?type=centers&is_paginated=1`).catch(() => {})
    return {
      centers: response.data,
      meta: response.meta,
      links: response.links
    }
  },
  data() {
    return {
      titlePage: this.$t('front.centers'),
      queryParam: '',
    }
  },
  methods: {
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&type=centers&is_paginated=1`

      await CenterService.getAll(this.queryParam)
        .then((response) => {
          this.centers = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.centers = []
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
}
