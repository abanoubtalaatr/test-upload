import { mapState } from 'vuex'
import formData from '~/pages/centers/admins/-form/-index.vue'

export default {
  layout: 'center',
  middleware({redirect, app}) {
    // If the user is not authorized
    if (!app.$cookies.get("centerPermissions").includes('admins.update')) {
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
    const [ item, roles ] = await Promise.all([
      context.$axios.$get(`/center/admins/${context.params.id}`).catch(() => {}),
      context.$axios.$get(`/center/roles?is_paginated=0`).catch(() => {})
    ])
    return { item, roles }
  },
  data() {
    return {
      titlePage: this.$t('admin.admins'),
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
