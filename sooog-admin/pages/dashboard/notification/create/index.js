import { mapState } from 'vuex'
import formData from '~/pages/dashboard/notification/-form/-index.vue'

export default {
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.notifications'),
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
