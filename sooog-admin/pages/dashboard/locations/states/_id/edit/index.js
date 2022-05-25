import { mapState } from 'vuex'
import formData from '~/pages/dashboard/locations/states/-form/-index.vue'

export default {
  components: {
    formData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ countries, item ] = await Promise.all([
      context.$axios.$get('/admin/location/countries?is_paginated=0&all=1').catch(() => {}),
      context.$axios.$get(`/admin/location/states/${context.params.id}`).catch(() => {})
    ])
    return { countries, item }
  },
  data() {
    return {
      titlePage: this.$t('admin.states'),
      param_id: this.$route.params.id,
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    titleStack () {
      return [this.titlePage, this.$t('admin.edit')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
