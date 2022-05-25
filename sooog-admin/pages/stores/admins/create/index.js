import { mapState } from 'vuex'
import formData from '~/pages/stores/admins/-form/-index.vue'

export default {
  layout: 'store',
  middleware({ redirect, app }) {
    // If the user is not authorized
    if (!app.$cookies.get("storePermissions").includes('admins.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData (context) {
    const [ roles ] = await Promise.all([
      context.$axios.$get(`/store/roles?is_paginated=0`).catch(() => {})
    ])
    return { roles }
  },
  data() {
    return {
      titlePage: this.$t('admin.admins'),
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
