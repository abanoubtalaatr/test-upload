
import ProductService from "~/services/products/ProductService.js"
import productBlock from '~/pages/products/-product/-index.vue'
import _ from 'lodash'

export default {
  components: {
    productBlock
  },
  async asyncData (context) {
    let queryParam = `?type=stores&is_paginated=1`
    if (context.query.search) {
      queryParam = `${queryParam}&publicSearch=${context.query.search}`
    } else if (context.query.store){
      queryParam = `${queryParam}&store=${context.query.store}`
    }else if (context.query.category){
      queryParam = `${queryParam}&category=${context.query.category}`
    }else if (context.query.brand){
      queryParam = `${queryParam}&brand=${context.query.brand}`
    }

    const response = await Promise.all([
      context.$axios.$get(`/brands`).catch(() => {}),
      context.$axios.$get(`/categories?type=stores`).catch(() => {}),
      context.$axios.$get(`/products${queryParam}`).catch(() => {}),
    ])

    return {
      brands: response[0],
      categories: response[1],
      products: response[2] ? response[2].data : [],
      meta: response[2] ? response[2].meta : {},
      links: response[2] ? response[2].links : {}
    }
  },
  data() {
    return {
      titlePage: this.$t('front.products'),
      queryParam: '',
      filter: {
        price_from: 0,
        price_to: 20000,
        category: this.$route.query.category || '',
        brand: this.$route.query.brand || '',
        orderBy: '',
        orderType: '',
        selectedOrder: ''
      },
      sorting: [
        {
          key: 'price_desc',
          by: 'price',
          name: this.$t('front.price_desc'),
          type: 'desc'
        },
        {
          key: 'price_asc',
          by: 'price',
          name: this.$t('front.price_asc'),
          type: 'asc'
        },
        {
          key: 'most_selling',
          by: 'most_selling',
          name: this.$t('front.most_selling'),
          type: 'desc'
        },
        {
          key: 'most_rating',
          by: 'most_rated',
          name: this.$t('front.most_rating'),
          type: 'desc'
        },
        {
          key: 'added_recently',
          by: 'created_at',
          name: this.$t('front.added_recently'),
          type: 'desc'
        },
      ]
    }
  },
  created() {
    this.debouncedPrice = _.debounce(this.changeSelect, 1000)

    // if (this.products.length)

    //   this.filter.price_to = this.products.reduce((prev, curr) => prev.price_after_discount < curr.price_after_discount ? prev.price_after_discount : curr.price_after_discount)
  },
  methods: {
    changeSelect () {
      this.loadAsyncData()
    },
    changeSort (event) {
      let sort = this.sorting.find((order) => order.key == event.target.value)
      if (sort) {
        this.filter.orderBy = sort.by
        this.filter.orderType = sort.type
      }
      this.loadAsyncData()
    },
    handleQuery () {
      this.queryParam = `?page=${this.meta.current_page}&type=stores&is_paginated=1`

      if (this.filter.price_from != '') {
        this.queryParam = `${this.queryParam}&price_from=${this.filter.price_from}`
      }
      if (this.filter.price_to != '') {
        this.queryParam = `${this.queryParam}&price_to=${this.filter.price_to}`
      }
      if (this.filter.brand != '') {
        this.queryParam = `${this.queryParam}&brand=${this.filter.brand}`
      }
      if (this.filter.category != '') {
        this.queryParam = `${this.queryParam}&category=${this.filter.category}`
      }
      if (this.$route.query.search) {
        this.queryParam = `${this.queryParam}&public_search=${this.$route.query.search}`
      }
      if (this.$route.query.store) {
        this.queryParam = `${this.queryParam}&store=${this.$route.query.store}`
      }
      if (this.filter.orderBy != '') {
        this.queryParam = `${this.queryParam}&orderBy=${this.filter.orderBy}`
      }
      if (this.filter.orderType != '') {
        this.queryParam = `${this.queryParam}&orderType=${this.filter.orderType}`
      }

      return this.queryParam
    },
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = this.handleQuery()

      await ProductService.getAll(this.queryParam)
        .then((response) => {
          this.products = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.products = []
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
    prevPage() {
      if (this.links.prev_page_url) {
        this.onPageChange(this.meta.current_page - 1)
      }
    },
    nextPage() {
      if (this.links.next_page_url) {
        this.onPageChange(this.meta.current_page + 1)
      }
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  },
  watch: {
    // '$route.query': '$fetch'
    '$route.query': function (val, oldVal) {
      debugger
      if (val.search) {
        this.loadAsyncData()
      }
    },
    deep: true
  }
}
