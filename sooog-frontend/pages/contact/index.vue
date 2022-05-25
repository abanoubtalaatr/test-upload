<template>
  <!-- Main Content-->
  <main class="main-content">
    <!--content-->
    <section class="contact-us custom-padd">
      <div class="container">
        <h3>{{$t('front.how_can_help_you')}}</h3>
        <p class="grey">{{$t('front.contact_desc')}}</p>
        <b-form @submit.prevent="create()" class="form">
          <div class="row">

            <div class="col-md-6">
              <div class="contact-form">
                <input class="form-control login-input" name="name" v-model="form.name"
                       v-validate="{ required: true, min:3,max:75 }" type="text" :placeholder="$t('front.name')">
                <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                        {{ errors.first("name") }}
                      </span>

                <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')"
                       v-model="form.phone" v-validate="{ required: true, numeric: true,min:5, max: 15 }">
                <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                        {{ errors.first("phone") }}
                      </span>
                <input class="form-control login-input" type="text" name="email" :placeholder="$t('front.email')"
                       v-model="form.email" v-validate="{ required: true, email: true }">
                <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                        {{ errors.first("email") }}
                      </span>
                <input class="form-control login-input" name="title" v-model="form.title"
                       v-validate="{ required: true, min:3,max:75 }" type="text" :placeholder="$t('front.title')">
                <span v-show="errors.has('title')" class="text-error text-danger text-sm">
                        {{ errors.first("title") }}
                      </span>
                <!--<select class="form-control login-input" name="type" v-model="type"  v-validate="{ required: true }">-->
                <!--<option selected value="" disabled>{{$t('front.select_complain_type')}}...</option>-->

                <!--</select>-->
                <textarea class="form-control login-input" name="body" cols="30" rows="10" v-model="form.body"
                          v-validate="{ required: true, min:3 }" :placeholder="$t('front.body')"></textarea>
                <span v-show="errors.has('body')" class="text-error text-danger text-sm">
                        {{ errors.first("body") }}
                      </span>
                <button type="submit" class="button btn-gredient full">{{$t('front.send')}}</button>
              </div>
            </div>
            <client-only>
              <div class="col-md-6" v-if="settings">
                <h4>{{$t('front.you_can_contact_via')}}</h4>
                <!--<p class="grey">سيتم التواصل معك بعد ان تصلنا رسالتك او شكوتك في اقل من 24 ساعة</p>-->
                <h6 class="grey">{{$t('front.email_support')}}</h6>
                <div class="inline-d"><span class="brown">{{settings.email}}</span><img src="~/assets/website/imgs/home/msg.svg"
                                                                              alt=""></div>
                <h6 class="grey">{{$t('front.support_via_mobile')}}</h6>
                <div class="inline-d"><span class="brown">{{settings.phone}}</span><img src="~/assets/website/imgs/home/phone.svg"
                                                                              alt=""></div>
                <h6 class="grey">{{$t('front.shop_from_apps')}}</h6>
                <ul class="download">
                  <li><a :href="settings.apple_store" target="_blank"><img src="~/assets/website/imgs/home/google-play.png"
                                                                  alt=""></a></li>
                  <li><a :href="settings.google_store" target="_blank"><img src="~/assets/website/imgs/home/app-store.png"
                                                                alt=""></a>
                  </li>
                </ul>
                <h6 class="grey">{{$t('front.contact_us')}}</h6>
                <ul class="social-footer">
                  <li><a :href="settings.youtube" target="_blank"><i class="fab fa-youtube"></i></a></li>
                  <li><a :href="settings.facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a :href="settings.instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
                  <li><a :href="settings.twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>
                </ul>
              </div>
            </client-only>
          </div>
        </b-form>
      </div>
    </section>
  </main>
  <!-- End Main Content-->
</template>


<script src="./index.js"></script>
