import { mapState } from 'vuex'
import OrderService from '~/pages/centers/service-orders/-service/-OrderService'
import UserService from '~/pages/centers/service-orders/-service/-UserService'
import ProductService from '@/pages/centers/service-orders/-service/-ProductService'
export default {
  layout: 'center',
    props: {
      item: {
          required: true
      },
      payment_methods: {
        required: true,
        type: Array
      },
      stores: {
        required: true,
        type: Array
      },
      categories: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          store_id: null,
          service_id: null,
          service_wanted_date: null,
          subcategory_id: null,
          problem_description: null,
          use_wallet:true,
          admin_notes: null,
          payment_method_id: null,
          user_address_id: null,
          promo_code: null,
          depositor_name: null,
          deposit_amount: null,
          deposit_receipt: null,
        },
        addresses: [],
        subcategories: [],
        services: [],
        param_id: this.$route.params.id,
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    // async fetch() {
    //   if (this.param_id) {
    //     this.reAssignForm()
    //     this.getuserAddresses()
    //       this.getSubcategories()
    //       this.getServices()
    //   }
    // },
    created () {
      if (this.param_id) {
         this.reAssignForm()
         this.getuserAddresses()
          this.getSubcategories()
          this.getServices()
       }
    },
    methods: {
       async getuserAddresses(){
        await UserService.listAddresses(this.item.user.id)
          .then((response) => {
            console.log('addresses>>>', response)
          this.addresses = response
          
          })
          .catch(() => {
          this.addresses = []
          })
      },
      async getSubcategories(){
        await ProductService.getSubCategories(this.form.category_id)
        .then((response) => {
          console.log('subcategories>>>', response)
        this.subcategories = response
        
        })
        .catch(() => {
        this.subcategories = []
        })
      },
      async getServices(){
        this.queryParam = `?type=centers&has_pagination=0&is_detailed=1&store=${this.form.store_id}`
        await ProductService.getAll(this.queryParam)
        .then((response) => {
          console.log('services>>>', response)
        this.services = response
        
        })
        .catch(() => {
        this.services = []
        })
      },
      reAssignForm () {
        
        console.log('item', this.item)
        this.form = {
          store_id: this.item.store?.id,
          service_id: this.item.item.service?.id,
          service_wanted_date: this.item.service_wanted_date,
          subcategory_id: this.item.item.subcategory?.id,
          category_id: this.item.item.subcategory.category?.id,
          problem_description: this.item.item.problem_description,
          use_wallet:true,
          admin_notes: this.item.admin_notes,
          payment_method_id: this.item.payment_method?.id,
          user_address_id: this.item.user_address?.id,
          promo_code: null,
          // depositor_name: this.item.bank_transfer?.depositor_name,
          // deposit_amount: this.item.bank_transfer?.deposit_amount,
          // deposit_receipt: this.item.bank_transfer?.deposit_receipt
        }        
        console.log('form: ', this.form)
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          this.update()
          // if (this.param_id) {
          //   this.update()
          // } else {
          //   this.create()
          // }
        }else{
          this.submitted = false
        }
      },
      async update () {
        await OrderService.updateService(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {})
      },
      // async create () {
      //   await OrderService.createService(this.form)
      //   .then(() => {
      //     this.back()
      //     this.$toast.success(this.$t('admin.created_successfully'))
      //   })
      //   .catch(() => {})
      // },
      back () {
        this.$router.push(this.localePath({ name: "centers-service-orders" }))
      }
    },
  }
