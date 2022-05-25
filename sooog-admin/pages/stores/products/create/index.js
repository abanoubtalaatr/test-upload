import { mapState } from 'vuex'
import formData from '~/pages/stores/products/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('products.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData(context) {
    const [ categories, brands, countries, settings ] = await Promise.all([
      context.$axios.$get('/store/categories?type=stores&is_paginated=0').catch(() => {}),
      context.$axios.$get('/store/brands?&is_paginated=0').catch(() => {}),
      context.$axios.$get('/store/location/countries?is_paginated=0&all=1').catch(() => {}),
      context.$axios.$get('/store/settings').catch(() => {}),

    ])
    return { categories, brands, countries, settings }
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
