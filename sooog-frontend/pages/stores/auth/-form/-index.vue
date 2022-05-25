<template>
    <div>
  <!--register-content-->
    <section class="login-content" v-if="stepper==0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="l-form">
              <div class="">
                <div class="step" :key="uniqueId">
                  <h3>{{$t('front.register_store')}}</h3>
                  <b-form @submit.prevent="submit()" class="form">
                    <div class="row mb-0">
                      <div class="col-6">
                        <div class="s-f">
                          <input type="radio" name="type" checked value="stores" v-model="form.type">
                          <label for="">{{$t('front.store')}}</label>
                        </div>
                      </div>
                      <!--<div class="col-6">-->
                        <!--<div class="s-f">-->
                          <!--<input type="radio" name="type" value="centers" v-model="form.type">-->
                          <!--<label for="">{{$t('front.center')}}</label>-->
                        <!--</div>-->
                      <!--</div>-->

                    </div>
                    <input class="form-control login-input" type="text" name="en.name"
                           :placeholder="$t('admin[\'en.name\']')"
                           v-model="form.en.name" v-validate="{ required: true }">
                    <span v-show="errors.has('en.name')" class="text-error text-danger text-sm">
                        {{ errors.first("en.name") }}
                      </span>
                    <input class="form-control login-input" type="text" name="ar.name"
                           :placeholder="$t('admin[\'ar.name\']')"
                           v-model="form.ar.name" v-validate="{ required: true }">
                    <span v-show="errors.has('ar.name')" class="text-error text-danger text-sm">
                        {{ errors.first("ar.name") }}
                      </span>
                    <input class="form-control login-input" type="text" name="username"
                           :placeholder="$t('front.username')"
                           v-model="form.username" v-validate="{ required: true }">
                    <span v-show="errors.has('username')" class="text-error text-danger text-sm">
                        {{ errors.first("username") }}
                      </span>
                    <input class="form-control login-input" type="text" name="email" :placeholder="$t('front.email')"
                           v-model="form.email" v-validate="{ required: true, email: true }">
                    <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                        {{ errors.first("email") }}
                      </span>
                    <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')"
                           v-model="form.phone" v-validate="{ required: true, numeric: true, max: 17,min:7 }">
                    <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
          {{ errors.first("phone") }}
        </span>

                    <select class="form-control login-input" name="country" v-model="form.country_id"
                            v-validate="{ required: true }" @change="changeCountry($event.target.value)">
                      <option selected value="" disabled>{{$t('front.country')}}</option>
                      <option v-for="(country, key) in countries" :key="key" :value="country.id">{{country.name}}
                      </option>
                    </select>
                    <span v-show="errors.has('country')" class="text-error text-danger text-sm">
          {{ errors.first("country") }}
        </span>
                    <select class="form-control login-input" v-model="form.state_id"
                            v-validate="{ required: true }" name="state" @change="changeState($event.target.value)">
                      <option selected value="" disabled>{{$t('front.state')}}</option>
                      <option v-for="(state, key) in states" :key="key" :value="state.id">{{state.name}}</option>
                    </select>
                    <span v-show="errors.has('state')" class="text-error text-danger text-sm">
          {{ errors.first("state") }}
        </span>

                    <select :placeholder="$t('front.city')" class="form-control login-input" v-model="form.city_id"
                            v-validate="{ required: true }" name="city">
                      <option selected value="" disabled>{{$t('front.city')}}</option>
                      <option v-for="(city, key) in cities" :key="key" :value="city.id">{{city.name}}</option>
                    </select>
                    <span v-show="errors.has('city')" class="text-error text-danger text-sm">
          {{ errors.first("city") }}
        </span>
                    <div class="s-f">
                      <label for="" class="s-f">{{$t('front.choose_address')}}</label>
                    </div>
                    <div class="map-wrap">
                      <GmapMap ref="mapRef"
                               :center="position"
                               :zoom="12"
                               map-type-id="terrain"
                               style="width: 100%; height: 300px"
                               @click="handleMap"
                      >
                        <GmapMarker
                          :position="position"
                          :clickable="true"
                          :draggable="true"
                          @click="position"
                          @dragend="handleMap($event)"
                        />
                      </GmapMap>
                    </div>
                    <input class="form-control login-input" type="text" name="commercial_registry_no" :placeholder="$t('front.commercial_registry_no')"
                           v-model="form.commercial_registry_no" v-validate="{ required: true, numeric: true, max: 25 }">
                    <span v-show="errors.has('commercial_registry_no')" class="text-error text-danger text-sm">
          {{ errors.first("commercial_registry_no") }}
        </span>

                    <!--<input class="form-control login-input" type="text" name="bank_name" :placeholder="$t('front.bank_name')"-->
                           <!--v-model="form.bank_name">-->
                    <!--<span v-show="errors.has('bank_name')" class="text-error text-danger text-sm">-->
          <!--{{ errors.first("bank_name") }}-->
        <!--</span>-->
                    <!--<input class="form-control login-input" type="text" name="iban_no" :placeholder="$t('front.iban_no')"-->
                           <!--v-model="form.iban_no">-->
                    <!--<span v-show="errors.has('iban_no')" class="text-error text-danger text-sm">-->
          <!--{{ errors.first("iban_no") }}-->
        <!--</span>-->
                    <!--<input class="form-control login-input" type="text" name="swift_code" :placeholder="$t('front.swift_code')"-->
                           <!--v-model="form.swift_code">-->
                    <!--<span v-show="errors.has('swift_code')" class="text-error text-danger text-sm">-->
          <!--{{ errors.first("swift_code") }}-->
        <!--</span>-->
                    <!--<input class="form-control login-input" type="text" name="bank_account_no" :placeholder="$t('front.bank_account_no')"-->
                           <!--v-model="form.bank_account_no">-->
                    <!--<span v-show="errors.has('bank_account_no')" class="text-error text-danger text-sm">-->
          <!--{{ errors.first("bank_account_no") }}-->
        <!--</span>-->

                    <div class="s-f">
                      <label for="" class="s-f">{{$t('front.commercial_registry_photo')}}</label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="custom-file-upload">
                          <button class="no-btn">
                            <i class="fas fa-upload"></i>
                            <span>{{$t('admin.choose_file')}}</span>
                          </button>
                          <input name="commercial_registry_photo" ref="commercial" v-validate="{ required:commerical_required}" @change="handleUploadFile($event, 'commercial')" type="file" />
                        <span v-show="errors.has('commercial_registry_photo')" class="text-error text-danger text-sm">
                          {{ errors.first("commercial_registry_photo") }}
                        </span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="profile-img-uploaded" v-if="form.commercial_registry_photo">
                          <a :href="form.commercial_registry_photo" target="_blank">
                            <img :src="form.commercial_registry_photo" alt="">
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="s-f">
                      <label for="" class="s-f">{{$t('front.profile_image')}}</label>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="custom-file-upload">
                          <button class="no-btn">
                            <i class="fas fa-upload"></i>
                            <span>{{$t('admin.choose_file')}}</span>
                          </button>
                          <input name="image" ref="profile" v-validate="{ required:image_required}" @change="handleUploadFile($event, 'profile')" type="file" />
                        <span v-show="errors.has('image')" class="text-error text-danger text-sm">
                          {{ errors.first("image") }}
                        </span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="profile-img-uploaded" v-if="form.image">
                          <a :href="form.image" target="_blank">
                            <img :src="form.image" alt="">
                          </a>
                        </div>
                      </div>
                    </div>
                      <!--<div class="flex-div">-->
                          <!--<div>-->
                              <!--<label class="grey">{{$t('front.select_activation_method')}}</label>-->
                          <!--</div>-->
                          <!--<div class="mr-d">-->
                              <!--<div class="pretty p-default p-round">-->
                                  <!--<input type="radio" name="send_type" checked value="sms"-->
                                         <!--v-model="form.send_type">-->
                                  <!--<div class="state">-->
                                      <!--<label>{{$t('front.via_sms')}}</label>-->
                                  <!--</div>-->
                              <!--</div>-->
                              <!--<div class="pretty p-default p-round">-->
                                  <!--<input type="radio" name="send_type" value="email"-->
                                         <!--v-model="form.send_type">-->
                                  <!--<div class="state">-->
                                      <!--<label>{{$t('front.via_email')}}</label>-->
                                  <!--</div>-->
                              <!--</div>-->
                          <!--</div>-->
                      <!--</div>-->
                    <button type="submit" class="button btn-gredient full">{{$t('front.register')}}</button>
                    <div class="inline-d">
                      <!-- <p class="grey">{{ $t('front.have_account') }}</p> -->
                      <!-- <nuxt-link class="blue" :to="localePath('login')">
                        {{ $t('front.make_login') }}
                      </nuxt-link> -->
                    </div>
                  </b-form>
                </div>
                  <!--<activation-modal-->
                          <!--:phone="form.phone"-->
                          <!--:email="form.email"-->
                          <!--:send_type="form.send_type"-->
                          <!--:country_code="form.country_code"-->
                          <!--:type="'activate'"-->
                          <!--v-if="stepper == 2"-->
                  <!--/>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--content-->
    <section class="order padd-t-60" v-if="stepper==1||stepper==2">
        <div class="container">
            <div class="text-center">
                <h3>{{$t('front.select_package')}}</h3>
                <!--<p class="grey">أختر الباقة حسب احتياجاتك</p>-->
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4" v-for="(item,key) in packages" :key="key">
                    <div class="package">
                        <img :src="item.image" alt="">
                        <div class="package-det">
                            <div class="flex-div">
                                <h4>{{item.name}}</h4>
                                <div>
                                    <div class="pretty p-svg p-round">
                                        <input v-validate="{required:true}" type="radio" name="package_id" v-model="form.package_id" @change="changePackage(item)" :value="item.id">
                                        <div class="state p-success">
                                            <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                <path path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                            </svg>
                                            <label> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <b-list-group flush>
                                <b-list-group-item></b-list-group-item>
                                <b-list-group-item>
                                    <i class="fas fa-arrow-up"></i>
                                    <!--<b-icon icon="arrow-up" class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon>-->
                                    {{item.product_number}} {{$t('admin.add_product')}}
                                </b-list-group-item>

                                <b-list-group-item>
                                    <i class="fas fa-arrow-up"></i>
                                    <!--<b-icon-check2-circle class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon-check2-circle>-->
                                    {{item.order_number}} {{$t('admin.order_available')}}
                                </b-list-group-item>

                                <b-list-group-item>
                                    <i class="fas fa-check-circle" v-if="item.has_chat"></i>
                                    <i class="fas fa-times-circle" v-else></i>
                                    <!--<b-icon-check2-circle v-if="package.has_chat" class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon-check2-circle>-->
                                    <b-icon-x-circle v-else class="h5 mr-2 mb-0 mt-0"></b-icon-x-circle>
                                    {{$t('admin.has_chat')}}
                                </b-list-group-item>

                                <b-list-group-item>
                                    <i class="fas fa-check-circle" v-if="item.is_rfq"></i>
                                    <i class="fas fa-times-circle" v-else></i>
                                    <!--<b-icon-check2-circle v-if="package.is_rfq" class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon-check2-circle>-->
                                    <b-icon-x-circle v-else class="h5 mr-2 mb-0 mt-0"></b-icon-x-circle>
                                    {{$t('admin.rfq')}}
                                </b-list-group-item>

                                <b-list-group-item></b-list-group-item>
                            </b-list-group>
                            <h6 class="red">{{item.price}} <small>{{$t('front.riyal')}}</small>/<span>{{item.months}}</span>  <small>{{$t('front.month')}}</small></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banks" v-if="stepper==2 && online_methods.length">
                <h3>{{$t('front.payment_method_id')}}</h3>
                <div v-for="(method, key) in online_methods" :key="`online${key}`" class="pretty p-default p-round col-4">
                    <input type="radio" v-validate="'required'" :value="method.id"
                           v-model="form.payment_method_id" name="payment_method_id" />
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

            <span v-show="errors.has('payment_method_id')" class="text-error text-danger text-sm">
                          {{ errors.first("payment_method_id") }}
                      </span>
            <div class="mr-30 text-center">
                <button class="button btn-gredient big" v-if="stepper==1" @click="send()">{{$t('front.next')}}
                    <img src="~assets/website/imgs/home/arrow-w.svg" alt=""></button>
                <button class="button btn-gredient big" v-if="stepper==2" @click="pay()">{{$t('front.register')}}
                    <img src="~assets/website/imgs/home/arrow-w.svg" alt=""></button>
                <button class="button btn-gredient big" @click="prevStep()">{{$t('front.back')}}
                    <img src="~assets/website/imgs/home/arrow-w.svg" alt=""></button>
            </div>

        </div>
    </section>
    </div>
</template>

<script src="./-index.js"></script>
<style scoped>
.profile-img-uploaded img{
  max-width: 200px;
  max-height: 150px;
}
</style>