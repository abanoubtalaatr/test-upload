import { mapState } from 'vuex'
import formData from '~/pages/dashboard/product-orders/-form/-index.vue'

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
    const [ item, stores, payment_methods, warranties ] = await Promise.all([
        context.$axios.$get(`/admin/orders/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/stores?type=stores&status=accepted').catch(() => {}),
        context.$axios.$get('/admin/payment-methods').catch(() => {}),
        // context.$axios.$get(`/admin/warranties`).catch(() => {}),
    ])
    return { item, stores, payment_methods, warranties }
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
