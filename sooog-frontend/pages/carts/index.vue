<template>
  <!-- Main Content-->
    <main class="main-content">
      <DeleteModal
          :is-active="isModalActive"
          @confirm="trashConfirm('handle-delete-cart')"
          @cancel="trashCancel"
        />

      <div class="custom-padd">
        <div class="container">
          <ul class="map">
            <li><nuxt-link :to="localePath('index')">{{$t('front.home')}}</nuxt-link></li>
            <li><a href="#">{{$t('front.cart')}}</a></li>
          </ul>
        </div>
      </div>
      <!--content-->
      <section class="order">
        <div class="container" v-if="meta">
          <h3>{{$t('front.cart')}} ({{meta.total}})</h3>
          <div class="row">
            <div class="col-md-8">
              <div class="card-items" v-if="carts.length">
                <div class="card-item" v-for="(cart, key) in carts" :key="`cart${key}`">
                  <div class="row align-items-center">
                    <div class="col-3 col-md-2">
                      <div class="pro-img">
                        <img :src="cart.product.image" alt=""></div>
                    </div>
                    <div class="col-6 col-md-4">
                      <p class="b">{{cart.product.name}} <span> ({{cart.unit.name}}) </span></p>
                    </div>
                    <div class="col-3 col-md-2">
                      <div class="increament-input">
                        <button class="value-button pro-decrease" :disabled="clicked" @click="decreaseQty(key)">-</button>
                        <input class="pro-number" type="number" min="1" :max="cart.unit.quantity<cart.product.max_purchase_quantity?cart.unit.quantity:cart.product.max_purchase_quantity" v-model="cart.quantity" @change="updateCart(cart, key)">
                        <button class="value-button pro-increase" :disabled="clicked" @click="increaseQty(key)">+</button>
                      </div>
                    </div>
                    <div class="col-6 col-md-2">
                      <div class="h6 sale" v-if="cart.unit.discount">{{cart.unit.price_including_tax}}<span>{{$t('front.riyal')}}</span></div>
                    </div>
                    <div class="col-6 col-md-2">
                      <div class="h6 price">{{cart.unit.price_after_discount}}<span>{{$t('front.riyal')}}</span></div>
                    </div>
                    <div class="col-6 col-md-2">
                      <div class="text-right">
                        <button class="no-btn orange2" @click="trashModal(cart.id)">
                          <i class="fas fa-trash" ></i> {{$t('front.delete')}}</button>
                      </div>
                    </div>
                  </div>
                  <!--<div class="row">-->
                      <!--<div class="col-6 offset-md-2">-->
                        <!--<select class="form-control text-left" name="warranty" v-model="cart.warranty_id" @change="updateCart(cart, key)">-->
                            <!--<option selected value="" disabled>{{$t('front.warranty_type')}}</option>-->
                            <!--<option v-for="(warranty, key) in warranties" :key="`warr${key}`" :value="warranty.id">-->
                              <!--{{warranty.name}} - {{warranty.price}}{{$t('front.riyal')}}-->
                            <!--</option>-->
                          <!--</select>-->
                      <!--</div>-->

                      <!-- <div class="delete"> -->
                        <!--<div class="text-right col-4">-->
                          <!--<button class="no-btn red" @click="trashModal(cart.id)">-->
                            <!--<img src="~/assets/website/imgs/order/delete.svg" alt="">-->
                            <!--{{$t('front.delete')}}-->
                          <!--</button>-->
                        <!--</div>-->
                      <!-- </div> -->
                  <!--</div>-->

                </div>
                <!-- <div class="text-right">
                  <button class="button btn-border">تحديث السلة</button>
                </div> -->
              </div>

              <div v-else class="text-center alert-div">
                  {{$t('front.no_results')}}
                </div>

                <Pagination
                  :pagination="meta"
                  v-if="meta && meta.last_page != 1"
                  @page-changed="onPageChange($event)"
                  @prev-page="prevPage($event)"
                  @next-page="nextPage($event)"
                />

            </div>
            <div class="col-md-4">
              <section class="total">
                <div class="border-b">
                  <h4>{{$t('front.order_total')}}</h4>
                </div>
                <div class="border-b">
                  <div class="row">
                    <div class="col-6">
                      <h6 class="grey">{{$t('front.subtotal')}}</h6>
                    </div>
                    <div class="col-6 text-right">
                      <div class="h6 price">{{cartData.subtotal}}<span>
                        {{$t('front.riyal')}}
                        </span></div>
                    </div>
                  </div>
                  <!--<div class="row">-->
                    <!--<div class="col-6">-->
                      <!--<h6 class="blue">{{$t('front.warranties_total')}}</h6>-->
                    <!--</div>-->
                    <!--<div class="col-6 text-right">-->
                      <!--<div class="h6 price blue">{{cartData.warranties_total}}<span>-->
                        <!--{{$t('front.riyal')}}-->
                        <!--</span></div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <!-- <div class="row">
                    <div class="col-6">
                      <h6 class="grey">قيمة الضريبة</h6>
                    </div>
                    <div class="col-6 text-right">
                      <div class="h6 price">30.00<span>ر.س</span></div>
                    </div>
                  </div> -->
                </div>
                <!-- <div class="row">
                  <div class="col-6">
                    <h6 class="grey">الإجمالى</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price">4201.21<span>ر.س</span></div>
                  </div>
                </div> -->
                <nuxt-link v-if="carts.length" :to="localePath('orders-checkout')" class="serv-info button btn-gredient full">
                  {{$t('front.complete_order')}}
                </nuxt-link>
              </section>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
