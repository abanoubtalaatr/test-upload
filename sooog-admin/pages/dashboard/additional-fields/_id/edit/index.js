import { mapState } from 'vuex'
import formData from '~/pages/dashboard/additional-fields/-form/-index.vue'

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
    const [ item, categories, property_types ] = await Promise.all([
        context.$axios.$get(`/admin/properties/${context.params.id}`).catch(() => {}),
        context.$axios.$get('/admin/categories?type=stores&is_paginated=0').catch(() => {}),
        context.$axios.$get('/admin/property-types?is_paginated=0').catch(() => {})
    ])
    return { item, categories, property_types }
  },
  data() {
    return {
      titlePage: this.$t('admin.properties'),
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
