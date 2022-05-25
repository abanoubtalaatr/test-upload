<template>
  <section class="benefits">
    <div class="container">
      <div class="row">
        <div class="col-6 col-md-4">
          <div class="benefit"><img src="~/assets/website/imgs/home/shipping.svg" alt="">
            <div class="benefit-txt">
              <p>{{$t('front.fast_shipping')}}</p>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="benefit"><img src="~/assets/website/imgs/home/refund.svg" alt="">
            <div class="benefit-txt">
              <p>{{$t('front.money_refund')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="benefit"><img src="~/assets/website/imgs/home/support.svg" alt="">
            <div class="benefit-txt">
              <p>{{$t('front.technical_support')}} </p><span class="yellow">24/7</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState } from 'vuex'

  export default {
    data () {
      return {

      }
    },
    computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      settings: state => state.localStorage.settings,
    })
  },
    methods: {

    }
  }
</script>

