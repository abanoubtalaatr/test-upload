import { mapState } from 'vuex'
import formData from '~/pages/stores/roles/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('roles.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData (context) {
    const [ permissions ] = await Promise.all([
      context.$axios.$get(`/store/permissions`).catch(() => {}),
    ])
    return { permissions }
  },
  data() {
    return {
      titlePage: this.$t('admin.roles'),
    }
  },
  computed: {
    titleStack () {
      return [this.titlePage, this.$t('admin.create')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
