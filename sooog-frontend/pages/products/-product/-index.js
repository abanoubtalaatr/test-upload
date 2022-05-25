import FavouriteService from "~/services/products/FavouriteService.js"
import { mapState } from 'vuex'
import CartService from "~/services/products/CartService.js"

export default {
  props: {
    product: {
      required: true
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  data() {
    return {

    }
  },
  methods: {
    async toggleFav (product) {

      if (this.authUser) {
        if (!product.is_favourite) {
          this.create(product)
        } else {
          this.destroyFav(product)
        }
      } else {
        this.$toast.error(this.$t('front.fav_unauthenticated'))
      }
    },
    async destroyFav (product) {
      await FavouriteService.destroy({ product_id: product.id })
        .then(() => {
          this.product.is_favourite = false
          this.$toast.success(this.$t('front.deleted_successfully'))
          //* fire event to remove it from favourites */
          this.$EventBus.$emit('remove-fav-product', product.id)
        })
        .catch((err) => console.log(err))
    },
    async create (product) {
      await FavouriteService.create({ product_id: product.id })
        .then(() => {
          this.product.is_favourite = true
          this.$toast.success(this.$t('front.added_successfully'))
        })
        .catch((err) => console.log(err))
    },
    async addToCart () {
      if (this.authUser) {
        this.$nuxt.$loading.start()
        await CartService.create({...{quantity: 1}, ...{
          product_id: this.product.id
        },...{unit_id:this.product.units[0].id}})
          .then(() => {
            this.$toast.success(this.$t('front.added_successfully'))
            this.$nuxt.$loading.finish()
          })
          .catch(() => this.$nuxt.$loading.finish())
      } else {
        this.$toast.error(this.$t('front.cart_unauthenticated'))
      }
    },
  },
}
