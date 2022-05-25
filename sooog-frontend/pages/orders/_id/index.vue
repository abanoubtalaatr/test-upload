<template>
    <!-- Main Content-->
    <main class="main-content">
    <client-only>
      <div class="container" v-if="authUser">
        <div class="mr-30">
          <h3>
            {{authUser.name}}
          </h3>
        </div>
        <div class="row">

          <side-bar />

          <div class="col-md-9">
            <!--addresses-->
            <section class="profile">

              <h3>{{$t('front.order_details')}}</h3>
              <p class="grey">{{$t('front.order_details_and_bills')}}</p>
              <div class="row">
                <div class="col-md-8">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th> </th>
                        <th>{{$t('front.product')}}</th>
                        <th>{{$t('front.quantity')}}</th>
                        <th>{{$t('front.unit')}}</th>
                        <th>{{$t('front.cost')}}</th>
                        <th></th>
                      </tr>
                      <tr v-for="(item, key) in order.items" :key="key">
                        <td>
                          <div class="pro-img"><img :src="item.product.image" alt=""></div>
                        </td>
                        <td>
                          <p class="b"></p>
                          {{item.product.name}}
                          <button class="rate-btn">
                            <i class="fas fa-star"></i>{{item.product.rate}}</button>
                          <!--<div class="blue" v-if="item.warranty">({{$t('front.include_warranty')}})</div>-->
                        </td>
                        <td>
                          <p >{{item.quantity}}</p>
                        </td>
                        <td>
                          <p class="b">{{item.unit.name}}</p>
                        </td>
                        <td>
                          <div class="h6 price">{{item.total}}<span class="grey">{{$t('front.riyal')}}</span></div>
                        </td>
                        <td>
                          <div class="inline-d rate">
                            <!--<i-->
                              <!--v-for="idx in parseInt(item.product.rate)"-->
                              <!--:key="`incre${idx}`"-->
                              <!--class="fas fa-star rated"-->
                            <!--&gt;</i>-->
                            <!--<i-->
                              <!--v-for="idx in 5 - parseInt(item.product.rate)"-->
                              <!--:key="`decre${idx}`"-->
                              <!--class="fas fa-star"-->
                            <!--&gt;</i>-->
                            <!--<span class="yellow">{{item.product.rate}}</span>-->
                            <button class="acc-btn btn-border-o" v-if="!item.product.is_rated && canRate && order.status.key == 'delivered'" @click="openRateModal(item.product.id)">
                              {{$t('front.rate_product')}}
                            </button>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="table-responsive" v-if="order.refund">
                    <hr>
                    <h3>{{$t('front.refunds')}}</h3>
                    <table class="table table-striped">
                      <tr>
                        <th> </th>
                        <th>{{$t('front.product')}}</th>
                        <th>{{$t('front.quantity')}}</th>
                        <th>{{$t('front.cost')}}</th>
                        <th></th>
                      </tr>
                      <tr v-for="(item, key) in order.refund.items" :key="key">
                        <td>
                          <div class="pro-img"><img :src="item.product.image" alt=""></div>
                        </td>
                        <td>
                          <p class="b"></p>
                          {{item.product.name}}
                          <!-- <span class="blue">{{`${item.product.id}A`}}</span> -->
                        </td>
                        <td>
                          <p >{{item.quantity}}</p>
                        </td>
                        <td>
                          <div class="h6 price">{{item.total}}<span>{{$t('front.riyal')}}</span></div>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <div class="more-det">
                    <div class="m-det">
                      <span class="grey">{{$t('front.operation_id')}} :</span>
                      <span class="b">{{`${order.id}A`}}</span>
                    </div>
                    <div class="m-det">
                      <span class="grey">{{$t('front.status')}} :</span>
                      <span class="b">{{order.status.name}}</span>
                    </div>
                    <div class="m-det">
                      <span class="grey">{{$t('front.by_date')}} :</span>
                      <span class="b">{{order.created_at}}</span>
                    </div>
                    <div class="m-det">
                      <span class="grey">{{$t('front.payment_method_id')}} :</span>
                      <span class="b">{{order.payment_method.name}}</span>
                    </div>

                  </div>
                  <div class="col-md-12 text-center mr-d mr-15">
                      <button v-if="order.status.key == 'delivering'" class="button btn-gredient text-center" @click="changeStatus">
                        {{$t('front.delivered')}}
                      </button>
                      <nuxt-link v-if="order.status.key == 'delivered' && order.can_refund" class="button btn-gredient serv-info text-center" :to="localePath(`/orders/${order.id}/refund`)">
                        {{$t('front.refund')}}
                      </nuxt-link>

                      <button v-if="order.status.key == 'new'" class="button btn-gredient text-center" @click="openCancelModal">
                        {{$t('front.cancel_order')}}
                      </button>

                      <a v-if="order.invoice != ''" class="button serv-info btn-gredient text-center" target="_blank" :href="order.invoice">
                        <i class="fas fa-file-pdf"></i>
                        {{$t('front.invoice')}}
                      </a>
                  </div>

                </div>
                <div class="col-md-4">
                  <div class="total">
                    <div class="border-b">
                      <h4>{{$t('front.order_total')}}</h4>
                    </div>
                    <div class="border-b">
                      <div class="row">
                        <div class="col-7">
                          <h6 class="grey">{{$t('front.subtotal')}}</h6>
                        </div>
                        <div class="col-5 text-right">
                          <div class="h6 price">
                            {{parseFloat(order.subtotal)}}
                          <span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>
                      <!--<div class="row">-->
                        <!--<div class="col-7">-->
                          <!--<h6 class="grey">{{$t('front.warranties_total')}}</h6>-->
                        <!--</div>-->
                        <!--<div class="col-5 text-right">-->
                          <!--<div class="h6 price">-->
                            <!--{{parseFloat(order.warranties_amount)}}-->
                          <!--<span>{{$t('front.riyal')}}</span></div>-->
                        <!--</div>-->
                      <!--</div>-->
                      <div class="row">
                        <div class="col-7">
                          <h6 class="grey">{{$t('front.tax')}}</h6>
                        </div>
                        <div class="col-5 text-right">
                          <div class="h6 price">{{order.order_added_tax}}<span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>
                      <div class="row" v-if="parseFloat(order.delivery_charge) > 0">
                        <div class="col-7">
                          <h6 class="grey">{{$t('front.delivery_charge')}}</h6>
                        </div>
                        <div class="col-5 text-right">
                          <div class="h6 price">{{order.delivery_charge}}<span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="border-b">
                      <div class="row" v-if="order.promo_code">
                        <div class="col-7">
                          <h6 class="grey">{{$t('front.promo_code')}}</h6>
                        </div>
                        <div class="col-5 text-right">
                          <div class="h6 price"><span>{{order.promo_code.code}}</span></div>
                        </div>
                      </div>
                      <div class="row" v-if="order.promo_code">
                        <div class="col-7">
                          <h6 class="grey">{{$t('front.coupon_value')}}</h6>
                        </div>
                        <div class="col-5 text-right">
                          <div class="h6 price"><span>
                            {{order.promo_code_discount}}
                            </span><span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>

                      <div class="row"  v-if="parseFloat(order.wallet_payout)">
                        <div class="col-6">
                          <h6 class="grey">{{$t('front.wallet_payout')}}</h6>
                        </div>
                        <div class="col-6 text-right">
                          <div class="h5 price">{{order.wallet_payout}}<span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <h6 class="grey">{{$t('front.total')}}</h6>
                        </div>
                        <div class="col-6 text-right">
                          <div class="h5 price">{{order.total}}<span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>

                      <div class="row" v-if="order.refund">
                        <div class="col-6">
                          <h6 >{{$t('front.total_refund')}}</h6>
                        </div>
                        <div class="col-6 text-right">
                          <div class="h5 price">{{order.refund.total}}<span>{{$t('front.riyal')}}</span></div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

            </section>

            <RatingModal />
            <CancelModal />

          </div>
        </div>
      </div>
    </client-only>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
