import { mapState } from 'vuex'
import formData from '~/pages/dashboard/categories/-form/-index.vue'

export default {
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
    const [ item, categories ] = await Promise.all([
        context.$axios.$get(`/admin/categories/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/categories?is_paginated=0&all=1&type=stores').catch(() => {})
    ])
    return { item, categories }
  },
  data() {
    return {
      titlePage: this.$t('admin.subcategories'),
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
