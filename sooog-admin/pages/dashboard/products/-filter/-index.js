import ProductService from "~/pages/dashboard/products/-service/-ProductService";
import StoreService from '@/pages/dashboard/current-stores/-service/-StoreService'
import BrandService from "~/pages/dashboard/brands/-service/-BrandService";
import CategoryService from "~/pages/dashboard/categories/-service/-CategoryService";
import { mapValues } from "lodash"
import { mapState } from 'vuex'

export default {
    data () {
      return {
        modalId: 'ProductFilterModal',
        titlePage: this.$t('admin.filter'),
        stores: [],
        subcategories: [],
        categories: [],
        brands: [],
        form: {
          name: null,
          brand: '',
          category: '',
          sub_category: '',
          price_from: null,
          price_to: null,
          quantity_from: null,
          quantity_to: null,
          store: ''
        },
        queryParam: '',
        customEvents: [
          { eventName: 'open-product-filter-modal', callback: this.showModal },
          { eventName: 'close-product-filter-modal', callback: this.hideModal }
        ]
      }
    },
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
      async loadData() {
        debugger
        const response = await Promise.all([
          StoreService.getAll(`?status=accepted&type=stores`),
          CategoryService.getAll(`?type=stores`),
          BrandService.getAll(`?type=stores`)
        ])
        this.stores = response[0]
        this.categories = response[1]
        this.brands = response[2]
      },
      async changeCategory (value) {
        this.$nuxt.$loading.start()
        await ProductService.getSubCategories(value)
          .then((response) => {
            this.subcategories = response
          })
          .catch(() => {})
          this.$nuxt.$loading.finish()
      },
      showModal () {
          this.handleReset()
          this.$nextTick(() => {
            //* Vue performs DOM updates asynchronously */
            this.loadData()
          })

        this.$bvModal.show(this.modalId)
      },
      hideModal () {
        this.$bvModal.hide(this.modalId)
      },
      cancelModal () {
        this.hideModal()
      },
      handleReset () {
        this.form = mapValues(this.form, (item) => {
          if (item && (typeof item === 'object' || Array.isArray(item))) {
            return []
          }
          return null
        })
        this.subcategories = []
        this.$validator.reset()
      },
      submit () {
        this.$validator.validateAll().then(result => {
          if (!result) {
            return
          }
          this.$EventBus.$emit('product-filter-event', this.axiosParams)
          this.hideModal()
        });

      }

    },
    computed: {
        titleStack () {
          return ['']
        },
        ...mapState({
          currentLocale: state => state.localStorage.currentLocale,
        }),
        axiosParams() {
          const params = new URLSearchParams();
          params.append('category', this.form.category  || '');
          params.append('sub_category', this.form.sub_category || '');
          params.append('brand', this.form.brand || '');
          params.append('price_from', this.form.price_from || '');
          params.append('price_to', this.form.price_to || '');
          params.append('quantity_from', this.form.quantity_from || '');
          params.append('quantity_to', this.form.quantity_to || '');
          params.append('store', this.form.store || '');
          params.append('name', this.form.name || '')
          return params;
      }
    },

  }
