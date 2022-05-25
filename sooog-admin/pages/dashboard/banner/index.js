import BannerService from "./-service/-BannerService";
export default {
    async asyncData (context){
        try {
            let response = await context.$axios.$get("/admin/banners")
          // console.log(response);
            return {
                collection: response,
                meta: response.meta,
                links: response.links
            }
        } catch (e) {
            console.log(e)
        }
    },
    data () {
        return {
            titlePage: this.$t('admin.banners'),
            fieldsData: [
                {
                key: "id",
                label: this.$t('admin.ID')
                },
                {
                key: "created_at",
                label: this.$t('admin.created_at')
                },
                {
                key: "action",
                label: this.$t('admin.actions')
                }
            ],
            loading: false,
            // publicSearch: '',
            queryParam: '',
            customEvents: [
                // { eventName: 'handle-quick-search', callback: this.handleSearch },
                { eventName: 'event-delete-ad', callback: this.handleDelete }
            ]
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
        loadAsyncData () {
        this.$nuxt.$loading.start();
    
        this.queryParam = `?page=${this.meta.current_page}`
    
        BannerService.getAll(this.queryParam)
            .then((response) => {
            this.collection = response
    
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
            BannerService.destroy(id)
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
        BannerService.toggleStatus(id)
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
            return [this.$t('admin.banners')]
        }
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
