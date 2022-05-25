import { mapState } from 'vuex'
import formData from '~/pages/dashboard/admins/-form/-index.vue'

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
    const [ item, roles ] = await Promise.all([
      context.$axios.$get(`/admin/admins/${context.params.id}`).catch(() => {}),
      context.$axios.$get(`/admin/roles?is_paginated=0`).catch(() => {})
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
