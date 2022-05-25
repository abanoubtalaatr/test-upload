import { mapState } from 'vuex'
import formData from '~/pages/dashboard/offers/-form/-index.vue'

export default {
  components: {
    formData
  },
  async asyncData(context) {
    const [ products ] = await Promise.all([
      context.$axios.$get('/admin/products?type=stores').catch(() => {})
    ])
    return { products }
  },
  data() {
    return {
      titlePage: this.$t('admin.offers'),
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
