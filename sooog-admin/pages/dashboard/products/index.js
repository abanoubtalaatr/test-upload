import ProductService from "./-service/-ProductService";
import FilterModal from '~/pages/dashboard/products/-filter/-index.vue'

export default {
    components: {
        FilterModal
    },
    async asyncData (context){
        try {
            let response = await context.$axios.$get("/admin/products?type=stores&is_paginated=1&is_detailed=1")
            return {
                collection: response.data,
                meta: response.meta,
                links: response.links
            }
        } catch (e) {
            console.log(e)
        }
    },
    data () {
        //`price`, `category_id`, `store_id`, `image`,`preview_fees`, `is_active`, `deactivation_start_date`, `deactivation_end_date`
        return {
            titlePage: this.$t('admin.products'),
            orderBy: 'id',
            orderType: 'DESC',
            fieldsData: [
                {
                key: "id",
                label: this.$t('admin.ID'),
                sortable: true
                },
                {
                key: "name",
                label: this.$t('admin.name'),
                sortable: true
                },
                {
                    key: "store.name",
                    label: this.$t('admin.store')
                },
                // {
                //     key: "price",
                //     label: this.$t('admin.price'),
                //     sortable: true
                // },
                {
                key: "is_active",
                label: this.$t('admin.status'),
                sortable: true
                },
                {
                key: "created_at",
                label: this.$t('admin.created_at'),
                sortable: true
                },
                {
                key: "action",
                label: this.$t('admin.actions')
                }
            ],
            filterParams: null,
            loading: false,
            publicSearch: '',
            queryParam: '',
            customEvents: [
                { eventName: 'handle-quick-search', callback: this.handleSearch },
                { eventName: 'event-delete-product', callback: this.handleDelete },
                { eventName: 'product-filter-event', callback: this.handleFilter }
            ],
            permissions: this.$cookies.get('permissions')
        }
    },
    mounted () {
        this.$EventBus.$emit('enable-quick-search', true)
    },
    created () {
        this.customEvents.forEach(function (customEvent) {
            // eslint-disable-next-line no-undef
            this.$EventBus.$on(customEvent.eventName, customEvent.callback)
          }.bind(this))
    },
    beforeDestroy (){
        this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
            this.$EventBus.$off(customEvent.eventName, customEvent.callback)
            }.bind(this))
    },
    methods: {
        handleSearch (search) {
            this.publicSearch = search
            this.onPageChange(1)
        },
        openFilter () {
          this.$EventBus.$emit('open-product-filter-modal')
        },
        handleFilter (data) {
          debugger
          this.filterParams = data
          this.loadAsyncData()
        },
        resetFilter () {
          this.filterParams = null
          this.onPageChange(1)
        },
        sortingChanged(ctx) {
          this.orderBy = ctx.sortBy
          this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
          this.loadAsyncData()
          // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
          // ctx.sortDesc ==> true if sorting descending, false otherwise
        },
        /*
        * Load async data
        */
        loadAsyncData () {
        this.$nuxt.$loading.start();

        this.queryParam = `?page=${this.meta.current_page}&type=stores&is_paginated=1&is_detailed=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

        if (this.filterParams) {
          this.queryParam = `${this.queryParam}&${this.filterParams}`
        }
        debugger
        ProductService.getAll(this.queryParam)
            .then((response) => {
            this.collection = response.data

            this.meta = response.meta
            this.links = response.links
            })
            .catch(() => {
            this.collection = []
            })
            this.$nuxt.$loading.finish();
        },
        /*
        * Handle page-change event
        */
        onPageChange (page) {
        this.meta.current_page = page
        this.loadAsyncData()
        },
        handleDelete (id) {
            ProductService.destroy(id)
            .then(() => {
            //* remove this row *//
            this.collection = this.collection.filter((obj) => {
                return obj.id !== id
            })
            this.$toast.success(this.$t('admin.deleted_successfully'))
            })
            .catch(() => {})
        },
        handleToggleStatus (id) {
        ProductService.toggleStatus(id)
            .then((response) => {
            //* update list *//
            let index = this.collection.findIndex((obj) => obj.id == id)
            if (index >= 0) {
                this.$set(this.collection, index, response)
            }
            this.$toast.success(this.$t('admin.updated_successfully'))
            })
            .catch(() => {})
        }
    },
    computed: {
        titleStack () {
            return [this.$t('admin.products')]
        }
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
