import ProductService from "~/pages/dashboard/products/-service/-ProductService";
import StoreService from '@/pages/dashboard/current-stores/-service/-StoreService'
import BrandService from "~/pages/dashboard/brands/-service/-BrandService";
import CategoryService from "~/pages/dashboard/categories/-service/-CategoryService";
import { mapValues } from "lodash"
import { mapState } from 'vuex'

export default {
    data () {
      return {
        modalId: 'ServiceFilterModal',
        titlePage: this.$t('admin.filter'),
        stores: [],
        categories: [],
        form: {
          name: null,
          category: '',
          store: '',
          price_from: null,
          price_to: null,
          preview_fees: null
        },
        queryParam: '',
        customEvents: [
          { eventName: 'open-service-filter-modal', callback: this.showModal },
          { eventName: 'close-service-filter-modal', callback: this.hideModal }
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
          StoreService.getAll(`?status=accepted&type=centers`),
          CategoryService.getAll(`?type=centers`),
        ])
        this.stores = response[0]
        this.categories = response[1]
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
        this.$validator.reset()
      },
      submit () {
        this.$validator.validateAll().then(result => {
          if (!result) {
            return
          }
          this.$EventBus.$emit('service-filter-event', this.axiosParams)
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
          params.append('preview_fees', this.form.preview_fees || '');
          params.append('price_from', this.form.price_from || '');
          params.append('price_to', this.form.price_to || '');
          params.append('store', this.form.store || '');
          params.append('name', this.form.name || '')
          return params;
      }
    },

  }
