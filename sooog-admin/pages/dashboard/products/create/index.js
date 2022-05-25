import { mapState } from 'vuex'
import formData from '~/pages/dashboard/products/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData(context) {
    const [ categories, stores, brands, countries, settings ] = await Promise.all([
      context.$axios.$get('/admin/categories?type=stores&is_paginated=0').catch(() => {}),
      context.$axios.$get('/admin/stores?type=stores&is_paginated=0').catch(() => {}),
      context.$axios.$get('/admin/brands?&is_paginated=0').catch(() => {}),
      context.$axios.$get('/admin/location/countries?is_paginated=0&all=1').catch(() => {}),
      context.$axios.$get('/admin/settings').catch(() => {}),
    ])
    return { categories, stores, brands, countries, settings }
  },
  data() {
    return {
      titlePage: this.$t('admin.products'),
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
