<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--map-->
      <div class="custom-padd">
        <div class="container">
          <ul class="map">
            <li><nuxt-link :to="localePath('index')">{{$t('front.home')}}</nuxt-link></li>
            <li>
              <nuxt-link :to="{ path: localePath('services'), query: { category: product.category.id } }">
                {{product.category.name}}
              </nuxt-link>
            </li>
            <li>
              <a href="#">{{product.name}}</a>
            </li>
          </ul>
        </div>
      </div>
      <!--product-det-->
      <section class="product-det">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <img :src="product.image" alt="">
              <!-- <div class="carousel slide" id="product-car" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></div>
                  <div class="carousel-item"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></div>
                  <div class="carousel-item"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></div>
                </div>
                <ul class="carousel-indicators">
                  <li class="d-flex justify-content-center active" data-target="#product-car" data-slide-to="0"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></li>
                  <li class="d-flex justify-content-center" data-target="#product-car" data-slide-to="1"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></li>
                  <li class="d-flex justify-content-center" data-target="#product-car" data-slide-to="2"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></li>
                </ul>
              </div> -->
            </div>
            <div class="col-md-6">
              <div class="product-info">
                <nuxt-link class="blue" :to="{ path: localePath('services'), query: { store: product.store.id } }">
                  {{product.store.name}}
                </nuxt-link>
                <h3>{{product.name}}</h3>
                <div class="rate">
                  <i
                    v-for="idx in totalRate"
                    :key="`incre${idx}`"
                    class="fas fa-star rated"
                  ></i>
                  <i
                    v-for="idx in 5 - totalRate"
                    :key="`decre${idx}`"
                    class="fas fa-star"
                  ></i>
                  <span class="yellow">{{product.rate}}</span>
                </div>
                <p class="grey">
                  {{product.description}}
                </p>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td class="grey col-6"><span class="grey">{{$t('front.price_start_from')}}</span></td>
                        <td class="col-6 text-right">
                          <div class="h5 price">
                            <div class="b">{{Number(product.price)}}</div>
                            <span class="grey">{{$t('front.riyal')}}</span>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="grey col-6"><span class="grey">{{$t('front.preview_fees')}}</span></td>
                        <td class="col-6 text-right">
                          <div class="h5 price">
                            <div class="b">{{Number(product.preview_fees)}}</div>
                            <span class="grey">{{$t('front.riyal')}}</span>
                          </div>
                        </td>
                      </tr>
                      <!-- <tr>
                        <td class="grey col-6"><span class="blue">{{$t('front.total')}}</span></td>
                        <td class="col-6 text-right">
                          <div class="h5 price">
                            <div class="blue">{{totalValue}}</div>
                            <span class="grey">{{$t('front.riyal')}}</span>
                          </div>
                        </td>
                      </tr> -->
                    </tbody>
                  </table>
                </div>
                <div class="mr-15">
                  <nuxt-link :to="localePath(`/services/${product.id}/checkout`)"
                    class="serv-info button full btn-gredient">
                  <!-- <span> -->
                    <img src="~/assets/website/imgs/product/cart.svg" alt="">
                    {{$t('front.request_service')}}
                  <!-- </span> -->
                  </nuxt-link>
                </div>
                <div class="mr-15">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="pro-like" @click="switchFav()">
                        <i :class="`fas fa-heart ${product.is_favourite ? 'active' : ''}`"></i><span class="grey">
                        {{ !product.is_favourite ? $t('front.add_to_favourite') : $t('front.remove_from_favourite')}}
                        </span></div>
                    </div>
                    <div class="col-md-6 text-right">
                      <ul class="share-pro">
                        <li>
                          <!-- <a href="#"> -->
                            <img src="~/assets/website/imgs/product/share.svg" alt="">
                          <!-- </a> -->
                        </li>
                        <li>
                          <ShareNetwork
                              network="facebook"
                              :url="urlLink"
                              :title="product.name"
                              :description="product.description"
                              :hashtags="product.tags.join()"
                            >
                              <!-- <i class="fab fa-facebook-f"></i> -->
                              <img src="~/assets/website/imgs/product/facebook.svg" alt="">
                          </ShareNetwork>
                        </li>
                        <li>
                         <ShareNetwork
                            network="twitter"
                            :url="urlLink"
                            :title="product.name"
                            :description="product.description"
                            :hashtags="product.tags.join()"
                          >
                            <!-- <i class="fab fa-twitter"></i> -->
                            <img src="~/assets/website/imgs/product/twitter.svg" alt="">
                          </ShareNetwork>
                        </li>
                        <li>
                         <ShareNetwork
                            network="whatsapp"
                            :url="urlLink"
                            :title="product.name"
                            :description="product.description"
                            :hashtags="product.tags.join()"
                          >
                            <i class="fab fa-whatsapp"></i>
                            <!-- <img src="~/assets/website/imgs/product/instagram.svg" alt=""> -->
                          </ShareNetwork>
                        </li>
                        <!-- <li><a href="#"><img src="~/assets/website/imgs/product/facebook.svg" alt=""></a></li>
                        <li><a href="#"><img src="~/assets/website/imgs/product/instagram.svg" alt=""></a></li>
                        <li><a href="#"><img src="~/assets/website/imgs/product/twitter.svg" alt=""></a></li> -->
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- <div class="pro-more">
                  <label class="grey">رقم المنتج  :</label><span class="blue">254178954</span>
                </div> -->
                <div class="pro-more" v-if="product.category">
                  <label class="grey">{{$t('front.public_service')}}  :</label>
                  <span class="blue">{{product.category.name}}</span>
                </div>
                <div class="pro-more" v-if="product.tags.length">
                  <label class="grey">{{$t(front.tags)}}  :</label>
                  <span class="blue">{{product.tags.join()}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--products-->
      <section class="products custom-padd">
        <div class="container">
          <div class="h3 sub-head">{{$t('front.related_services')}}
            <nuxt-link class="more" v-if="products.length" :to="{ path: localePath('services'), query: { category: product.category.id } }">
              {{$t('front.more')}}
            </nuxt-link>
          </div>
          <div id="product-carousel2">
            <VueSlickCarousel v-bind="productSlides" v-if="products.length">
              <productBlock v-for="(product, key) in products" :key="key" :product="product" />
            </VueSlickCarousel>
            <div v-else class="text-center alert-div">
              {{$t('front.no_results')}}
            </div>
          </div>
        </div>
      </section>
      <!--rate-->
      <section class="rate">
        <div class="container">
          <h3>{{$t('front.ratings')}}</h3>
          <div class="row align-items-center">
            <div class="col-6 col-md-4">
              <div class="rate lg">
                <span class="yellow">{{product.rate}}</span>
                <i
                    v-for="idx in totalRate"
                    :key="`incre${idx}`"
                    class="fas fa-star rated"
                  ></i>
                  <i
                    v-for="idx in 5 - totalRate"
                    :key="`decre${idx}`"
                    class="fas fa-star"
                  ></i>
              </div>
              <p class="grey">
                {{$t('front.based_on')}} {{product.rating_users_no}} {{$t('front.rate')}}
              </p>
            </div>
            <div class="col-6 col-md-4">
              <div v-for="(rating, key) in product.rating_statistics"
                    :key="`rate${key}`" class="row align-items-center">
                <div class="col-2"><span>{{rating.rate}}</span></div>
                <div class="col-8">
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" :style="`width: ${rating.rate / 100}%;`"></div>
                  </div>
                </div>
                <div class="col-2"><span>{{rating.users_no}}</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--rate-->
      <section class="client-rate mr-15">
        <div class="container" v-if="ratings.length">
          <h3>{{$t('front.comments')}}</h3>
          <div v-for="(rating, key) in ratings" :key="`comment${key}`" class="rate-desc">
            <div class="row align-items-end">
              <div class="col-4 col-md-2 col-lg-1">
                <img :src="rating.user.avatar" :alt="rating.user.name">
              </div>
              <div class="col-8 col-md-10 col-lg-11"><span class="grey date">
                {{rating.created_at}}
                </span>
                <div class="inline-d">
                  <p>{{rating.user.name}}</p>
                  <!-- <div class="check"><img src="~/assets/website/imgs/product/check.svg" alt=""><span class="blue">مشترى المنتج</span></div> -->
                </div>
                <div class="rate">
                  <i
                    v-for="index in rating.rate"
                    :key="`comment${key}inc_${index}`"
                    class="fas fa-star rated"
                  ></i>
                  <i
                    v-for="index in 5 - rating.rate"
                    :key="`comment${key}dec_${index}`"
                    class="fas fa-star"
                  ></i>
                </div>
                <p class="dgrey">{{rating.comment}}</p>
              </div>
            </div>
          </div>

          <button class="button btn-gredient mt-2"
            v-if="enableLoadMore"
            @click="loadMoreRatings"
          >
            {{ $t("front.more") }}
          </button>
        </div>
        <div class="container" v-else>
          <h3>{{$t('front.comments')}}</h3>
          <div class="text-center alert-div">
              {{$t('front.no_results')}}
            </div>
        </div>
      </section>
      <section class="user-rate" v-if="canRate">
        <div class="container">
          <div class="row">
            <div class="col-md-6 rate-form">
              <form @submit.prevent="create">
                <h3>{{$t('front.add_rate')}}</h3>
                <div class="inline-d">
                  <label>{{$t('front.your_rate')}}</label>
                  <div class="starrating risingstar">
                    <StarsRatings
                      v-bind:increment="1"
                      v-bind:max-rating="5"
                      inactive-color="#D3E6FB"
                      active-color="#f9ae00"
                      v-bind:star-size="20"
                      v-model="form.rate"
                      name="rate"
                      v-validate="'required'"
                    >
                    </StarsRatings>
                    <span v-show="errors.has('rate')" class="text-error text-danger text-sm">
                      {{ errors.first("rate") }}
                    </span>
                  </div>

                </div>
                <textarea v-model="form.comment" v-validate="'required'"
                class="form-control mr-15" name="comment"
                 cols="40" rows="10" :placehoder="$t('front.add_comment')"></textarea>
                <span v-show="errors.has('comment')" class="text-error text-danger text-sm">
                  {{ errors.first("comment") }}
                </span>
                <br>
                <button type="submit" class="button btn-gredient">
                  {{$t('front.send_rate')}}
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
<style src="./index.css"></style>
