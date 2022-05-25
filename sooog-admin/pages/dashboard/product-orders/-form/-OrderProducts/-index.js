import ProductService from '@/pages/dashboard/products/-service/-ProductService'
export default {
  props: {
    store_id: {
        required: true
    },
    warranties: {
      required: true
  }
  },
    data () {
      return {
        modalId: 'orderProductsModal',
        titlePage: this.$t('admin.products'),
        products: [],
        pagination: {},
        current_page: 1,
        inputType: 'checkbox',
        selectedProducts: [],
        selectedItems: [],
        publicSearch: '',
        queryParam: '',
        customEvents: [
          { eventName: 'open-order-products-modal', callback: this.showModal },
          { eventName: 'close-products-modal', callback: this.hideModal },
          { eventName: 'handle-quick-search', callback: this.handleSearch },
        ]
      }
    },
    async fetch() {
        this.loadAsyncData()
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
    mounted () {
        this.$EventBus.$emit('enable-quick-search', true)
    },
    methods: {
      updateItems (product) {
        if (this.selectedProducts.includes(product.id)) {
          let item = {
            product_id: product.id,
            quantity: product.item_quantity,
            warranty_id: product.warranty_id
          }
          this.selectedItems.push(item)
        } else {

          this.selectedItems = this.selectedItems.filter((obj) => obj.product_id != product.id)
        }
        console.log('selectedItems', this.selectedItems)
        //debugger
      },
      updateQuantity (product) {
        //* check product added to selected products to update quantity */
        let index = this.selectedItems.findIndex((item) => item.product_id == product.id)
        if (index >= 0) {
          this.selectedItems[index].quantity = product.item_quantity
        }
        console.log('selectedItems', this.selectedItems)
      },
      updateWarranty (product) {
        //* check product added to selected products to update quantity */
        let index = this.selectedItems.findIndex((item) => item.product_id == product.id)
        if (index >= 0) {
          this.selectedItems[index].warranty_id = product.warranty_id
        }
      },
        handleSearch (search) {
            this.publicSearch = search
            this.onPageChange(1)
        },
        /*
        * Load async data
        */
        async loadAsyncData () {
          console.log('store', this.store_id)
        this.queryParam = `?page=${this.current_page}&type=stores&store=${this.store_id}&is_paginated=1&is_detailed=1&public_search=${this.publicSearch}`
        await ProductService.getAll(this.queryParam)
            .then((response) => {
              console.log('rresponse', response)
            this.products = response.data
            this.pagination = response.meta
            this.current_page = response.meta.current_page
            this.links = response.links
            if(this.selectedItems.length > 0){
              this.selectedItems.forEach((item) => {
                let index = this.products.findIndex((product) => item.product_id == product.id)
                if (index >= 0) {
                  this.products[index].item_quantity = item.quantity
                  this.products[index].warranty_id = item.warranty_id
                }
              })
            }
            })
            .catch(() => {
            this.products = []
            })
        },
        /*
        * Handle page-change event
        */
        onPageChange (page) {
        this.meta.current_page = page
        this.current_page = page
        this.loadAsyncData()
        },
      showModal (data) {
        console.log('dddata', data)
        this.selectedItems = data
        this.selectedProducts = data.map((obj) => obj.product_id)
        this.$nextTick(() => {
          //* Vue performs DOM updates asynchronously */
          this.loadAsyncData()
        })

        this.selectedItems.forEach((item) => {
          let index = this.products.findIndex((product) => item.product_id == product.id)
          if (index >= 0) {
            this.products[index].item_quantity = item.quantity
            this.products[index].warranty_id = item.warranty_id
          }
        })
        
        //this.productsData.forEach(product => {})
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
          this.$EventBus.$emit('selected-order-items-event', this.selectedItems)
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
  