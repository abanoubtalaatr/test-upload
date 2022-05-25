<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <h4 class="mt-0 text-center" >{{titlePage}}</h4>
    <b-container align-v="center" class="container">
      <div class="mt-5">
        <b-card-group deck class="mb-3">
          <!-- card 1 -->
          <b-card v-for="(item,key) in collection" :key="key"
                  :border-variant="`${item.is_free?'default':'info'}`"
            :header="item.name"
                  header-class="text-center"
            :header-bg-variant="`${item.is_free?'secondary':'info'}`"
            header-text-variant="white"
            align="center"
                  body-class="text-center"
           :title="`${item.price} ${$t('admin.sar')} /${item.months} ${$t('admin.month')}`"
            style="max-width: auto;"
            class="mb-4 mt-2">
            <b-card-text>
              <b-card-img :src="item.image" alt="Image" bottom></b-card-img>
            </b-card-text>
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
                <!--<b-icon-check2-circle v-if="item.has_chat" class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon-check2-circle>-->
                <b-icon-x-circle v-else class="h5 mr-2 mb-0 mt-0"></b-icon-x-circle>
                {{$t('admin.has_chat')}}
              </b-list-group-item>

              <b-list-group-item>
                <i class="fas fa-check-circle" v-if="item.is_rfq"></i>
                <i class="fas fa-times-circle" v-else></i>
                <!--<b-icon-check2-circle v-if="item.is_rfq" class="h5 mr-2 mb-0 mt-0" animation="fade"></b-icon-check2-circle>-->
                <b-icon-x-circle v-else class="h5 mr-2 mb-0 mt-0"></b-icon-x-circle>
                {{$t('admin.rfq')}}
              </b-list-group-item>

              <b-list-group-item></b-list-group-item>
            </b-list-group>
            <br/>
            <b-button v-if="item.subscribed"  v-b-modal.modal-2 variant="success" class="text-center"><i class="fas fa-check-circle"></i></b-button>
            <b-button v-else v-b-modal.modal-2 variant="primary" :disabled="submitted" @click="subscribe(item)" class="text-center">{{$t('admin.subscribe')}}</b-button>
            <br/>
          </b-card>
        </b-card-group>
        <card-component :title="$t('admin.payment_methods')" v-if="stepper==2">
          <!--<h3>{{$t('front.payment_method_id')}}</h3>-->
          <div v-for="(method, key) in online_methods" :key="`online${key}`" class="pretty p-default p-round col-2">
            <input type="radio" v-validate="'required'" :value="method.id"
                   v-model="form.payment_method_id" name="payment_method_id" />
            <div class="state bank-s">
              <span>{{method[currentLocale]}}</span>
              <img :src="method.image" width="100" alt=""/>

            </div>
          </div>
          <div class="text-center mt-3 mb-2">
            <Button @clickFn="pay()" size="sm" bgGreen :disabled="submitted">{{$t('admin.pay')}}</Button>
          </div>
        </card-component>
      </div>
      <!-- card 1 ends here-->
    </b-container>
  </div>

</template>
<script src="./index.js"></script>

<style :scoped>
  .fa-times-circle{
    color: #ff597b;
  }
  .fa-arrow-up{
    color: #2697e5;
  }
  .fa-check-circle{
    color: #2ff703;
  }
  </style>
