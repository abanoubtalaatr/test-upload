import { mapState } from 'vuex'
import formData from '~/pages/dashboard/promo-codes/-form/-index.vue'

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
    const [ item, stores, users ] = await Promise.all([
        context.$axios.$get(`/admin/promo-codes/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/stores?type=stores&status=accepted').catch(() => {}),
        context.$axios.$get('/admin/users?is_paginated=false&is_active=1').catch(() => {}),
    ])
    return { item, stores, users }
  },
  data() {
    return {
      titlePage: this.$t('admin.promoCodes'),
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
