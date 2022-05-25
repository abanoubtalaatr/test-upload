import OrderService from "./-service/-OrderService";
import filterModal from '~/pages/dashboard/product-orders/-filter/-index.vue'
export default {
    components: {
        filterModal
      },
    async asyncData (context){
        let response = null
        if(context.query.customer_id){
            response = await context.$axios.$get(`/admin/orders?type=stores&is_paginated=1&customer=${context.query.customer_id}`).catch((e) => { console.log('err: ', e) })
        }else{
            response = await context.$axios.$get("/admin/orders?type=stores&is_paginated=1").catch((e) => { console.log('err: ', e) })
        }
            return {
            collection: response?.data,
            meta: response?.meta,
            links: response?.links
        }
    },
    data () {
        return {
            titlePage: this.$t('admin.orders'),
            orderBy: 'id',
            orderType: 'DESC',
            fieldsData: [
                {
                key: "id",
                label: this.$t('admin.ID'),
                sortable: true
                },
                {
                key: "user.name",
                label: this.$t('admin.user')
                },
                {
                    key: "user_address.city.name",
                    label: this.$t('admin.city')
                },
                {
                key: "total",
                label: this.$t('admin.total'),
                sortable: true
                },
                {
                    key: "payment_method.name",
                    label: this.$t('admin.payment_method')
                },
                {
                key: "status.name",
                label: this.$t('admin.status')
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
            loading: false,
            publicSearch: '',
            queryParam: '',
            status:null,
            customEvents: [
                { eventName: 'handle-quick-search', callback: this.handleSearch },
                { eventName: 'event-delete-order', callback: this.handleDelete },
                {eventName: 'order-filter-event', callback: this.doFilterOrders},
                { eventName: 'deactivate-item-event', callback: this.changeStatus }
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
      sortingChanged(ctx) {
        this.orderBy = ctx.sortBy
        this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
        this.loadAsyncData()
        // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
        // ctx.sortDesc ==> true if sorting descending, false otherwise
      },
        async doFilterOrders(search){
            console.log('searvh-filter', search)
            this.$nuxt.$loading.start();
            await OrderService.getAll(`?${search}`)
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
        handleSearch (search) {
            this.publicSearch = search
            this.onPageChange(1)
        },
        /*
        * Load async data
        */
        async loadAsyncData () {
        this.$nuxt.$loading.start();

        this.queryParam = `?type=stores&page=${this.meta.current_page}&is_paginated=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

        await OrderService.getAll(this.queryParam)
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
        resetFilter () {
            this.publicSearch = ''
            this.onPageChange(1)
        },
        /*
        * Handle page-change event
        */
        onPageChange (page) {
        this.meta.current_page = page
        this.loadAsyncData()
        },
        async handleDelete (id) {
        await OrderService.destroy(id)
            .then(() => {
            //* remove this row *//
            this.collection = this.collection.filter((obj) => {
                return obj.id !== id
            })
            this.$toast.success(this.$t('admin.deleted_successfully'))
            })
            .catch(() => {})
        },
        handleChangeStatus(item, status) {
            this.status = status
            if(status != 'rejected')
                this.changeStatus({id: item.id, reason: null})
            else
                this.deactivateModal(item.id)
        },
        changeStatus (item) {
            OrderService.changeStatus(item.id, {status: this.status, reason: item.reason})
                .then((response) => {
                //* update list *//
                let index = this.collection.findIndex((obj) => obj.id == item.id)
                console.log('index', index, response)
                if (index >= 0) {
                    this.$set(this.collection, index, response)
                }
                this.$toast.success(this.$t('admin.updated_successfully'))
                })
                .catch(() => {})
        },
        exportToExcel(){
            OrderService.excelExport(`?public_search=${this.publicSearch}`)
            .then(response => {
              this.forceFileDownload(response)
            })
          },
          forceFileDownload(response){
            const url = window.URL.createObjectURL(new Blob([response]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'orders.xlsx') //or any other extension
            document.body.appendChild(link)
            link.click()
          },
    },
    computed: {
        titleStack () {
            return [this.$t('admin.orders')]
        }
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
