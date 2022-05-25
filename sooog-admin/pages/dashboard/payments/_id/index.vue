<template>
 <div>
    <title-bar :title-stack="titleStack" />
    <card-component :title="item.name" icon="fas fa-clipboard-list 5x">
      <div class="countries">
        <div class="level">
          <b-row>
              <b-col lg="6">
                  <p><span style="color:green;">{{$t('admin.payment_no') + ' : '}}</span> {{ item.id }}</p>
                  <p><span style="color:green;">{{$t('admin.store') + ' : '}}</span>  {{ item.store.name }}</p>
                  <p><span style="color:green;">{{$t('admin.reserved_amount') + ' : '}}</span>
                  {{ item.total }}
                  <span>{{$t('admin.riyal')}}</span>
                  </p>

                  <p><span style="color:green;">{{$t('admin.commission_percentage') + ' : ' }}</span>
                  {{ item.application_dues_percentage }}
                  <span>%</span>
                  </p>

              </b-col>

               <b-col lg="6">

                  <p><span style="color:green;">{{$t('admin.commission_value') + ' : ' }}</span>
                  {{ item.application_dues }}
                  <span>{{$t('admin.riyal')}}</span>
                  </p>
                  <p><span style="color:green;">{{$t('admin.amount_before_commission') + ' : ' }}</span>
                  <span>{{ (Number(item.total) - Number(item.application_dues)).toFixed(2) }}</span>
                  <span>{{$t('admin.riyal')}}</span>
                  </p>

                  <p><span style="color:green;">{{$t('admin.payment_file') + ' : ' }}</span>
                    <a target="_blank" :href="item.receipt">{{$t('admin.payment_attachment')}}</a>
                  </p>

              </b-col>

          </b-row>
        </div>
        <hr/>
        <div class="table_wrap" v-if="item.orders.length > 0">
            <h3 style="color:green;">{{$t('admin.orders')}}</h3>
            <Table
            :collection="item.orders"
            :records="itemsData"
            >

            <template v-slot:cell(id)="el">
            <nuxt-link :to="localePath(`/dashboard/product-orders/${el.item.id}`)">{{ Number(el.item.id) }}</nuxt-link>
          </template>

          <template v-slot:cell(store)="el">
            <span class="green">{{ el.item.store.name }}</span>
          </template>

          <template v-slot:cell(total)="el">
            <span>{{ Number(el.item.total) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

          <!-- <template v-slot:cell(application_dues_percentage)="el">
            <span>{{ Number(el.item.application_dues_percentage) }}</span>
            <span>%</span>
          </template>

          <template v-slot:cell(application_dues)="el">
            <span>{{ Number(el.item.application_dues) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template> -->

          <template v-slot:cell(amount_before_commission)="el">
            <span>{{ (Number(el.item.total) - Number(el.item.application_dues)).toFixed(2) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

            </Table>
        </div>
        <hr/>
      <div class="text-center mt-3 mb-2">
          <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
      </div>
  </div>
    </card-component>
 </div>
</template>

<script src="./index.js"></script>

