import { mapState } from 'vuex'
import formData from '~/pages/dashboard/admins/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData (context) {
    const [ roles ] = await Promise.all([
      context.$axios.$get(`/admin/roles?is_paginated=0`).catch(() => {})
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
