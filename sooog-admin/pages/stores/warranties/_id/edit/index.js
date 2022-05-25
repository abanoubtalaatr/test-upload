import { mapState } from 'vuex'
import formData from '~/pages/stores/warranties/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('warranties.update')) {
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
    const [ item ] = await Promise.all([
        context.$axios.$get(`/store/warranties/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.warranties'),
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
