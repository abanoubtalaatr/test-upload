import { mapState } from 'vuex'
import refundData from '~/pages/dashboard/product-orders/-refund/-index.vue'

export default {
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
        context.$axios.$get(`/admin/orders/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/refund-reasons').catch(() => {})
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
