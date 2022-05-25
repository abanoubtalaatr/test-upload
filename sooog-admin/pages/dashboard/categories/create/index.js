import { mapState } from 'vuex'
import formData from '~/pages/dashboard/categories/-form/-index.vue'

export default {
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.categories'),
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
