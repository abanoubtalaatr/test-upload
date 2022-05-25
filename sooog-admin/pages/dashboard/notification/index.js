import NotificationService from "./-service/-NotificationService";
export default {
    async asyncData (context){
        //let response = await BrandService.getAll()
        let response = await context.$axios.$get("/admin/notifications?type=send").catch((e) => { console.log('err: ', e) })
        console.log('async-resp: ', response)
        return {
            collection: response.data,
            meta: response.meta,
            links: response.links
        } 
    },
    data () {
        return {
            titlePage: this.$t('admin.notifications'),
            fieldsData: [
                {
                key: "id",
                label: this.$t('admin.ID')
                },
                {
                key: "data."+this.$i18n.locale+".title",
                label: this.$t('admin.title')
                },
                {
                key: "data."+this.$i18n.locale+".body",
                label: this.$t('admin.content')
                },
              // {
              //   key: this.dataLocalized('title'),
              //   label: this.$t('admin.title')
              //   },
              //   {
              //   key: this.dataLocalized('body'),
              //   label: this.$t('admin.content')
              //   },
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
            publicSearch: '',
            queryParam: '',
            customEvents: [
                { eventName: 'handle-quick-search', callback: this.handleSearch },
                { eventName: 'event-delete-brand', callback: this.handleDelete }
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
      // dataLocalized(item){
      //   if(this.currentLocale=='en'){
      //     return "data.en"+item
      //   }else{
      //     return "data.ar"+item
      //   }
      // },
        /*
        * Load async data
        */
        async loadAsyncData () {
        this.$nuxt.$loading.start();
    
        this.queryParam = `?type=send&page=${this.meta.current_page}&is_paginated=1&public_search=${this.publicSearch}`
    
        await NotificationService.getAll(this.queryParam)
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
        async handleDelete (id) {
        await NotificationService.destroy(id)
            .then(() => {
            //* remove this row *//
            this.collection = this.collection.filter((obj) => {
                return obj.id !== id
            })
            this.$toast.success(this.$t('admin.deleted_successfully'))
            })
            .catch(() => {})
        },
    },
    computed: {
        titleStack () {
            return [this.$t('admin.notifications')]
        },
      // ...mapState({
      //   currentLocale: state => state.localStorage.currentLocale
      // }),
    },
    head () {
        return {
            title: this.titlePage
        }
    }
}
