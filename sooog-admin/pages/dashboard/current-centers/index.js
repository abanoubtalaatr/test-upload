import StoreService from '~/pages/dashboard/current-stores/-service/-StoreService';
export default {
    async asyncData (context){
        let response = await context.$axios.$get("/admin/stores?is_paginated=1&type=centers&status=accepted").catch((e) => { console.log('err: ', e) })
        return {
            collection: response.data,
            meta: response.meta,
            links: response.links
        }
    },
    data () {
        return {
            titlePage: this.$t('admin.current_centers'),
            orderBy: 'is_featured',
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
                    key: "email",
                    label: this.$t('admin.email'),
                    sortable: true
                },
                {
                    key: "phone",
                    label: this.$t('admin.phone'),
                    sortable: true
                },
                {
                    key: "is_featured",
                    label: this.$t('admin.is_featured'),
                    sortable: true
                },
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
            loading: false,
            publicSearch: '',
            queryParam: '',
            customEvents: [
                { eventName: 'handle-quick-search', callback: this.handleSearch },
                { eventName: 'deactivate-item-event', callback: this.toggleStatus }
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
        /*
        * Load async data
        */
        async loadAsyncData () {
        this.$nuxt.$loading.start();

        this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&status=accepted&type=centers&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

        await StoreService.getAll(this.queryParam)
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
        sortingChanged(ctx) {
          this.orderBy = ctx.sortBy
          this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
          this.loadAsyncData()
          // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
          // ctx.sortDesc ==> true if sorting descending, false otherwise
        },
        /*
        * Handle page-change event
        */
        onPageChange (page) {
        this.meta.current_page = page
        this.loadAsyncData()
        },
        handleToggleStatus(item) {
            if(!item.is_active)
                this.toggleStatus({id: item.id, reason: ''})
            else
                this.deactivateModal(item.id)
        },
        toggleStatus (item) {
            StoreService.toggleStatus(item.id, {deactivation_reason: item.reason})
                .then((response) => {
                //* update list *//
                let index = this.collection.findIndex((obj) => obj.id == item.id)
                if (index >= 0) {
                    this.$set(this.collection, index, response)
                }
                this.$toast.success(this.$t('admin.updated_successfully'))
                })
        },
        exportToExcel(){
            StoreService.excelExport(`?type=centers&status=accepted&public_search=${this.publicSearch}`)
            .then(response => {
              this.forceFileDownload(response)
            })
          },
          forceFileDownload(response){
            const url = window.URL.createObjectURL(new Blob([response]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', 'current_centers.xlsx') //or any other extension
            document.body.appendChild(link)
            link.click()
          },
    },
    computed: {
        titleStack () {
            return [this.$t('admin.current_centers')]
        }
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
