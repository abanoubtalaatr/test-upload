import { mapState } from 'vuex'
import DetailsData from '~/pages/centers/service-orders/-details/-index.vue'

export default {
  layout: 'center',
  middleware({redirect, app}) {
    // If the user is not authorized
    if (!app.$cookies.get("centerPermissions").includes('orders.index')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    DetailsData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/center/orders/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.orders'),
      param_id: this.$route.params.id
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
  head () {
    return {
      title: this.titlePage
    }
  }
}
