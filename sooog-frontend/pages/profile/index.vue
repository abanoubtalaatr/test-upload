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
            <!--profile-info-->
            <section class="profile" v-if="stepper == 0">
              <div class="row">
                <div class="col-6">
                  <h3>{{$t('front.profile')}}</h3>
                  <p class="grey">
                    {{$t('front.mypersonal_data')}}
                  </p>
                </div>
                <div class="col-6 text-right">
                  <button class="edit-info" id="edit-profile" @click="updateStep(1)">
                    {{$t('front.edit')}}
                  </button>
                </div>
              </div>
              <div class="border-b">
                <p>{{$t('front.name')}}</p>
                <h5 class="grey">{{authUser.name}}</h5>
              </div>
              <div class="border-b">
                <p>{{$t('front.email')}}</p>
                <h5 class="grey">
                  {{authUser.email}}
                </h5>
              </div>
              <div class="border-b">
                <div class="row">
                  <div class="col-6">
                    <p>{{$t('front.phone')}}</p>
                    <h5 class="grey">
                      {{authUser.phone}}
                    </h5>
                  </div>
                  <div class="col-6 text-right">
                    <button class="edit-info" id="edit-phone" @click="updateStep(2)">
                      {{$t('front.edit')}}
                    </button>
                  </div>
                </div>
              </div>
              <!-- <div class="border-b">
                <p>المدينة</p>
                <h5 class="grey">المدينة</h5>
              </div> -->
              <div class="border-b">
                <div class="row">
                  <div class="col-6">
                    <p>{{$t('front.password')}}</p>
                    <h5 class="grey">***********</h5>
                  </div>
                  <div class="col-6 text-right">
                    <button class="edit-info" id="edit-pass" @click="updateStep(3)">
                      {{$t('front.edit')}}
                    </button>
                  </div>
                </div>
              </div>
            </section>
            <div v-if="stepper == 1">
              <h3>{{$t('front.edit')}} {{$t('front.profile')}}</h3>
              <p class="grey">{{$t('front.mypersonal_data')}}</p>

              <div class="form">
                <b-form @submit.prevent="submit()" class="form">
                  <input class="form-control login-input" type="text" name="name" :placeholder="$t('front.name')"
                    v-model="form.name" v-validate="{ required: true }">
                  <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                    {{ errors.first("name") }}
                  </span>

                  <input class="form-control login-input" type="text" name="email" :placeholder="$t('front.email')"
                    v-model="form.email" v-validate="{ required: true, email: true }">
                  <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                    {{ errors.first("email") }}
                  </span>

                  <div class="row" :key="uniqueId">
                    <div class="col-md-12">
                      <div class="custom-file-upload">
                        <button class="no-btn">
                          <i class="fas fa-upload"></i>
                          <span>{{$t('admin.choose_file')}}</span>
                        </button>
                        <input name="image" ref="profile" @change="handleUploadFile" type="file" />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="profile-img-uploaded">
                        <a :href="form.avatar" target="_blank">
                          <img :src="form.avatar" alt="">
                        </a>
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="button btn-green big">{{$t('front.save')}} </button>
                  <button class="no-btn prev-profile" @click="resetStep">{{$t('front.back')}}</button>
                </b-form>
              </div>
            </div>
            <div v-if="stepper == 2">
                <h3>{{$t('front.edit')}} {{$t('front.phone')}}</h3>
                <p class="grey">{{$t('front.enter_new_phone')}}</p>
                <div class="form">
                  <b-form @submit.prevent="submit()" class="form">
                    <!-- <VuePhoneNumberInput v-model="form.phone"
                      v-validate="{ required: true }"
                      :translations="translations"
                      default-country-code="SA"
                      @update="updatePhoneNumber"
                      name="phone"
                    /> -->
                    <div class="input-group cntry-input">
                      <select :title="$t('front.country_code')" disabled="disabled" class="selectpicker form-control login-input" v-model="form.country_code">
                        <option v-for="(country, key) in countries" :key="`count${key}`"
                          :data-thumbnail="country.flag" :value="country.code">
                          {{country.code}}
                        </option>
                      </select>
                      <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')" @input="handlePhoneNumber"
                        v-model="form.phone" v-validate="{ required: true, numeric: true, min: 7, max: 15 }">
                    </div>
                    <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                      {{ errors.first("phone") }}
                    </span>
                    <br>
                    <button type="submit" class="button btn-green big">{{ $t('front.next') }}</button>
                    <button class="no-btn prev-profile" @click="resetStep">{{$t('front.back')}}</button>
                  </b-form>

                </div>
            </div>
            <div v-if="stepper == 4">
              <h3>{{$t('front.edit')}} {{$t('front.phone')}}</h3>
                <p class="grey">{{$t('front.enter_new_phone')}}</p>
              <div class="form text-center grey-back">
                  <activation-modal
                    :phone="form.phone"
                    :country_code="form.country_code"
                    :type="'phone'"
                  />
              </div>
            </div>
            <div v-if="stepper == 3">
              <h3>{{$t('front.edit')}} {{$t('front.password')}}</h3>
              <p class="grey">{{$t('front.enter_new_password')}}</p>
              <div class="form">
                <b-form @submit.prevent="submit()" class="form">
                  <input class="form-control login-input" type="password" name="old_password" :placeholder="$t('front.old_password')"
                    v-model="payload.old_password" v-validate="{ required: true, min: 8 }">
                  <span v-show="errors.has('old_password')" class="text-error text-danger text-sm">
                    {{ errors.first("old_password") }}
                  </span>
                  <input class="form-control login-input" type="password" name="password" :placeholder="$t('front.new_password')"
                    v-model="payload.new_password" v-validate="{ required: true, min: 8 }">
                  <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                    {{ errors.first("password") }}
                  </span>

                    <input class="form-control login-input" type="password" name="password_confirmation" :placeholder="$t('front.confirm_password')"
                    v-model="payload.new_password_confirmation" v-validate="{ required: true, min: 8 }">
                  <span v-show="errors.has('password_confirmation')" class="text-error text-danger text-sm">
                    {{ errors.first("password_confirmation") }}
                  </span>
                  <br>
                  <button class="button btn-green big">{{$t('front.next')}} </button>
                  <button class="no-btn prev-profile" @click="resetStep">{{$t('front.back')}}</button>
                </b-form>
              </div>
            </div>
          </div>
        </div>
      </div>
      </client-only>
    </main>
    <!-- End Main Content-->
</template>


<script src="./index.js"></script>
