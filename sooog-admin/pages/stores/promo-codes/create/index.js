import { mapState } from 'vuex'
import formData from '~/pages/stores/promo-codes/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('promo_codes.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData(context) {
    const [ users ] = await Promise.all([
      //context.$axios.$get('/store/stores?type=stores&status=accepted').catch(() => {}),
      context.$axios.$get('/store/users?is_paginated=false&is_active=1').catch(() => {})
    ])
    return { users }
  },
  data() {
    return {
      titlePage: this.$t('admin.promoCodes'),
      stores: []
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
