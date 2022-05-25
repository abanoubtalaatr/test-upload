<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
    <div class="container" v-if="authUser">
      <div class="mr-30">
        <h3>
          {{ authUser.name }}
        </h3>
      </div>
      <div class="row">
        <side-bar />

        <div class="col-md-9">
          <!--refund-->
          <section class="profile">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-6">
                    <h3>{{$t('front.order_refund')}}</h3>
                  </div>
                  <div class="col-6 text-right">
                    <input type="checkbox" name="all" v-model="checkAll" @change="toggleSelectAll" />
                    <label for="all">{{$t('front.select_all')}}</label>
                  </div>
                </div>
                <div class="card-items c-mb">
                  <div class="card-item" v-for="(item, key) in order.items" :key="`item${key}`">
                    <div class="row align-items-center">
                      <div class="col-1">
                        <input type="checkbox" v-model="item.refund.isChecked" @change="toggleSelect" />
                      </div>
                      <div class="col-5 col-md-3">
                        <div class="pro-img">
                          <img
                            :src="item.product.image" :alt="item.name"
                          />
                        </div>
                      </div>
                      <div class="col-6 col-md-4">
                        <div class="increament-input">
                          <button
                            class="value-button pro-decrease"
                            @click="decreaseQty(key)"
                          >
                            -
                          </button>
                          <input
                            class="pro-number"
                            type="number"
                            min="1"
                            :max="item.quantity"
                            v-model="item.refund.quantity"
                            value="1"
                          />
                          <button
                            class="value-button pro-increase"
                            @click="increaseQty(key)"
                          >
                            +
                          </button>
                        </div>
                      </div>
                      <div class="col-6 col-md-2">
                        <div class="h6 sale" v-if="Number(item.offer_discount)">
                          {{Number(item.product_price)}}<span>{{ $t("front.riyal") }}</span>
                        </div>
                      </div>
                      <div class="col-6 col-md-2">
                        <div class="h6 price">
                           {{(Number(item.product_price) - Number(item.offer_discount)).toFixed(2)}}
                          <span>{{ $t("front.riyal") }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="ret-det">
                      <h5>{{ item.product.name.substring(30) }}</h5>
                      <div class="row">
                        <div class="col-6">
                          <h6 class="dred">
                            {{item.product.store.name}}
                          </h6>
                        </div>
                        <!-- <div class="col-6 text-right">
                          <h6 class="green">توصيل خلال ١٢ ساعه</h6>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
                <form @submit.prevent="submit">
                  <div class="re-det">
                    <h5>{{$t('front.refund_reason')}}</h5>
                    <select class="form-control" @change="selectReason" name="refund_reason"
                      v-validate="{ required: true }"
                      v-model="refund.refund_reason_id">
                      <option value="" selected>
                        {{$t('front.choose_refund_reason')}}
                      </option>
                      <option v-for="(reason, key) in reasons" :key="key" :value="reason.id">
                        {{ reason.name }}
                      </option>
                    </select>
                    <span v-show="errors.has('refund_reason')" class="text-error text-danger text-sm">
                      {{ errors.first("refund_reason") }}
                    </span>
                    <div class="form-group" v-if="selected_reason_type == 'other'">
                        <textarea name="" id="other-text" rows="3" class="form-control" v-model="refund.note"
                            :placeholder="$t('front.write_refund_reason')"></textarea>
                    </div>
                    <div class="app-det">
                      <input type="checkbox" v-validate="{ required: true }" id="approve" name="approve_policy" v-model="refund.accept" />
                      <label for="approve">
                        <!-- {{ policy.body }} -->
                        {{$t('front.accept')}}
                        <nuxt-link class="dred" target="_blank" :to="localePath(`refund-policy`)">
                          {{$t('front.refund_policy')}}
                        </nuxt-link>

                      </label>
                      <br>
                      <span v-show="errors.has('approve_policy')" class="text-error text-danger text-sm">
                      {{ errors.first("approve_policy") }}
                    </span>
                    </div>

                    <button type="submit" class="button btn-gredient full">{{$t('front.confirm')}}</button>
                  </div>
                </form>
              </div>
              <div class="col-md-4">
                <section class="total">
                  <div class="border-b">
                    <h4>{{$t('front.order_details')}}</h4>
                  </div>
                  <div class="border-b">
                    <div class="row">
                      <div class="col-6">
                        <h6 class="grey">{{$t('front.operation_id')}}</h6>
                      </div>
                      <div class="col-6 text-right">
                        <div class="h6">{{`${order.id}A`}}
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h6 class="grey">{{$t('front.by_date')}}</h6>
                      </div>
                      <div class="col-6 text-right">
                        <div class="h6">{{order.created_at}}
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <h6 class="grey">{{$t('front.order_status')}}</h6>
                      </div>
                      <div class="col-6 text-right">
                        <div class="h6 green">{{order.status.name}}
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    </client-only>
  </main>
  <!-- End Main Content-->
</template>

<script src="./index.js"></script>
