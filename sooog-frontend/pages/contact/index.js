import {mapState} from 'vuex'
import { mapValues } from 'lodash'
import ContactUsService from "~/services/contactUs/ContactUsService.js"

export default {
  // middleware: ['auth'],
  components: {},
  data() {
    return {
      titlePage: this.$t('front.contact_us'),
      form: {
        name: '',
        phone: '',
        email: '',
        title: '',
        body: '',
      },
    }
  },
  created() {
    if (this.authUser) {
      this.handleReset()
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      settings: state => state.localStorage.settings,
    })
  },
  methods: {
    async create() {
      const validData = await this.$validator.validateAll()
      if (validData) {
        await ContactUsService.create(this.form)
          .then(() => {
            this.$toast.success(this.$t('admin.created_successfully'))
            this.handleReset();
            // this.$router.push(this.localePath({ name: "index" }))
          })
          .catch(() => {
          })
      }
    },
    handleReset() {
        if (!this.authUser) {
            this.form = mapValues(this.form, (item) => {
                if (item && (typeof item === 'object' || Array.isArray(item))) {
                    return []
                }
                return ''
            })
        }else{
      this.form = {
        name: this.authUser.name,
        phone: this.authUser.phone,
        email: this.authUser.email,
        title: '',
        body: '',
      }
        }
      this.$validator.reset()
    }
  },

head()
{
  return {
    title: this.titlePage
  }
}
}
;
