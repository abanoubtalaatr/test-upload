<template>
    <!-- Main Content-->
    <main class="main-content">
        <!--banner-->
        <section class="banner">
            <div id="banner-carousel">
                <VueSlickCarousel v-bind="adsSetting" v-if="ads.length">
                    <div class="caro-img" v-for="(item, key) in ads" :key="key">
                        <img :src="item.image" alt=""/>
                    </div>
                </VueSlickCarousel>
            </div>
        </section>
        <!--stores-->
        <section class="stores">
            <div class="container">
                <div class="h3 sub-head">
                    <span>{{ $t("front.most_famous_stores") }}</span>
                    <nuxt-link class="more" :to="localePath('stores')">{{
                        $t("front.more")
                        }}
                    </nuxt-link>
                </div>
                <div id="store-carousel">
                    <VueSlickCarousel v-bind="slides" v-if="stores.length">
                        <div class="col-4 col-md-3 col-lg-2" v-for="(store, key) in stores" :key="key">
                            <div class="store-wrap">
                                <div class="store-link">
                                <nuxt-link :to="{path: localePath('products'),query: { store: store.id },}">
                                    <!--<div class="store-img"><img :src="store.image"/></div>-->
                                    <!--<div class="store-wrap">-->
                                        <!--&lt;!&ndash; <img src="~/assets/website/imgs/home/panasonic@2x.png"> &ndash;&gt;-->
                                    <!--</div>-->
                                    {{ store.name }}
                                </nuxt-link>
                                </div>
                            </div>
                            <!--<div class="store-link">-->
                                <!--<nuxt-link-->
                                        <!--:to="{-->
                    <!--path: localePath('products'),-->
                    <!--query: { store: store.id },-->
                  <!--}"-->
                                <!--&gt;-->
                                    <!--{{ store.name }}-->
                                <!--</nuxt-link>-->
                            <!--</div>-->
                            <!--<div class="special" v-show="store.is_featured">-->
                                <!--<i class="fas fa-star"></i>-->
                            <!--</div>-->
                        </div>
                    </VueSlickCarousel>
                    <div v-else class="text-center alert-div">
                        {{ $t("front.no_results") }}
                    </div>
                </div>
            </div>
        </section>
        <!--center-->
        <!--<section class="centers">-->
        <!--<div class="container">-->
        <!--<div class="h3 sub-head">{{$t('front.most_famous_centers')}}-->
        <!--<nuxt-link class="more" :to="localePath('centers')">{{$t('front.more')}}</nuxt-link>-->
        <!--</div>-->
        <!--<div id="center-carousel">-->
        <!--<VueSlickCarousel v-bind="slides" v-if="centers.length">-->
        <!--<div class="center" v-for="(center, key) in centers" :key="key">-->
        <!--<nuxt-link :to="{ path: localePath('services'), query: { store: center.id } }">-->
        <!--<div class="center-img"><img :src="center.image"></div>-->
        <!--</nuxt-link>-->
        <!--<div class="store-link">-->
        <!--<nuxt-link :to="{ path: localePath('services'), query: { store: center.id } }">-->
        <!--{{center.name}}-->
        <!--</nuxt-link>-->
        <!--</div>-->
        <!--<div class="special" v-show="center.is_featured">-->
        <!--<i class="fas fa-star"></i>-->
        <!--</div>-->
        <!--</div>-->
        <!--</VueSlickCarousel>-->
        <!--<div v-else class="text-center alert-div">-->
        <!--{{$t('front.no_results')}}-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</section>-->
        <!--offers-->
        <section class="products padd-t-60" v-if="offers.length">
            <div class="container">
                <div class="h3 sub-head">
                    <span>{{ $t("front.offers") }}</span>
                    <nuxt-link class="more" :to="localePath('offers')">{{
                        $t("front.more")
                        }}
                    </nuxt-link>
                </div>
                <div id="product-carousel">
                    <VueSlickCarousel v-bind="productSlides">
                        <productBlock
                                v-for="(product, key) in offers"
                                :key="key"
                                :product="product"
                        />
                    </VueSlickCarousel>
                </div>
            </div>
        </section>
        <!--products-->
        <section class="products padd-t-60">
            <div class="container">
                <div class="h3 sub-head">
                    <span>{{ $t("front.most_selling_products") }}</span>
                    <nuxt-link class="more" :to="localePath('products')">{{
                        $t("front.more")
                        }}
                    </nuxt-link>
                </div>
                <div id="product-carousel">
                    <VueSlickCarousel v-bind="productSlides" v-if="products.length">
                        <productBlock
                                v-for="(product, key) in products"
                                :key="key"
                                :product="product"
                        />
                    </VueSlickCarousel>
                    <div v-else class="text-center alert-div">
                        {{ $t("front.no_results") }}
                    </div>
                </div>
            </div>
        </section>
        <!--ad-->
        <section class="ad custom-padd">
            <div class="container">
                <a href="#" v-for="banner in banners" :key="banner.id">
                    <div class="ad-wrap">
                        <img :src="banner.image" alt=""/>
                    </div>
                </a>
            </div>
        </section>
        <!--brands-->
        <section class="most-popular">
            <div class="container">
                <div class="h3 center-head">
                    <span>{{ $t("front.most_famous_brands") }}</span>
                </div>
                <div class="most-wrap">
                <div id="brands-carousel">
                    <VueSlickCarousel v-bind="brandSlides" v-if="brands.length">
                        <div class="brand-item" v-for="(item, key) in brands" :key="key">
                            <nuxt-link :to="{ path: localePath('products'), query: { brand: item.id } }">
                                <img width="105" height="35" :src="item.image" alt="">
                            </nuxt-link>
                        </div>
                </VueSlickCarousel>
            </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End Main Content-->
</template>

<script>
    // https://gs-shop.github.io/vue-slick-carousel/#/example/simple
    import VueSlickCarousel from "vue-slick-carousel";
    import "vue-slick-carousel/dist/vue-slick-carousel.css";
    import productBlock from "~/pages/products/-product/-index.vue";

    export default {
        components: {
            VueSlickCarousel,
            productBlock,
        },
        async asyncData(context) {
            const response = await Promise.all([
                context.$axios.$get(`/slides`).catch(() => {
                }),
                context.$axios.$get(`/brands?is_paginated=1&per_page=6`).catch(() => {
                }),
                context.$axios
                    .$get(`/stores?type=stores&is_paginated=1&per_page=12`)
                    .catch(() => {
                    }),
                context.$axios
                    .$get(`/stores?type=centers&is_paginated=1&per_page=12`)
                    .catch(() => {
                    }),
                context.$axios
                    .$get(`/products/most-selling?type=stores&is_paginated=1&per_page=12`)
                    .catch(() => {
                    }),
                context.$axios.$get(`/offers?is_paginated=1&per_page=12`).catch(() => {
                }),
                context.$axios.$get(`/banners`).catch(() => {
                }),
            ]);
            return {
                ads: response[0],
                brands: response[1].data,
                stores: response[2].data,
                centers: response[3].data,
                products: response[4].data,
                offers: response[5].data,
                banners: response[6],
            };
        },
        data() {
            return {
                titlePage: this.$t("front.home"),
                adsSetting: {
                    dots: true,
                    rtl: true,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    initialSlide: 1,
                    speed: 1000,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            infinite: true,
                            dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        }
                    ]
                },
                brandSlides:{
                    infinite: true,
                    autoplay: false,
                    slidesToShow: 5,
                    speed: 1000,
                    rows: 1,
                    arrows: true,
                    slidesPerRow: 1,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            infinite: true,
                            dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        }
                        ]
                },
                slides: {
                    dots: true,
                    rtl: true,
                    infinite: true,
                    autoplay: true,
                    "focusOnSelect": false,
                    autoplaySpeed: 3000,
                    initialSlide: 6,
                    speed: 1000,
                    slidesToShow: 6,
                    slidesToScroll: 2,
                    "adaptiveHeight": true,
                    "touchThreshold": 6,
                    "dotsClass": "slick-dots custom-dot-class",
                    "responsive": [
                        {
                            "breakpoint": 1024,
                            "settings": {
                                "slidesToShow": 3,
                                "slidesToScroll": 3,
                                "infinite": true,
                                "dots": true
                            }
                        },
                        {
                            "breakpoint": 600,
                            "settings": {
                                "slidesToShow": 1,
                                "slidesToScroll": 1,
                                "initialSlide": 1
                            }
                        },
                        {
                            "breakpoint": 480,
                            "settings": {
                                "slidesToShow": 1,
                                "slidesToScroll": 1
                            }
                        }
                    ]

                    // "edgeFriction": 0.35,
                    // "centerMode": true,
                    // "swipeToSlide": true
                },
                productSlides: {
                    dots: true,
                    rtl: true,
                    infinite: true,
                    autoplay: true,
                    focusOnSelect: false,
                    autoplaySpeed: 3000,
                    initialSlide: 4,
                    speed: 1000,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    touchThreshold: 5,
                    adaptiveHeight: true,
                    // "centerMode": true,
                    swipeToSlide: true,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            infinite: true,
                            dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                            }
                        }
                    ]
                }
            };
        },
        methods: {
        },
        head() {
            return {
                title: this.titlePage,
            };
        },
    };
</script>
