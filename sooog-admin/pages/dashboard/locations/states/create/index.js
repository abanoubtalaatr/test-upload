import { mapState } from 'vuex'
import formData from '~/pages/dashboard/locations/states/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData (context) {
    const [ countries ] = await Promise.all([
      context.$axios.$get('/admin/location/countries?is_paginated=0&all=1').catch(() => {}),
    ])
    return { countries }
  },
  data() {
    return {
      titlePage: this.$t('admin.states'),
    }
  },
  computed: {
    titleStack () {
      return [this.titlePage, this.$t('admin.create')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
