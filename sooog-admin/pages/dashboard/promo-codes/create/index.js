import { mapState } from 'vuex'
import formData from '~/pages/dashboard/promo-codes/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData(context) {
    const [ stores, users ] = await Promise.all([
      context.$axios.$get('/admin/stores?type=stores&status=accepted').catch(() => {}),
      context.$axios.$get('/admin/users?is_paginated=false&is_active=1').catch(() => {})
    ])
    return { stores, users }
  },
  data() {
    return {
      titlePage: this.$t('admin.promoCodes'),
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
