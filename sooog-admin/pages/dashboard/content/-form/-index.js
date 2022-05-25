import { mapState } from 'vuex'
import ContentService from "../-service/-ContentService"

export default {
    props: {
      item: {
          required: true
      }
    },
    data() {
      return {
        editor: null,
        form: {
          en: {
            title: '' ,
            body: ''
          },
          ar: {
            title: '',
            body: ''
           }
        },
        param_id: this.$route.params.id,
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    async fetch() {
      if (this.param_id) {
        this.reAssignForm()
      }
    },
    fetchOnServer: true,
    methods: {
      reAssignForm () {
        this.form = {...this.item}
        console.log('thform: ', this.form)
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          await ContentService.update(this.form, this.param_id)
          .then(() => {
            this.$toast.success(this.$t('admin.updated_successfully'))
            this.submitted = false
          })
          .catch(() => {
            this.submitted = false
          })
        }else{
          this.submitted = false
        }
      }
    },
  }
