import { mapState } from 'vuex'
import OfferService from "../-service/-OfferService";
import OfferProducts from '~/pages/stores/offers/-form/-OfferProducts/-index.vue'
export default {
    components: {
      OfferProducts
    },
    props: {
      item: {
          required: false
      },
      products: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          type: 'percentage',
          value: null,
          free_product_id: null,
          start_date: null,
          end_date: null,
          is_active: true,
          products: [],
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
            value: 'free_product',
            text: this.$t('admin.free_product')
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
      })
    },
    async fetch() {
      if (this.param_id) {
        this.reAssignForm()
      }
    },
    fetchOnServer: true,
    created () {
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
        this.form = {...this.item, ...{
          products: this.item.products.map(product => product.id)
        }}
        console.log('form: ', this.form)
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
        await OfferService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        await OfferService.create(this.form)
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
        this.$router.push(this.localePath({ name: "stores-offers" }))
      }
    },
  }
