import {mapState} from "vuex";
import RequestOfferQuantityService from "../../../services/RequestOfferQuantityService";

export default {
  layout: 'store',
  async asyncData(context) {
    const response = await Promise.all([
      context.$axios.$get(`store/request-offer-quantity?is_paginated=1`).catch(() => {
      }),
    ])
    return {
      requestOfferQuantities: response[0]?.data || [],
      meta: response[0]?.meta,
      links: response[0]?.links
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.request_offer_quantities'),
      queryParam: '',
      filter: {
        product_name: '',
        status: '',
        category: '',
        orderBy: '',
        orderType: '',
        selectedOrder: ''
      },
      requestOfferQuantities :{},
      statuses: [
        {
          key: '',
          by: 'category_id',
          name: this.$t('front.category'),
          type: 'desc'
        },
        {
          key: 'status',
          by: 'status',
          name: this.$t('front.status'),
          type: 'desc'
        },
        {
          key: 'product',
          by: 'product_name',
          name: this.$t('front.product_name'),
          type: 'desc'
        },
      ],
      meta: null,
      default_per_page: 10,
      item :{
        url : 'store/request-offer-quantity/export-to-excel',
        label : 'download'
      }
    }
  },
  methods: {
    changeSelect() {
      this.loadAsyncData()
    },
    changeSort(event) {
      let sort = this.sorting.find((order) => order.key == event.target.value)
      if (sort) {
        this.filter.orderBy = sort.by
        this.filter.orderType = sort.type
      }
      this.loadAsyncData()
    },

    handleQuery() {
      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1`

      if (this.filter.product_name != '') {
        this.queryParam = `${this.queryParam}&filter=${this.filter.status}`
      }

      if (this.filter.orderBy != '') {
        this.queryParam = `${this.queryParam}&orderBy=${this.filter.orderBy}`
      }
      if (this.filter.orderType != '') {
        this.queryParam = `${this.queryParam}&orderType=${this.filter.orderType}`
      }
      console.log(this.queryParam);
      return this.queryParam
    },
    /*
    * Handle page-change event
    */
    onPageChange(page) {
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
    async loadAsyncData () {
      this.$nuxt.$loading.start();
      this.queryParam = this.handleQuery();

      await RequestOfferQuantityService.getAll(this.queryParam)
        .then((response) => {
          this.requestOfferQuantities = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.requestOfferQuantities = []
        })
      this.$nuxt.$loading.finish();
    },
  },
  head() {
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
