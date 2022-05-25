import { mapState } from 'vuex'
import formData from '~/pages/dashboard/services/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData(context) {
    const [ categories, stores ] = await Promise.all([
      context.$axios.$get('/admin/categories?type=centers&is_paginated=0').catch(() => {}),
      context.$axios.$get('/admin/stores?type=centers&is_paginated=0').catch(() => {}),
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
