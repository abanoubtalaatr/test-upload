import { mapState } from 'vuex'
import formData from '~/pages/stores/promo-codes/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('promo_codes.update')) {
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
    const [ item, users ] = await Promise.all([
        context.$axios.$get(`/store/promo-codes/${context.params.id}`).catch(() => {}),
        //context.$axios.$get('/admin/stores?type=stores&status=accepted').catch(() => {}),
        context.$axios.$get('/admin/users?is_paginated=false&is_active=1').catch(() => {}),
    ])
    return { item, users }
  },
  data() {
    return {
      titlePage: this.$t('admin.promoCodes'),
      param_id: this.$route.params.id,
      stores: []
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
