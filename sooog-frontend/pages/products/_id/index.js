
import CartService from "~/services/products/CartService.js"
import RatingService from "~/services/products/RatingService.js"
import productBlock from '~/pages/products/-product/-index.vue'
import FavouriteService from "~/services/products/FavouriteService.js"
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css"
import { mapState } from "vuex"
import { Hooper, Slide, Navigation as HooperNavigation } from "hooper";
import "hooper/dist/hooper.css";

export default {
  scrollToTop: true,
  validate({ params, query, store }) {
    if (params.id) {
      return !isNaN(params.id);
    }
    return true;
  },
  components: {
    productBlock,
    VueSlickCarousel,
    Hooper,
    Slide,
    HooperNavigation
  },
  async asyncData (context) {
    const response = await Promise.all([
      context.$axios.$get(`/products/${context.params.id}`).catch(() => {})
    ])
    return {
      product: response[0],
      units: response[0].units,
      cart: {quantity: 1},
      unit_id:response[0].units[0].id
    }
  },
  async fetch () {
    const response = await Promise.all([
      this.$axios.$get(`/products?is_paginated=1&type=stores&per_page=12&category=${this.product.category.id}`).catch(() => {}),
      this.$axios.$get(`/products/${this.product.id}/ratings`).catch(() => {})
    ])
    this.products = response[0].data.filter((item) => item.id != this.product.id)
    this.ratings = response[1].data
    this.meta = response[1].meta

    this.default_per_page = this.meta.per_page
  },
  fetchOnServer: true,
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      settings: state => state.localStorage.settings,
    }),
    canRate() {
      if (this.settings) {
        if (this.settings.can_rate) {
          // check on rated before
          if (!this.product.is_rated) {
            return true
          }
        }
       }
      return false
    },
    enableLoadMore() {
      if (this.meta) {
        return this.meta.total > this.meta.per_page;
      }
    },
    totalRate() {
      // parse to integer
      return parseInt(this.product.rate);
    },
    urlLink () {
      let link = ''
      if (process.client) {
        link = `${window.location.origin}${this.$route.path}`
        // debugger
      }
      return link
      // return `http://localhost:3000/products/${this.product.id}`
    },
  },
  data() {
    return {
      param_id: this.$route.params.id,
      titlePage: this.$t('front.product'),
      productSlides: {
        dots: true,
        rtl: true,
        infinite: true,
        autoplay: true,
        "focusOnSelect": false,
        autoplaySpeed: 3000,
        initialSlide: 4,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        "touchThreshold": 5,
        "adaptiveHeight": true,
        // "centerMode": true,
        "swipeToSlide": true
      },
      slides: {
        dots: true,
        rtl: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        initialSlide: 1,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
      },
      products: [],
      meta: null,
      ratings: [],
      default_per_page: 10,
      form: {
        rate: 0,
        comment: ''
      },
      // cart: {
      //   quantity: this.product?.quantity || 1 // initial value
      // }
    }
  },
  methods: {
    async loadMoreRatings() {
      await RatingService.getAll(
        this.param_id,
        `?page=${this.meta.current_page}&per_page=${
          Number(this.default_per_page) + Number(this.meta.per_page)
        }`
      ).then((response) => {
        this.ratings = response.data;
        this.meta = response.meta;
      })
      .catch(() => {})
    },
    async create() {
      const validData = await this.$validator.validateAll()

      if (validData) {
        await RatingService.create({...this.form, ...{product_id: this.param_id}})
        .then(() => {
          this.product.is_rated = true
          this.$toast.success(this.$t('front.added_rate_successfully'))
        })
        .catch(() => {})
      }
    },
    increaseQty () {
      debugger
        var unit=this.units.find(item=> item.id==this.unit_id);
      if (unit.quantity >= (this.cart.quantity + 1)) {
        this.cart.quantity ++
      }
    },
    decreaseQty () {
      if (this.cart.quantity > 1) {
        this.cart.quantity --
      }
    },
    async addToCart () {
      if (this.authUser) {
        this.$nuxt.$loading.start()
        await CartService.create({...this.cart, ...{
          product_id: this.product.id
        },...{unit_id:this.unit_id}})
          .then(() => {
            this.$toast.success(this.$t('front.added_successfully'))
            this.$nuxt.$loading.finish()
          })
          .catch(() => this.$nuxt.$loading.finish())
      } else {
        this.$toast.error(this.$t('front.cart_unauthenticated'))
      }
    },
    async switchFav () {

      if (this.authUser) {
        if (!this.product.is_favourite) {
          this.addFav()
        } else {
          this.destroyFav()
        }
      } else {
        this.$toast.error(this.$t('front.fav_unauthenticated'))
      }
    },
    async destroyFav () {
      this.$nuxt.$loading.start()
      await FavouriteService.destroy({ product_id: this.product.id })
        .then(() => {
          this.product.is_favourite = false
          this.$toast.success(this.$t('front.deleted_successfully'))
          //* fire event to remove it from favourites */
          this.$EventBus.$emit('remove-fav-product', this.product.id)
          this.$nuxt.$loading.finish()
        })
        .catch(() => this.$nuxt.$loading.finish())
    },
    async addFav () {
      this.$nuxt.$loading.start()
      await FavouriteService.create({ product_id: this.product.id })
        .then(() => {
          this.product.is_favourite = true
          this.$toast.success(this.$t('front.added_successfully'))
          this.$nuxt.$loading.finish()
        })
        .catch(() => this.$nuxt.$loading.finish())
    }
  },
  head() {
    return {
      title: this.titlePage,
      script: [
        // { src: require('~/assets/front/js/ninja-slider.js'), mode: 'client' },
      ],
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1" },
        {
          hid: "description",
          name: "description",
          content: this.product.description,
        },
        { name: "og:image", content: this.product.image },
        {
          name: "twitter:image",
          content: this.product.image,
        },
      ],
      link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }],
    };
  },
}
