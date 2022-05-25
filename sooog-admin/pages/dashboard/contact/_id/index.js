import { mapState } from 'vuex'
import ContactService from "../-service/-ContactService";

export default {
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/admin/contact-us/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.contact'),
      param_id: this.$route.params.id,
      form:{
        body:'',
      },
      submitted: false
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    titleStack () {
      return [this.titlePage, this.$t('admin.show')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  },
  methods: {
    back () {
      this.$router.push(this.localePath({ name: 'dashboard-contact' }))
    },
    async submit (id) {
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.reply(id)
      }else{
        this.submitted = false
      }
    },
    async reply (id) {
      await ContactService.update(this.form,id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {})
    },
  },
}
