import { mapState } from 'vuex'
import formData from '~/pages/stores/roles/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('roles.update')) {
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
    const [ permissions, item ] = await Promise.all([
      context.$axios.$get(`/store/permissions`).catch(() => {}),
      context.$axios.$get(`/store/roles/${context.params.id}`).catch(() => {})
    ])
    return { permissions, item }
  },
  data() {
    return {
      titlePage: this.$t('admin.roles'),
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
