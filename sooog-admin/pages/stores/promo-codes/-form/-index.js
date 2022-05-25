import { mapState } from 'vuex'
import PromoCodeService from "../-service/-PromoCodeService";
export default {
  layout: 'store',
    props: {
      item: {
          required: false
      },
      // stores: {
      //   required: true,
      //   type: Array
      // },
      users: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          code: '',
          type: 'percentage',
          applied_to: 'all_users',
          value: null,
          free_product_id: null,
          start_date: null,
          end_date: null,
          is_active: true,
          stores: [],
          user_id: null,
          max_use_number: null,
          order_min_cost: null
        },
        param_id: this.$route.params.id,
        options: [
          {
            value: 'percentage',
            text: this.$t('admin.percentage')
          },
          {
            value: 'value',
            text: this.$t('admin.value')
          },
          {
            value: 'free_delivery_charge',
            text: this.$t('admin.free_delivery_charge')
          },
          // {
          //   value: 'free_cash_charge',
          //   text: this.$t('admin.free_cash_charge')
          // }
        ],
        appliedToOptions: [
          {
            value: 'all_users',
            text: this.$t('admin.all_users')
          },
          {
            value: 'specific_user',
            text: this.$t('admin.specific_user')
          }
        ],
        customEvents: [
          { eventName: 'selected-products-event', callback: this.handleProducts }
        ],
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
        storeData: state => JSON.parse(state.localStorage.storeData),
      })
    },
    async fetch() {
      if (this.param_id) {
        this.reAssignForm()
      }
    },
    fetchOnServer: true,
    created () {
    if(this.storeData){
      this.form.stores.push(this.storeData);
    }
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    destroyed () {
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    methods: {
      reAssignForm () {
        console.log('item', this.item)
        this.form = {...this.item,
        user_id: this.item.user?.id

      }
        console.log('form: ', this.form)
      },
      async submit () {
        console.log('form////: ', this.form)
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          this.form.stores = this.form.stores.map(store => store.id)
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
        await PromoCodeService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        await PromoCodeService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      openProductsModal(inputType = 'checkbox'){
        this.$EventBus.$emit('open-products-modal', {
          'inputType': inputType,
          'selectedProducts': this.form.products,
          'selectedProduct': this.form.free_product_id
        })
      },
      handleProducts(data){
        console.log('prod-event', data)
        if(data.inputType == 'checkbox')
          this.form.products = data.selectedProducts
        else
          this.form.free_product_id = data.selectedProduct
      },
      back () {
        this.$router.push(this.localePath({ name: "stores-promo-codes" }))
      }
    },
  }
