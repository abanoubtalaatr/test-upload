import { mapState } from 'vuex'
import formData from '~/pages/dashboard/roles/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData (context) {
    const [ permissions ] = await Promise.all([
      context.$axios.$get(`/admin/permissions`).catch(() => {}),
    ])
    return { permissions }
  },
  data() {
    return {
      titlePage: this.$t('admin.roles'),
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
