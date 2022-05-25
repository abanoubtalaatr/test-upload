import { mapState } from 'vuex'
import formData from '~/pages/dashboard/categories/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData (context) {
    const [ categories ] = await Promise.all([
      context.$axios.$get('/admin/categories?is_paginated=0&all=1&type=stores').catch(() => {}),
    ])
    return { categories }
  },
  data() {
    return {
      titlePage: this.$t('admin.subcategories'),
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
