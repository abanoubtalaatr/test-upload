import ProductService from '@/pages/dashboard/products/-service/-ProductService'
import Search from '~/components/Search.vue'
export default {
  components: {
    Search
  },
    data () {
      return {
        modalId: 'productsModal',
        titlePage: this.$t('admin.products'),
        products: [],
        pagination: {},
        current_page: 1,
        inputType: 'checkbox',
        selectedProducts: [],
        selectedProduct: '',
        publicSearch: '',
        queryParam: '',
        customEvents: [
          { eventName: 'open-products-modal', callback: this.showModal },
          { eventName: 'close-products-modal', callback: this.hideModal },
          { eventName: 'handle-quick-search', callback: this.handleSearch },
        ]
      }
    },
    // async fetch() {
    //     this.loadAsyncData()
    // },
    //fetchOnServer: true,
    created () {
      this.loadAsyncData()
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback)
      }.bind(this))
      this.$on('page-changed', this.onPageChange)
    },
    destroyed () {
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    mounted () {
        this.$EventBus.$emit('enable-quick-search', true)
    },
    methods: {
        handleSearch (search) {
            this.publicSearch = search
            this.onPageChange(1)
        },
        /*
        * Load async data
        */
        loadAsyncData () {
        //this.$nuxt.$loading.start();
    
        this.queryParam = `?page=${this.current_page}&type=stores&is_paginated=1&is_detailed=1&public_search=${this.publicSearch}`
    
        ProductService.getAll(this.queryParam)
            .then((response) => {
            this.products = response.data
    
            this.pagination = response.meta
            this.current_page = response.meta.current_page
            this.links = response.links
            })
            .catch(() => {
            this.products = []
            })
            //this.$nuxt.$loading.finish();
        },
        /*
        * Handle page-change event
        */
        onPageChange (page) {
        //this.meta.current_page = page
        this.current_page = page
        this.loadAsyncData()
        },
      showModal (data) {
          console.log('showwwh', data)
        //* show modal */
        this.selectedProducts = data.selectedProducts
        this.selectedProduct = data.selectedProduct
        this.inputType = data.inputType
        this.$bvModal.show(this.modalId)
      },
      hideModal () {
        this.$bvModal.hide(this.modalId)
      },
      cancelModal () {
        this.hideModal()
      },
      saveProducts () {
        this.$validator.validateAll().then(result => {
          if (!result) {
            return
          }
          console.log('ss', this.selectedProducts)
          this.$EventBus.$emit('selected-products-event', {
              'inputType': this.inputType, 
              'selectedProducts': this.selectedProducts,
              'selectedProduct': this.selectedProduct,
            })
          this.hideModal()
        });
        
      }
  
    },
    computed: {
        titleStack () {
          return ['']
        }
      },
  }
  