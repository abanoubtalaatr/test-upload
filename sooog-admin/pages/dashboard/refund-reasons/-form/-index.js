import { mapState } from 'vuex'
import RefundReasonService from "../-service/-RefundReasonService";
export default {
    props: {
        item: {
            required: false
        }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          is_active: true,
          type: 'normal'
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
        this.form ={... this.item}
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          if (this.param_id) {
            this.update()
          } else {
            this.create()
          }
        }else{
          this.submitted = false
        }
      },
      async update () {
        await RefundReasonService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        await RefundReasonService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-refund-reasons" }))
      }
    },
  }
