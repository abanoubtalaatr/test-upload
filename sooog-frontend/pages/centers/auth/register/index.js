import FormData from "~/pages/stores/auth/-form/-index.vue"

export default {
  components: {
    FormData
  },
  async asyncData (context) {
    const [ countries ] = await Promise.all([
      context.$axios.$get(`/location/countries?is_paginated=0`).catch(() => {}),
    ])
    return { countries }
  },
  data() {
    return {
      titlePage: this.$t('front.register'),
    }
  },
  methods: {},

  head() {
    return {
      title: this.titlePage
    }
  }
}
;
