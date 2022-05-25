import { mapState } from 'vuex'
import formData from '~/pages/stores/products/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('products.update')) {
      return redirect(app.localePath('stores-403'))
    }
  },
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
    const [ item, categories, brands, countries, settings ] = await Promise.all([
        context.$axios.$get(`/store/products/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/store/categories?type=stores&is_paginated=0').catch(() => {}),
        context.$axios.$get('/store/brands?&is_paginated=0').catch(() => {}),
        context.$axios.$get('/store/location/countries?is_paginated=0&all=1').catch(() => {}),
        context.$axios.$get('/store/settings').catch(() => {}),
    ])
    return { item, categories, brands, countries, settings }
  },
  data() {
    return {
      titlePage: this.$t('admin.products'),
      param_id: this.$route.params.id,
      stores:[]
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
