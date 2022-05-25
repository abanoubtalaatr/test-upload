import ReplyRequestOfferQuantityService from "../../../../services/ReplyRequestOfferQuantityService";

export default {
  layout: 'store',
  async created() {
    let filter = this.$route.query.filter != null && this.$route.query.filter != 'undefined' ? this.$route.query.filter : 'pending';
    this.filter.status = filter ;

    await this.$axios.$get(`store/request-offer-quantity/reply/list?filter=${filter}&is_paginated=1`)
      .then(response => {
        this.replies = response.data;
        this.meta = response.data.meta ?? 1;
        this.links = response.data.links ?? '';
      })
  },
  data() {
    return {
      queryParam: '',
      filter: {
        status: 'accepted_already',
      },
      replies: {},
      statuses: [
        {
          key: 'pending',
          by: 'pending',
          name: this.$t('admin.pending'),
          type: 'desc'
        },
        {
          key: 'finished',
          by: 'finished',
          name: this.$t('admin.finished'),
          type: 'desc'
        },
        {
          key: 'accepted',
          by: 'accepted',
          name: this.$t('admin.accepted_already'),
          type: 'desc'
        },
        {
          key: 'delivered',
          by: 'delivered',
          name: this.$t('admin.delivered'),
          type: 'desc'
        },
      ],
      meta: null,
      default_per_page: 10,
    }
  },
  methods: {
    changeSelect() {
      this.loadAsyncData()
    },

    handleQuery() {
      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1`

      if (this.filter.status != '') {
        this.queryParam = `${this.queryParam}&filter=${this.filter.status}`
      }

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
    async loadAsyncData() {
      this.$nuxt.$loading.start();
      this.queryParam = this.handleQuery();

      await ReplyRequestOfferQuantityService.getAll(this.queryParam)
        .then((response) => {
          this.replies = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.replies = []
        })
      this.$nuxt.$loading.finish();
    },
  },
  head() {
    return {
      title:  this.$t(`admin.request_offer_prices`)+'-'+this.$t(`admin.${this.filter.status}`) ,
    }
  },
}
