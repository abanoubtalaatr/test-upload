import { mapState } from 'vuex'
import formData from '~/pages/dashboard/refund-reasons/-form/-index.vue'

export default {
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.refund_reasons'),
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
