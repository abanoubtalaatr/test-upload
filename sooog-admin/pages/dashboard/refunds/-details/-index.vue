<template>
    <card-component :title="item.name" icon="fas fa-clipboard-list 5x">
        <div class="countries">
          <div class="level">
            <b-row>
                <b-col lg="6">
                    <p><span style="color:green;">{{$t('admin.order_no') + ' : '}}</span> {{ item.id }}</p>
                    <p><span style="color:green;">{{$t('admin.refund_reason') + ' : '}}</span>  {{ item.refund_reason.name || item.note }}</p>
                    <p><span style="color:green;">{{$t('admin.refund_type') + ' : '}}</span>  {{ $t(`${item.refund_type}`) }}</p>
                    <p><span style="color:green;">{{$t('admin.order_status') + ' : '}}</span>  {{ item.status.name }}</p>
                    <p><span style="color:green;">{{$t('admin.created_at') + ' : ' }}</span>  {{ item.created_at }}</p>
                    <p><span style="color:green;">{{$t('admin.user') + ' : ' }}</span>  <nuxt-link :to="localePath(`/dashboard/users/${item.order.user.id}`)">{{ item.order.user.name }}</nuxt-link></p>
                    <p><span style="color:green;">{{$t('admin.order') + ' : ' }}</span>  <nuxt-link :to="localePath(`/dashboard/product-orders/${item.order.id}`)">{{ $t('admin.order_details') }}</nuxt-link></p>
                </b-col>
                <b-col lg="6">
                    <p><span style="color:green;">{{$t('admin.subtotal') + ' : '}}</span>  {{ item.subtotal }}</p>
                    <p><span style="color:green;">{{$t('admin.promo_code_discount') + ' : '}}</span>  {{ item.promo_code_discount }}</p>
                    <p><span style="color:green;">{{$t('admin.total') + ' : ' }}</span>  {{item.total }}</p>
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
          
        <div class="text-center mt-3 mb-2">
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>
    </div>
      </card-component>
</template>

<script src="./-index.js"></script>
