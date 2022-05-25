import RatingService from "./-service/-RatingService";
export default {
    async asyncData (context){
        try {
            let response = await context.$axios.$get("/admin/ratings?is_paginated=1")
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
        return {
            titlePage: this.$t('admin.ratings'),
            orderBy: 'created_at',
            orderType: 'DESC',
            fieldsData: [
                {
                key: "rate",
                label: this.$t('admin.rate'),
                sortable: true
                },
                {
                key: "comment",
                label: this.$t('admin.comment'),
                sortable: true
                },
                {
                    key: "user.name",
                    label: this.$t('admin.user')
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
                { eventName: 'handle-quick-search', callback: this.handleSearch }
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

        this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&is_detailed=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

        RatingService.getAll(this.queryParam)
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
        handleToggleStatus (id) {
        RatingService.toggleStatus(id)
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
            return [this.$t('admin.ratings')]
        }
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
