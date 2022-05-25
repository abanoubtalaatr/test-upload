<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--map-->
      <div class="custom-padd">
        <div class="container">
          <ul class="map">
            <li><nuxt-link :to="localePath('index')">{{$t('front.home')}}</nuxt-link></li>
            <li>
              <nuxt-link :to="{ path: localePath('products'), query: { category: product.category.id } }">
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
              <div class="carousel slide" id="product-car" data-ride="carousel">

                <div class="carousel-inner">
                  <VueSlickCarousel v-bind="slides">
                  <div class="carousel-item active">
                    <img :src="product.image" alt="">
                  </div>
                  <div v-for="(attachment, key) in product.attachments"
                    :key="`attach_up${key}`" class="carousel-item">
                    <img :src="attachment.file" alt="">
                  </div>
                  </VueSlickCarousel>
                </div>
                <!-- <ul class="carousel-indicators">
                  <li class="d-flex justify-content-center active"
                    data-target="#product-car" data-slide-to="0">
                    <img src="~/assets/website/imgs/home/product-img@2x.png" alt="">
                  </li>
                  <li class="d-flex justify-content-center" data-target="#product-car" data-slide-to="1"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></li>
                  <li class="d-flex justify-content-center" data-target="#product-car" data-slide-to="2"><img src="~/assets/website/imgs/home/product-img@2x.png" alt=""></li>
                </ul> -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="product-info">
                <h3>{{product.name}}</h3>
                <div class="flex-div">
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
                  <ul class="share-pro">
                    <li><img src="~/assets/website/imgs/product/share.svg" alt=""></li>
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
                    <!-- <li><a href="#"><img src="~/assets/website/imgs/product/facebook.svg" alt=""></a></li>
                    <li><a href="#"><img src="~/assets/website/imgs/product/instagram.svg" alt=""></a></li>
                    <li><a href="#"><img src="~/assets/website/imgs/product/twitter.svg" alt=""></a></li> -->
                  </ul>
                </div>
                <div class="flex-div" v-for="(unit, key) in product.units" :key="`unit${key}`">
                  <input type="radio" name="unit_id" v-model="unit_id" :value="unit.id"/>
                  <label class="grey">{{unit.name}}</label>
                  <div class="price-info">
                  <h5 class="orange price">{{unit.price_after_discount}}<span>{{$t('front.riyal')}}</span></h5>
                  <h6 class="sale" v-if="unit.discount">{{unit.price_including_tax}}{{$t('front.riyal')}}</h6>
                  <div class="red-sale" v-if="unit.discount">
                    <span>{{$t('front.discount')}}{{unit.discount}}%</span>
                  </div>
                  </div>
                </div>
                <p class="grey">
                  {{product.description}}
                </p>
                <div class="flex-div">
                <div class="seller">
                  <!--<span class="brown">{{$t('front.merchant')}} : </span>-->
                <!-- <img src="~/assets/website/imgs/product/seller-logo.png" alt=""> -->
                <span class="grey">{{product.store.name}}</span></div>
                  <button class="button btn-border" data-toggle="modal" data-target="#modal-order">{{$t('front.request_price')}}</button>
                </div>
                <div class="row mr-15">
                  <div class="col-3 col-md-4">
                    <div class="increament-input">
                      <button class="value-button pro-decrease" @click="decreaseQty">-</button>
                      <input class="pro-number" type="number" :max="units.find(item=> item.id==unit_id).quantity" min="1" v-model="cart.quantity">
                      <button class="value-button pro-increase" @click="increaseQty">+</button>
                    </div>
                  </div>
                  <div class="col-4 col-md-6 col-lg-4" v-if="product.store.package">
                    <button v-if="product.store.package.has_chat" class="button btn-border h-100"><img src="~/assets/website/imgs/product/chat.svg" alt="">{{$t('front.chat')}}</button>
                  </div>
                  <!--<div id="chat">-->
                    <!--<button class="no-btn" id="chat-o"><img src="assets/imgs/home/chat-dots.svg" alt=""></button>-->
                    <!--<div id="chat-body">-->
                      <!--<div class="chat-head">-->
                        <!--<div class="flex-div-2">-->
                          <!--<div class="chat-img"><img src="assets/imgs/home/user.png" alt=""></div>-->
                          <!--<div class="chat-name">-->
                            <!--<h5>الاسم</h5>-->
                            <!--<div class="det">-->
                              <!--<p>متصل</p>-->
                              <!--<p>أخر تواجد  من 3 ساعات</p>-->
                            <!--</div>-->
                          <!--</div>-->
                        <!--</div>-->
                      <!--</div>-->
                      <!--<div class="chat-msgs">-->
                        <!--<div class="chat-sent">-->
                          <!--<div class="chat-bubble">-->
                            <!--<p>خلافاَ للإعتقاد السائد فإن </p>-->
                            <!--<div class="bubble-arrow alt"></div>-->
                          <!--</div>-->
                          <!--<p class="time-m">Yesterday-1426-PM</p>-->
                        <!--</div>-->
                        <!--<div class="chat-res">-->
                          <!--<div class="chat-bubble">-->
                            <!--<p>خلافاَ للإعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي</p>-->
                            <!--<div class="bubble-arrow"></div>-->
                          <!--</div>-->
                          <!--<p class="time-m">Yesterday-1426-PM</p>-->
                        <!--</div>-->
                      <!--</div>-->
                      <!--<div class="chat-send-m">-->
                        <!--<div class="input-group">-->
                          <!--<div class="input-group-append">-->
                            <!--<div class="custom-file-upload">-->
                              <!--<input type="file"><img src="assets/imgs/home/attach.svg" alt="">-->
                            <!--</div>-->
                          <!--</div>-->
                          <!--<input class="form-control" type="text" placeholder="اكتب رسالتك">-->
                          <!--<div class="input-group-prepend">-->
                            <!--<button class="no-btn"><img src="assets/imgs/home/send.svg" alt=""></button>-->
                          <!--</div>-->
                        <!--</div>-->
                      <!--</div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <div class="col-5 col-md-6 col-lg-4">
                    <button class="button btn-gredient full" @click="addToCart">
                      <img src="~/assets/website/imgs/product/cart.svg" alt="">
                    {{$t('front.add_to_cart')}}
                    </button>
                  </div>
                </div>
                  <div class="add-fav">
                      <div class="pro-like" @click="switchFav()">
                        <i :class="`fas fa-heart ${product.is_favourite ? 'liked' : ''}`"></i><span class="grey">
                        {{ !product.is_favourite ? $t('front.add_to_favourite') : $t('front.remove_from_favourite')}}
                        </span></div>
                    </div>
                    <!--<div class="col-md-6 text-right">-->
                      <!--<ul class="share-pro">-->
                        <!--<li>-->
                          <!--<a v-if="product.catalog && product.catalog != ''" :href="product.catalog" target="_blank"  class="pdf-icon" :title="$t('front.catalog')">-->
                            <!--<i class="fas fa-file-pdf red"></i>-->
                          <!--</a>-->
                        <!--</li>-->
                        <!--<li>-->
                          <!--&lt;!&ndash; <a href="#"> &ndash;&gt;-->
                            <!--<img src="~/assets/website/imgs/product/share.svg" alt="">-->
                          <!--&lt;!&ndash; </a> &ndash;&gt;-->
                        <!--</li>-->
                        <!---->
                        <!--<ShareNetwork-->
                            <!--network="facebook"-->
                            <!--:url="urlLink"-->
                            <!--:title="product.name"-->
                            <!--:description="product.description"-->
                            <!--:hashtags="product.tags.join()"-->
                          <!--&gt;-->
                            <!--&lt;!&ndash; <i class="fab fa-facebook-f"></i> &ndash;&gt;-->
                            <!--<img src="~/assets/website/imgs/product/facebook.svg" alt="">-->
                        <!--</ShareNetwork>-->

                         <!--<ShareNetwork-->
                            <!--network="twitter"-->
                            <!--:url="urlLink"-->
                            <!--:title="product.name"-->
                            <!--:description="product.description"-->
                            <!--:hashtags="product.tags.join()"-->
                          <!--&gt;-->
                            <!--&lt;!&ndash; <i class="fab fa-twitter"></i> &ndash;&gt;-->
                            <!--<img src="~/assets/website/imgs/product/twitter.svg" alt="">-->
                          <!--</ShareNetwork>-->

                         <!--<ShareNetwork-->
                            <!--network="whatsapp"-->
                            <!--:url="urlLink"-->
                            <!--:title="product.name"-->
                            <!--:description="product.description"-->
                            <!--:hashtags="product.tags.join()"-->
                          <!--&gt;-->
                            <!--<i class="fab fa-whatsapp"></i>-->
                            <!--&lt;!&ndash; <img src="~/assets/website/imgs/product/instagram.svg" alt=""> &ndash;&gt;-->
                          <!--</ShareNetwork>-->
                        <!--&lt;!&ndash; <li><a href="#"><img src="~/assets/website/imgs/product/facebook.svg" alt=""></a></li>-->
                        <!--<li><a href="#"><img src="~/assets/website/imgs/product/instagram.svg" alt=""></a></li>-->
                        <!--<li><a href="#"><img src="~/assets/website/imgs/product/twitter.svg" alt=""></a></li> &ndash;&gt;-->
                      <!--</ul>-->
                    <!--</div>-->
                  </div>
                <!-- <div class="pro-more">
                  <label class="grey">رقم المنتج  :</label><span class="brown">254178954</span>
                </div> -->
                <div class="pro-more" v-if="product.category">
                  <label class="grey">{{$t('front.category')}}  :</label>
                  <span class="brown">{{product.category.name}}</span>
                </div>
                <div class="pro-more" >
                  <label class="grey">{{$t('front.barcode')}}  :</label>
                  <span class="brown">{{product.barcode}}</span>
                </div>
                <div class="pro-more" v-if="product.tags.length">
                  <label class="grey">{{$t('front.tags')}}  :</label>
                  <span class="brown">{{product.tags.join()}}</span>
                </div>
              </div>
            </div>
          </div>
      </section>

            <!--description-->
      <section class="description mr-15">
        <div class="container">
          <h4>{{$t('front.product_details')}}</h4>
          <p class="grey">{{product.description}}</p>
          <div class="table-responsive" v-if="product.properties.length">
            <table class="table table-striped">
              <tbody>
                <tr v-for="(property, key) in product.properties" :key="`prop${key}`">
                  <td class="grey col-3">{{property.property.name}}</td>
                  <td class="brown col-9">{{property.value}}</td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <!--description-->
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
                  <!-- <div class="check"><img src="~/assets/website/imgs/product/check.svg" alt=""><span class="brown">مشترى المنتج</span></div> -->
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
      <!--products-->
      <section class="products custom-padd">
        <div class="container">
          <div class="h3 sub-head">{{$t('front.related_products')}}
            <nuxt-link class="more" v-if="products.length" :to="{ path: localePath('products'), query: { category: product.category.id } }">
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
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
<style src="./index.css"></style>
