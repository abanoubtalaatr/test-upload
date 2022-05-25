<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--login-content-->
      <section class="login-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="l-form">
                <div class="text-center" v-if="stepper == 1">
                  <h3>{{ $t('front.login') }}</h3>
                  <p class="grey">{{ $t('front.add_all_data') }}</p>
                  <b-form @submit.prevent="submit()" class="form">
                    <!-- <VuePhoneNumberInput v-model="form.phone"
                      v-validate="{ required: true }"
                      :translations="translations"
                      default-country-code="SA"
                      @update="updatePhoneNumber"
                      name="phone"
                    /> -->
                    <div class="input-group cntry-input">
                      <select :title="$t('front.country_code')" class="selectpicker form-control login-input" v-model="form.country_code" >
                        <option v-for="(country, key) in countries" :key="`count${key}`"

                          :data-thumbnail="country.flag" :value="country.code" :selected="country.code == '966'">
                          {{country.code}}
                        </option>
                      </select>
                      <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')" @input="handlePhoneNumber"
                        v-model="form.phone" v-validate="{ required: true, numeric: true, min: 7, max: 15 }">
                    </div>
                    <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                      {{ errors.first("phone") }}
                    </span>
                    <!-- </div> -->
                    <input class="form-control login-input" type="password" name="password" :placeholder="$t('front.password')"
                      v-model="form.password" v-validate="{ required: true, min: 8 }">
                    <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                      {{ errors.first("password") }}
                    </span>

                    <div class="row">
                      <div class="col-6 text-left">
                        <input class="grey" type="checkbox" v-model="form.remember" id="remember-check">
                        <label class="yellow" for="remember-check">{{ $t('front.remember') }}</label>
                      </div>
                      <div class="col-6 text-right">
                        <nuxt-link class="grey" :to="localePath('password-forget')">{{ $t('front.qs_forget_password') }}</nuxt-link>
                      </div>
                    </div>
                    <button type="submit" class="button btn-gredient full">{{ $t('front.login') }}</button>
                    <div class="inline-d">
                      <p class="grey">{{ $t('front.not_have_account') }}</p>
                      <nuxt-link class="orange" :to="localePath('register')">
                        {{ $t('front.new_account') }}
                      </nuxt-link>
                    </div>
                  </b-form>
                </div>

                <activation-modal
                    :phone="form.phone"
                    :country_code="form.country_code"
                    :type="'activate'"
                    v-if="stepper == 2"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>
    <!-- End Main Content-->
</template>


<script src="./index.js"></script>
