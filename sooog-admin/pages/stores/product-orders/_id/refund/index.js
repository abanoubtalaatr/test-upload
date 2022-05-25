import { mapState } from 'vuex'
import refundData from '~/pages/stores/product-orders/-refund/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('refunds.index')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    refundData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item, refund_reasons ] = await Promise.all([
        context.$axios.$get(`/store/orders/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/store/refund-reasons').catch(() => {})
    ])
    return { item, refund_reasons }
  },
  data() {
    return {
      titlePage: this.$t('admin.orders'),
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
