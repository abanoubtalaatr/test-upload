import { mapState } from 'vuex'
import DetailsData from '~/pages/dashboard/refunds/-details/-index.vue'

export default {
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
        context.$axios.$get(`/admin/refunds/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.refunds'),
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
