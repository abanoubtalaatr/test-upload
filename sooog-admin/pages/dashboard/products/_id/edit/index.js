import { mapState } from 'vuex'
import formData from '~/pages/dashboard/products/-form/-index.vue'

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
    const [ item, categories, stores, brands, countries, settings ] = await Promise.all([
        context.$axios.$get(`/admin/products/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/categories?type=stores&is_paginated=0').catch(() => {}),
        context.$axios.$get('/admin/stores?type=stores&is_paginated=0').catch(() => {}),
        context.$axios.$get('/admin/brands?&is_paginated=0').catch(() => {}),
        context.$axios.$get('/admin/location/countries?is_paginated=0&all=1').catch(() => {}),
        context.$axios.$get('/admin/settings').catch(() => {}),

    ])
    return { item, categories, stores, brands, countries, settings }
  },
  data() {
    return {
      titlePage: this.$t('admin.products'),
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
