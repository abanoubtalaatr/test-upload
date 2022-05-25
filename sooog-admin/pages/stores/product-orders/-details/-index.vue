<template>
    <card-component :title="item.name" icon="fas fa-clipboard-list 5x">
        <div class="countries">
          <div class="level">
            <b-row>
                <b-col lg="6">
                    <p><span style="color:green;">{{$t('admin.order_no') + ' : '}}</span> {{ item.id }}</p>
                    <p><span style="color:green;">{{$t('admin.order_status') + ' : '}}</span>  {{ item.status.name }}</p>
                    <p><span style="color:green;">{{$t('admin.payment_method') + ' : '}}</span>  {{ item.payment_method.name }}</p>
                    <p><span style="color:green;">{{$t('admin.created_at') + ' : ' }}</span>  {{ item.created_at }}</p>
                    <p><span style="color:green;">{{$t('admin.user') + ' : ' }}</span>  <nuxt-link :to="localePath(`/dashboard/users/${item.user.id}`)">{{ item.user.name }}</nuxt-link></p>
                    <p><span style="color:green;">{{$t('admin.address') + ' : ' }}</span>  {{item.user_address.address }}</p>
                    <p><span style="color:green;">{{$t('admin.city') + ' : ' }}</span>  {{item.user_address.city.name }}</p>
                    <p><span style="color:green;">{{$t('admin.state') + ' : ' }}</span>  {{item.user_address.city.state.name }}</p>
                    <p><span style="color:green;">{{$t('admin.country') + ' : ' }}</span>  {{item.user_address.city.state.country.name }}</p>
                </b-col>
                <b-col lg="6" v-if="type=='stores'">
                    <p><span style="color:green;">{{$t('admin.subtotal') + ' : '}}</span>  {{ item.subtotal }}</p>
                    <p><span style="color:green;">{{$t('admin.order_added_tax') + ' : '}}</span>  {{ item.order_added_tax }}</p>
                    <p><span style="color:green;">{{$t('admin.promo_code_discount') + ' : '}}</span>  {{ item.promo_code_discount }}</p>
                    <p><span style="color:green;">{{$t('admin.delivery_charge') + ' : ' }}</span>  {{ item.delivery_charge }}</p>
                    <!--<p><span style="color:green;">{{$t('admin.warranties_amount') + ' : ' }}</span>  {{ item.warranties_amount }}</p>-->
                    <p><span style="color:green;">{{$t('admin.total') + ' : ' }}</span>  {{item.total }}</p>
                </b-col>
                <b-col lg="6" v-if="type=='centers'">
                    <p><span style="color:green;">{{$t('admin.service') + ' : '}}</span>  {{ item.service.service.name }}</p>
                    <p><span style="color:green;">{{$t('admin.preview_fees') + ' : '}}</span>  {{ item.service.preview_fees }}</p>
                    <p><span style="color:green;">{{$t('admin.service_price') + ' : '}}</span>  {{ item.service.service_price }}</p>
                    <p><span style="color:green;">{{$t('admin.category') + ' : '}}</span>  {{ item.service.subcategory.name }}</p>
                    <p><span style="color:green;">{{$t('admin.problem_description') + ' : '}}</span>  {{ item.service.problem_description }}</p>
                    <p><span style="color:green;">{{$t('admin.promo_code_discount') + ' : ' }}</span>  {{item.promo_code_discount }}</p>
                    <p><span style="color:green;">{{$t('admin.subtotal') + ' : ' }}</span>  {{item.subtotal }}</p>
                    <p><span style="color:green;">{{$t('admin.order_added_tax') + ' : ' }}</span>  {{item.order_added_tax }}</p>
                    <p><span style="color:green;">{{$t('admin.total') + ' : ' }}</span>  {{item.total }}</p>
                </b-col>
            </b-row>
            <a target="_blank" v-if="item.catalog" :href="item.catalog">
                  <object width="120" height="50" type="application/pdf"
                  :data="item.catalog" class="img-thumbnail" />
                </a>
          </div>
          <hr/>
          <div class="level" v-if="item.notes">
            <b-row>
              <b-col lg="12">
                <p><span style="color:green;">{{$t('admin.notes') + ' : '}}</span>{{item.notes}} </p>
              </b-col>
            </b-row>
          </div>

          <div class="level" v-if="item.payment_method.type == 'bank_transfer'">
            <b-row>
                <b-col lg="12">
                    <p><span style="color:green;">{{$t('admin.bank_transfer_info') + ' : '}}</span></p>
                    <p><span style="color:green;">{{$t('admin.depositor_name') + ' : '}}</span>{{ item.bank_transfer.depositor_name }}</p>
                    <p><span style="color:green;">{{$t('admin.deposit_amount') + ' : '}}</span>{{ item.bank_transfer.deposit_amount }}</p>
                    <p><span style="color:green;">{{$t('admin.deposit_receipt') + ' : '}}</span></p>
                    <a target="_blank" :href="item.bank_transfer.deposit_receipt">
                        <object v-if="item.bank_transfer.file_type == 'pdf'" width="120" height="50" type="application/pdf"
                        :data="form.catalog" class="img-thumbnail" />
                        <b-img
                            v-else
                            :lazy-src="item.bank_transfer.deposit_receipt"
                            :src="item.bank_transfer.deposit_receipt"
                            class="img-fluid"
                        />
                    </a>
                </b-col>
            </b-row>
          </div>
          <hr/>

          <div class="table_wrap" v-if="type=='stores' && item.items.length > 0">
              <h3 style="color:green;">{{$t('admin.order_items')}}</h3>
              <Table
              :collection="item.items"
              :records="itemsData"
              >
              </Table>
          </div>
          <hr/>
          <div class="table_wrap" v-if="item.statuses.length > 0">
              <h3 style="color:green;">{{$t('admin.order_statuses')}}</h3>
              <Table
              :collection="item.statuses"
              :records="statusesData"
              >
              </Table>
          </div>
          <hr/>
        <div class="text-center mt-3 mb-2">
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>
    </div>
      </card-component>
</template>

<script src="./-index.js"></script>
