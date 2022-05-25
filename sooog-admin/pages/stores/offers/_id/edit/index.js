import { mapState } from 'vuex'
import formData from '~/pages/stores/offers/-form/-index.vue'

export default {
  layout: "store",
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('offers.update')) {
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
    const [ item, products ] = await Promise.all([
        context.$axios.$get(`/store/offers/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/store/products?type=stores').catch(() => {})
    ])
    return { item, products }
  },
  data() {
    return {
      titlePage: this.$t('admin.offers'),
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
