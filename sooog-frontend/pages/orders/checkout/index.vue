<template>
  <!-- Main Content-->
  <main class="main-content">
    <!--map-->
    <div class="custom-padd">
      <div class="container">
        <ul class="map">
          <li><nuxt-link :to="localePath('index')">{{$t('front.home')}}</nuxt-link></li>
          <li><a href="#">{{$t('front.checkout')}}</a></li>
        </ul>
      </div>
    </div>
    <!--content-->
    <section class="order" v-if="cartData">
      <div class="container">
        <h3>{{$t('front.checkout')}}</h3>
        <!-- <p class="grey">
          صيانة أعطال سامسونج المعتمد بإصلاح جميع أعطال مكيفات سامسونج
        </p> -->
        <div class="row">
          <div class="col-md-8 payment-div">
            <div class="tool-bar">
              <div class="container">
                  <div class="row">
                      <div class="col-12">
                        <ul>
                            <li :class="`${stepper ? 'completed' : ''}`">
                                <div>
                                    <span></span>
                                    <span>
                                      {{ $t('front.addresses') }}
                                    </span>
                                </div>
                            </li>
                            <li :class="`${stepper > 1 ? 'completed' : ''}`">
                                <div>
                                    <span></span>
                                    <span>
                                      {{ $t('front.payments') }}
                                    </span>
                                </div>
                            </li>
                        </ul>
                      </div>
                  </div>
              </div>
            </div>
            <!--special-order-->
            <section class="products custom-padd">
              <div class="container">
                <h3>{{$t('front.special_order')}}</h3>
                <p class="grey">{{$t('front.write_note')}}</p>
                <textarea class="form-control mr-15" name="note" cols="40" rows="10" :placeholder="$t('front.order_details')">{{form.notes}}</textarea>
                <!--<button class="button btn-gredient big-s">{{$t('front.send')}}-->
                  <!--<img src="~assets/website/imgs/home/arrow-w.svg" alt="">-->
                <!--</button>-->
              </div>
            </section>
            <div class="steps">
              <div class="step" v-if="stepper == 1">
                <form data-vv-scope="firstStep" @submit.prevent="nextStep(2)">
                  <div class="address">
                    <div class="row">
                      <div class="col-7">
                        <h3>{{$t('front.shipping_addresses')}}</h3>
                        <div v-for="(address, key) in addresses" :key="`addr${key}`" class="pretty p-default p-round">
                          <input v-validate="'required'" type="radio" :checked="address.is_primary ? 'checked' : ''" :value="address.id" name="address"
                            @change="getMethods"
                            v-model="form.user_address_id" />
                          <div class="state">
                            <label>
                              {{ address.title }} - {{ address.address }} - {{ address.city.name || '' }} - {{ address.city.state.name || '' }}
                            </label>
                          </div>

                        </div>
                        <span v-show="errors.has('address', 'firstStep')" class="text-error text-danger text-sm">
                            {{ errors.first("address", 'firstStep') }}
                          </span>
                      </div>
                      <div class="col-5 text-right">
                        <nuxt-link class="serv-info button btn-gredient" :to="localePath('addresses-create')">
                          {{$t('front.create_address')}}
                        </nuxt-link>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-md-4">
                      <button type="submit" class="button btn-gredient full">
                        {{$t('front.next')}}
                      </button>
                      <!-- <button @click="prevStep(1)" class="no-btn full">رجوع</button> -->
                    </div>
                  </div>
                </form>
              </div>
              <div class="step" v-if="stepper == 2">

                <form data-vv-scope="lastStep" @submit.prevent="submit">
                  <div class="form">
                    <div class="address">
                      <h3>{{$t('front.available_payments')}}</h3>
                      <div class="nav flex-column nav-pills">
                        <div v-for="(method, key) in methods" :key="`method${key}`" class="pretty p-default p-round">
                          <input
                            type="radio"
                            v-validate="`${parseFloat(cartData.wallet_payout) < parseFloat(cartData.total) ? 'required' : '' }`"
                            :value="method.id" v-model="form.payment_method_id" name="payment_method_id"
                            :payment="method.type" :checked="selected_payment_type == method.type ? 'checked' : ''"
                            :disabled="parseFloat(cartData.remain) == 0 && form.use_wallet"
                            @change="selectedMethod(method)"
                          />
                          <div class="state">
                            <label>{{method.name}}</label>
                          </div>
                        </div>
                        <div class="pretty p-default" v-if="parseInt(cartData.wallet) > 0">
                          <input type="checkbox" v-model="form.use_wallet"
                           name="wallet" />
                          <div class="state">
                            <label>{{$t('front.use_wallet')}}</label>
                          </div>
                        </div>
                        <span v-show="errors.has('payment_method_id', 'lastStep')" class="text-error text-danger text-sm">
                          {{ errors.first("payment_method_id", 'lastStep') }}
                        </span>
                      </div>
                    </div>

                    <div class="banks" v-if="selected_payment_type == 'bank_transfer'">
                      <h3>{{$t('front.bank_accounts')}}</h3>
                      <div v-for="(bank, key) in banks" :key="`bank${key}`" class="pretty p-default p-round p-full">
                        <input type="radio" v-validate="'required'" :value="bank.id"
                          v-model="bank.bank_account_id" name="bank_id" @change="selectBank" />
                        <div class="state bank-s">
                          <label for="">
                            <div class="bank-img">
                              <img
                                :src="bank.image"
                                alt=""
                              />
                            </div>
                            <div class="bank-txt">
                              <h5>{{bank.name}}</h5>
                              <p>{{bank.account_number}}</p>
                            </div>
                          </label>
                        </div>
                      </div>
                      <span v-show="errors.has('bank_id', 'lastStep')" class="text-error text-danger text-sm">
                          {{ errors.first("bank_id", 'lastStep') }}
                      </span>

                      <div class="row mb-2">
                        <div class="col-md-6">
                          <input
                            class="form-control login-input date"
                            type="text"
                            name="deposite_name"
                            v-validate="'required'"
                            v-model="bank.depositor_name"
                            :placeholder="$t('front.deposite_name')"
                          />
                          <span v-show="errors.has('deposite_name', 'lastStep')" class="text-error text-danger text-sm">
                              {{ errors.first("deposite_name", 'lastStep') }}
                          </span>
                        </div>
                        <div class="col-md-6">
                          <input
                            class="form-control login-input date"
                            type="text"
                            name="deposite_amount"
                            v-validate="'required|numeric'"
                            v-model="bank.deposit_amount"
                            :placeholder="$t('front.deposite_amount')"
                          />
                          <span v-show="errors.has('deposite_amount', 'lastStep')" class="text-error text-danger text-sm">
                              {{ errors.first("deposite_amount", 'lastStep') }}
                          </span>
                        </div>
                      </div>

                      <div class="row" :key="uniqueId">
                        <div class="col-md-12">
                          <div class="custom-file-upload">
                            <button class="no-btn">
                              <i class="fas fa-upload"></i>
                              <span>{{$t('admin.choose_file')}}</span>
                            </button>
                            <input name="deposite_receipt" v-validate="'required'" ref="deposit_receipt"
                             @change="handleUploadFile" type="file" />

                            <span v-show="errors.has('deposite_receipt', 'lastStep')" class="text-error text-danger text-sm">
                                {{ errors.first("deposite_receipt", 'lastStep') }}
                            </span>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="profile-img-uploaded" v-if="bank.deposit_receipt != ''" >
                            <a :href="bank.deposit_receipt" target="_blank">
                              <object :data="bank.deposit_receipt" type="application/pdf" 
                                v-if="fileType == 'application/pdf'" >
                              </object> 
                              <img v-else :src="bank.deposit_receipt" alt="">
                            </a>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="banks" v-if="selected_payment_type == 'online' && online_methods.length">
                      <h3>{{$t('front.payment_method_id')}}</h3>
                      <div v-for="(method, key) in online_methods" :key="`online${key}`" class="pretty p-default p-round col-4">
                        <input type="radio" v-validate="'required'" :value="method.id"
                          v-model="form.online_payment_method_id" name="online_payment_method_id" />
                        <div class="state bank-s">
                          <label for="">
                            <div class="bank-img method-img">
                              <img
                                :src="method.image"
                                alt=""
                              />
                            </div>
                            <div class="bank-txt">
                              <h5>{{method[currentLocale]}}</h5>
                            </div>
                          </label>
                        </div>
                      </div>
                    </div>

                    <span v-show="errors.has('online_payment_method_id', 'lastStep')" class="text-error text-danger text-sm">
                          {{ errors.first("online_payment_method_id", 'lastStep') }}
                      </span>

                    <div class="text-center">
                      <button :disabled="!enableSubmit" type="submit" class="button btn-gredient">
                        {{$t('front.complete_order')}}
                      </button>
                      <button type="button" @click="prevStep(1)" class="button btn-border">
                        {{$t('front.back')}}
                      </button>
                    </div>

                  </div>
                </form>
              </div>
            </div>
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
                    <div class="h6 price">
                            {{parseFloat(cartData.subtotal) - parseFloat(cartData.offer_discount)}}
                      <span>{{$t('front.riyal')}}</span></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <h6 class="grey">{{$t('front.tax')}}</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price">{{cartData.order_added_tax}}<span>{{$t('front.riyal')}}</span></div>
                  </div>
                </div>
                <div class="row" v-if="parseFloat(cartData.delivery_charge) > 0">
                  <div class="col-6">
                    <h6 class="grey">{{$t('front.delivery_charge')}}</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price">{{cartData.delivery_charge}}<span>{{$t('front.riyal')}}</span></div>
                  </div>
                </div>

                <div class="row" v-if="form.use_wallet">
                  <div class="col-6">
                    <h6 class="grey">{{$t('front.balance')}}</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price">{{cartData.wallet}}<span>{{$t('front.riyal')}}</span></div>
                  </div>
                </div>
                <div class="row" v-if="form.use_wallet">
                  <div class="col-6">
                    <h6 class="grey">{{$t('front.remain_to_pay')}}</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price">{{cartData.remain}}<span>{{$t('front.riyal')}}</span></div>
                  </div>
                </div>

                <!--<div class="row" v-if="Number(cartData.warranties_amount)">-->
                  <!--<div class="col-6">-->
                    <!--<h6 class="blue">{{$t('front.warranties_total')}}</h6>-->
                  <!--</div>-->
                  <!--<div class="col-6 text-right">-->
                    <!--<div class="h6 price blue">{{cartData.warranties_amount}}<span>{{$t('front.riyal')}}</span></div>-->
                  <!--</div>-->
                <!--</div>-->
              </div>

               <div class="align-items-center">
                 <div class="input-group input-code">
                    <input class="form-control" type="text" :placeholder="$t('front.enter_coupon')">
                    <div class="input-group-prepend">
                      <button class="btn-orange" @click="previewOrder">{{$t('front.apply')}}</button>
                    </div>
                  </div>
                  <!--<div class="col-4">
                    <h6 class="grey">{{$t('front.promo_code')}}</h6>
                  </div>
                  <div class="col-5 text-right">
                    <input class="form-control" v-model="form.promo_code" type="text"
                    @keyup="previewOrder"
                    :placeholder="$t('front.enter_coupon')">
                    <input class="form-control" v-model="form.promo_code" type="text"
                      :placeholder="$t('front.enter_coupon')">
                  </div>
                  <div class="col-2 text-right">
                    <button class="button btn-gredient btn-discount" @click="previewOrder">
                          {{$t('front.apply')}}
                    </button>
                  </div>-->
                </div>
                <div class="row" v-if="cartData.promo_code_type">
                  <div class="col-6">
                    <h6 class="grey">{{$t('front.coupon_value')}}</h6>
                  </div>
                  <div class="col-6 text-right">
                    <div class="h6 price" v-if="parseFloat(cartData.promo_code_discount) > 0">
                      {{cartData.promo_code_discount}}
                      <span>{{$t('front.riyal')}}</span>
                    </div>

                    <div class="h6 price" v-else>
                      {{$t(`front.coupon_types.${cartData.promo_code_type}`)}}
                    </div>
                  </div>

                </div>

              <div class="row">
                <div class="col-6">
                  <h6 class="grey">{{$t('front.total')}}</h6>
                </div>
                <div class="col-6 text-right">
                  <div class="h6 price">{{cartData.total}}<span>{{$t('front.riyal')}}</span></div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- End Main Content-->
</template>

<script src="./index.js"></script>
