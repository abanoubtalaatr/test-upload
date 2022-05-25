<template>
  <div class="product">
    <div class="product-img">
      <nuxt-link :to="`${product.store.type == 'centers' ? localePath(`/services/${product.id}`) : localePath(`/products/${product.id}`)}`">
        <img :src="product.image" alt="">
      </nuxt-link>
        <div class="pro-sale sale-brown" v-if="product.discount"><span>{{product.discount}}%</span></div>
        <div class="pro-like" @click="toggleFav(product)">
          <i :class="`fas fa-heart ${product.is_favourite ? 'liked' : ''}`"></i>
        </div>
    </div>
    <div class="product-details">
      <div class="border-b">
        <nuxt-link :to="`${product.store.type == 'centers' ? localePath(`/services/${product.id}`) : localePath(`/products/${product.id}`)}`">
          <h4 class="dgrey">{{product.name}}</h4>
        </nuxt-link>
      </div>
      <div class="border-b">
        <div class="row">
          <div class="col-6">
            <h5 class="price">
              {{ product.store.type == 'stores' ? product.units[0].price_after_discount: Number(product.units[0].price)}}<span>{{$t('front.riyal')}}</span>
            </h5>
          </div>
          <div class="col-6 text-right" v-if="product.units[0].discount">
            <h6 class="sale">{{product.units[0].price_including_tax}}{{$t('front.riyal')}}</h6>
          </div>
        </div>
      </div>
      <div class="cart text-center">
        <button v-if="product.store.type == 'stores'" class="button btn-border full" @click="addToCart">
          <img src="~/assets/website/imgs/home/basket-g.svg" alt="">
          {{$t('front.add_to_cart')}}
        </button>

        <nuxt-link v-else :to="localePath(`/services/${product.id}/checkout`)"  class="green">
          <img src="~/assets/website/imgs/home/basket-g.svg" alt="">
          {{$t('front.request_service')}}
        </nuxt-link>
        </div>
    </div>
  </div>
</template>

<script src="./-index.js"></script>
<style scoped>
.product .product-img img{
  max-width: 285px;
  max-height: 169px;
}
</style>
