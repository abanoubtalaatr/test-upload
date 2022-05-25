import { mapState } from 'vuex'
import StoreService from "../-service/-StoreService";
export default {
    props: {
      item: {
          required: true
      },
      back_route: {
        required: false,
        default: "dashboard-current-stores"
      },
      type: {
        required: false,
        default: "stores"
      }
    },
    data() {
      return {
        form: {
          has_delivery_service: false,
          delivery_charge: null,
          application_dues: null
        },
        param_id: this.$route.params.id,
        submitted: false,
        delivery_charge: 0.00
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
        this.form = {
          has_delivery_service: this.item.has_delivery_service,
          delivery_charge: this.item.delivery_charge,
          application_dues: this.item.application_dues > 0 ? this.item.application_dues : this.item.settings.find((setting) => setting.key == 'application_dues')?.body
        }
        if(!this.item.has_delivery_service)
          this.form.delivery_charge = this.item.settings.find((setting) => setting.key == 'delivery_charge')?.body || 0
        console.log('form: ', this.form)
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          this.update()
        }else{

          this.submitted = false
        }
      },
      async update () {
        await StoreService.update(this.param_id, this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: this.back_route }))
      }
    },
  }