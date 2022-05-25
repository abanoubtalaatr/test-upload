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
                                <div class="step" id="step-1" v-if="stepper == 1 || stepper==0">
                                    <h3>{{ $t('front.new_account') }}</h3>
                                    <p class="grey">{{ $t('front.new_account') }}</p>
                                    <b-form @submit.prevent="submit()" class="form">
                                        <input class="form-control login-input" type="text" name="name"
                                               :placeholder="$t('front.username')"
                                               v-model="form.name" v-validate="{ required: true }">
                                        <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                        {{ errors.first("name") }}
                      </span>

                                        <input class="form-control login-input" type="text" name="email"
                                               :placeholder="$t('front.email')"
                                               v-model="form.email" v-validate="{ required: true, email: true }">
                                        <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                        {{ errors.first("email") }}
                      </span>

                                        <!-- <VuePhoneNumberInput v-model="form.phone"
                                          v-validate="{ required: true }"
                                          :translations="translations"
                                          default-country-code="SA"
                                          @update="updatePhoneNumber"
                                          name="phone"
                                        /> -->
                                        <div class="input-group cntry-input">
                                            <select :title="$t('front.country_code')"
                                                    class="selectpicker form-control login-input"
                                                    v-model="form.country_code">
                                                <option v-for="(country, key) in countries" :key="`count${key}`"
                                                        :data-thumbnail="country.flag" :value="country.code"
                                                        :selected="country.code == '966'">
                                                    {{country.code}}
                                                </option>
                                            </select>
                                            <input class="form-control login-input" type="text" name="phone"
                                                   :placeholder="$t('front.phone')" @input="handlePhoneNumber"
                                                   v-model="form.phone"
                                                   v-validate="{ required: true, numeric: true, min: 7, max: 15 }">
                                        </div>
                                        <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                        {{ errors.first("phone") }}
                      </span>

                                        <input class="form-control login-input" type="password" name="password"
                                               :placeholder="$t('front.password')"
                                               v-model="form.password" v-validate="{ required: true, min: 8 }">
                                        <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                        {{ errors.first("password") }}
                      </span>
                                        <input class="form-control login-input" type="password"
                                               name="password_confirmation" :placeholder="$t('front.confirm_password')"
                                               v-model="form.password_confirmation"
                                               v-validate="{ required: true, min: 8 }">
                                        <span v-show="errors.has('password_confirmation')"
                                              class="text-error text-danger text-sm">
                        {{ errors.first("password_confirmation") }}
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

                                        <!--<input type="checkbox" v-model="form.confirmation"-->
                                               <!--v-validate="{ required: true}"-->
                                               <!--value="1" name="confirmation"/>-->

                                        <!--<label>{{this.$i18n.locale=='en'?settings.shopping_confirmation_en:settings.shopping_confirmation_ar}}</label>-->


                                        <!--<span v-show="errors.has('confirmation')"-->
                                              <!--class="text-error text-danger text-sm">-->
                        <!--{{ errors.first("confirmation") }}-->
                      <!--</span>-->
                                        <div class="flex-div">
                                            <div>
                                                <label class="grey">{{$t('front.select_activation_method')}}</label>
                                            </div>
                                            <div class="mr-d">
                                                <div class="pretty p-default p-round">
                                                    <input type="radio" name="send_type" checked value="sms"
                                                           v-model="form.send_type">
                                                    <div class="state">
                                                        <label>{{$t('front.via_sms')}}</label>
                                                    </div>
                                                </div>
                                                <div class="pretty p-default p-round">
                                                    <input type="radio" name="send_type" value="email"
                                                           v-model="form.send_type">
                                                    <div class="state">
                                                        <label>{{$t('front.via_email')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="button btn-gredient full">{{ $t('front.register') }}
                                        </button>
                                        <div class="inline-d">
                                            <p class="grey">{{ $t('front.have_account') }}</p>
                                            <nuxt-link class="orange" :to="localePath('login')">
                                                {{ $t('front.make_login') }}
                                            </nuxt-link>
                                        </div>
                                    </b-form>
                                </div>
                                <div class="step" v-if="stepper == 0">
                                    <h3>{{$t('front.select_activation_method')}}</h3>
                                    <div class="inline-d">
                                        <!--<p class="grey">{{$t('front.activate_hint')}}</p>-->
                                        <!-- <a class="blue mr-5">
                                            {{$t('front.change')}}
                                        </a> -->
                                    </div>
                                    <div class="form">
                                        <b-form @submit.prevent="submit()" class="form">
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
                                <activation-modal
                                        :phone="form.phone"
                                        :email="form.email"
                                        :send_type="form.send_type"
                                        :country_code="form.country_code"
                                        :type="'activate'"
                                        v-if="stepper == 2"
                                />

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
