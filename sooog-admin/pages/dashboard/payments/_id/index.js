import { mapState } from 'vuex'
import PaymentService from "~/pages/dashboard/payments/-service/-PaymentService"

export default {
  components: {},
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/admin/payments/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.payments'),
      param_id: this.$route.params.id,
      itemsData: [
        {
          key: "id",
          label: this.$t('admin.order_id')
        },
        {
          key: "total",
          label: this.$t('admin.reserved_amount')
        },
        // {
        //   key: "application_dues_percentage",
        //   label: this.$t('admin.commission_percentage')
        // },
        // {
        //   key: "application_dues",
        //   label: this.$t('admin.commission_value')
        // },
        {
          key: "amount_before_commission",
          label: this.$t('admin.amount_before_commission')
        },
        {
          key: "created_at",
          label: this.$t('admin.payment_actual_date')
        },
      ]
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    titleStack () {
      return [this.titlePage, this.$t('admin.show')]
    }
  },
  methods: {
    back () {
      this.$router.push(this.localePath('dashboard-payments'))
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
