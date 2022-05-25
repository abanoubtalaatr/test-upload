import { mapState } from 'vuex'
import NotificationService from "../-service/-NotificationService";
// import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
export default {
    props: {
        item: {
            required: false
        }
    },
    data() {
      return {
        form: {
          en: { title: '',body:'' },
          ar: { title: '',body:''  },
        },
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    fetchOnServer: true,
    methods: {
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
            this.create()
        }else{
          this.submitted = false
        }
      },
      async create () {
        await NotificationService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-notification" }))
      }
    },
  }
