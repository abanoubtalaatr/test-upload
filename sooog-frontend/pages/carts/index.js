import CartService from "~/services/products/CartService.js"
import _ from 'lodash'

export default {
    middleware: ['auth'],
    async asyncData(context) {
        const response = await Promise.all([
            context.$axios.$get(`/cart`).catch(() => {
            }),
            context.$axios.$get(`/warranties`).catch(() => {
            }),
        ])
        return {
            carts: response[0]?.cart?.data || [],
            meta: response[0]?.cart?.meta || null,
            links: response[0]?.cart?.links || null,
            cartData: {
                subtotal: response[0]?.subtotal,
                warranties_total: response[0]?.warranties_total,
            },
            warranties: response[1]
        }
    },
    data() {
        return {
            titlePage: this.$t('front.cart'),
            updatedQty: 1,
            clicked: false,
            customEvents: [
                {eventName: 'handle-delete-cart', callback: this.handleDestroyCart},
            ]
        }
    },
    created() {
        this.handleWarranty()
        this.customEvents.forEach(function (customEvent) {
            // eslint-disable-next-line no-undef
            this.$EventBus.$on(customEvent.eventName, customEvent.callback)
        }.bind(this))
    },
    beforeDestroy() {
        this.customEvents.forEach(function (customEvent) {
            // eslint-disable-next-line no-undef
            this.$EventBus.$off(customEvent.eventName, customEvent.callback)
        }.bind(this))
    },
    methods: {
        handleWarranty() {
            // handle warranty in cart
            this.carts.forEach(element => {
                element.warranty_id = element.warranty ? element.warranty.id : ''
            })
        },
        increaseQty(key) {
            this.clicked = true;
            if (this.carts[key].quantity < 100) {
                // this.carts[key].quantity ++
                this.updateCart(this.carts[key], key, 'plus')
                this.clicked = false;
            }
            this.clicked = false;
        },
        maxValue(key) {
            let currentCart = this.carts[key];
            let max = currentCart.unit.quantity;
            if (max > currentCart.product.max_purchase_quantity) {
                max = currentCart.product.max_purchase_quantity;
            }
            console.log(max);
            return max;
        },
        decreaseQty(key) {
            this.clicked = true;
            if (this.carts[key].quantity > 1) {
                // this.carts[key].quantity --
                this.updateCart(this.carts[key], key, 'minus')
                this.clicked = false;
            }
            this.clicked = false;
        },
        async handleDestroyCart(id) {
            debugger
            await CartService.destroy({id})
                .then(() => {
                    this.loadAsyncData()
                    this.$toast.success(this.$t('admin.deleted_successfully'))
                })
                .catch(() => {
                })
        },
        async updateCart(cart, key, type = null) {
            this.$nuxt.$loading.start()
            // to reset error
            if (type == 'plus') {
                this.updatedQty = this.carts[key].quantity + 1
            } else if (type == 'minus') {
                this.updatedQty = this.carts[key].quantity - 1
            } else {
                this.updatedQty = cart.quantity
            }
            await CartService.update({
                id: cart.id,
                unit_id: cart.unit.id,
                quantity: this.updatedQty,
                warranty_id: cart.warranty_id
            })
                .then((response) => {
                    this.carts[key].quantity = response.cart.quantity
                    this.handleTotal(response)
                    this.$nuxt.$loading.finish()
                    this.$toast.success(this.$t('front.updated_successfully'))
                })
                .catch(() => {
                    this.$nuxt.$loading.finish()
                })

        },
        handleTotal(response) {
            this.cartData = {
                subtotal: response.subtotal,
                warranties_total: response.warranties_total,
            }
        },
        async loadAsyncData() {
            debugger
            this.$nuxt.$loading.start();

            this.queryParam = `?page=${this.meta.current_page}&is_paginated=1`

            await CartService.getAll(this.queryParam)
                .then((response) => {
                    this.carts = response.cart.data
                    this.handleWarranty()
                    this.handleTotal(response)
                    this.meta = response.cart.meta
                    this.links = response.cart.links
                })
                .catch(() => {
                    this.carts = []
                })
            this.$nuxt.$loading.finish();
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
    },
    head() {
        return {
            title: this.titlePage
        }
    }
}
