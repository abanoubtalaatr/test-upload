import { mapState } from 'vuex'
import detailsData from '~/pages/dashboard/stores-updates/-details/-index.vue'

export default {
  components: {
    detailsData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/admin/stores/temp-stores/${context.params.id}`).catch(() => {})
    ])
    console.log(item);
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.stores_update_request'),
      param_id: this.$route.params.id,
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
