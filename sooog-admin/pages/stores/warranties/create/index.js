import { mapState } from 'vuex'
import formData from '~/pages/stores/warranties/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('warranties.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.warranties'),
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
