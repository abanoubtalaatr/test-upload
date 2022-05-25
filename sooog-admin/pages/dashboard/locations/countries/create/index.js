import { mapState } from 'vuex'
import formData from '~/pages/dashboard/locations/countries/-form/-index.vue'

export default {
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.countries'),
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
