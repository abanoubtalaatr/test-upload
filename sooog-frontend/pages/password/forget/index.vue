<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--login-content-->
      <section class="login-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="l-form">
                <div class="text-center">
                  <div class="step" v-if="stepper == 0">
                    <h3>{{$t('front.forget_password_method')}}</h3>
                    <div class="inline-d">
                      <!--<p class="grey">{{$t('front.activate_hint')}}</p>-->
                      <!-- <a class="blue mr-5">
                          {{$t('front.change')}}
                      </a> -->
                    </div>
                    <div class="form">
                      <b-form @submit.prevent="nextStep()" class="form">
                        <div class="col-12">
                          <div class="s-f">
                            <input type="radio" name="send_type" checked value="sms"
                                   v-model="form.send_type">
                            <label for="">{{$t('front.via_sms')}}</label>
                          </div>
                          <div class="s-f">
                            <input type="radio" name="send_type" value="email"
                                   v-model="form.send_type">
                            <label for="">{{$t('front.via_email')}}</label>
                          </div>
                        </div>
                        <button type="submit" class="button btn-gredient full">{{
                          $t('front.next') }}
                        </button>
                      </b-form>
                    </div>
                  </div>
                  <div class="step" id="step-1" v-if="stepper == 1">
                    <h3>{{ $t('front.forget_password') }}</h3>
                    <p class="grey" v-if="form.send_type=='sms' ">{{ $t('front.forget_password_hint') }}</p>
                    <p class="grey" v-if="form.send_type=='email' ">{{ $t('front.forget_password_email_hint') }}</p>
                    <b-form @submit.prevent="submit()" class="form">
                      <!-- <VuePhoneNumberInput v-model="form.phone"
                        v-validate="{ required: true }"
                        :translations="translations"
                        default-country-code="SA"
                        @update="updatePhoneNumber"
                        name="phone"
                      /> -->
                      <div class="input-group cntry-input" v-if="form.send_type=='sms' ">
                        <select :title="$t('front.country_code')" class="selectpicker form-control login-input" v-model="form.country_code">
                          <option v-for="(country, key) in countries" :key="`count${key}`"
                            :data-thumbnail="country.flag" :value="country.code" :selected="country.code == '966'">
                            {{country.code}}
                          </option>
                        </select>
                        <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')" @input="handlePhoneNumber"
                          v-model="form.phone" v-validate="{ required: true, numeric: true, min: 7, max: 15 }">
                      </div>
                      <div class="input-group cntry-input" v-if="form.send_type=='email'">
                        <input class="form-control login-input" type="email" name="email" :placeholder="$t('front.email')" v-model="form.email" v-validate="{ required: true, email: true, min: 10, max: 75 }">
                      </div>
                      <span v-show="errors.has('phone')" class="text-error text-danger text-sm" v-if="form.send_type=='sms' ">
                        {{ errors.first("phone") }}
                      </span>
                      <span v-show="errors.has('email')" class="text-error text-danger text-sm" v-if="form.send_type=='email' ">
                        {{ errors.first("email") }}
                      </span>
                      <button type="submit" class="button btn-gredient full">{{ $t('front.next') }}</button>

                    </b-form>
                  </div>

                  <activation-modal
                    :phone="form.phone"
                    :email="form.email"
                    :send_type="form.send_type"
                    :country_code="form.country_code"
                    :type="type"
                    v-if="stepper == 2"
                  />

                  <div class="step" id="step-1" v-if="stepper == 3">
                    <h3>{{ $t('front.update_password') }}</h3>
                    <p class="grey">{{ $t('front.add_all_data') }}</p>
                    <b-form @submit.prevent="submit()" class="form">
                      <input class="form-control login-input" type="password" name="password" :placeholder="$t('front.new_password')"
                        v-model="payload.password" v-validate="{ required: true, min: 8 }">
                      <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                        {{ errors.first("password") }}
                      </span>

                       <input class="form-control login-input" type="password" name="password_confirmation" :placeholder="$t('front.confirm_password')"
                        v-model="payload.password_confirmation" v-validate="{ required: true, min: 8 }">
                      <span v-show="errors.has('password_confirmation')" class="text-error text-danger text-sm">
                        {{ errors.first("password_confirmation") }}
                      </span>

                      <button type="submit" class="button btn-gredient full">{{ $t('front.confirm') }}</button>

                    </b-form>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <!-- End Main Content-->
</template>


<script src="./index.js"></script>
