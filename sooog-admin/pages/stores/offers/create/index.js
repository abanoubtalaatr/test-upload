import { mapState } from 'vuex'
import formData from '~/pages/stores/offers/-form/-index.vue'

export default {
  layout: "store",
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('offers.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData(context) {
    const [ products ] = await Promise.all([
      context.$axios.$get('/stores/products?type=stores').catch(() => {})
    ])
    return { products }
  },
  data() {
    return {
      titlePage: this.$t('admin.offers'),
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
