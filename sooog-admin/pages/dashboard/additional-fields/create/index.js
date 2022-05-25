import { mapState } from 'vuex'
import formData from '~/pages/dashboard/additional-fields/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData(context) {
    const [ categories, property_types ] = await Promise.all([
      context.$axios.$get('/admin/categories?type=stores&is_paginated=0').catch(() => {}),
      context.$axios.$get('/admin/property-types?is_paginated=0').catch(() => {}),
    ])
    return { categories, property_types }
  },
  data() {
    return {
      titlePage: this.$t('admin.properties'),
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
