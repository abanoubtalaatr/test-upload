import { mapState } from 'vuex'
import formData from '~/pages/centers/services/-form/-index.vue'

export default {
  layout: 'center',
  middleware({redirect, app}) {
    // If the user is not authorized
    if (!app.$cookies.get("centerPermissions").includes('services.create')) {
      return redirect(app.localePath('stores-403'))
    }
  },
  components: {
    formData
  },
  async asyncData(context) {
    const [ categories, stores ] = await Promise.all([
      context.$axios.$get('/center/categories?type=centers&is_paginated=0').catch(() => {}),
      context.$axios.$get('/center/stores?type=centers&is_paginated=0').catch(() => {}),
    ])
    return { categories, stores }
  },
  data() {
    return {
      titlePage: this.$t('admin.services'),
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
