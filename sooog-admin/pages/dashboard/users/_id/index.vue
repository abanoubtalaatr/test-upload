<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="item.name" icon="fas fa-clipboard-list 5x">
        <div class="countries">
          <div class="level">
            <nuxt-link :to="localePath(`/dashboard/users/${param_id}/transactions`)"
            class="btn btn-success"
            v-show="permissions.includes('users.transactions')"
          >
            <!-- <i class="fas fa-dollar"></i> -->
            {{ $t("admin.transactions") }}
          </nuxt-link>
          <br><br>
            <b-row>
                <b-col md="6">
                    <p><span style="color:green;">{{$t('admin.name') + ' : '}}</span> {{ item.name }}</p>
                    <p><span style="color:green;">{{$t('admin.phone') + ' : '}}</span>  {{ item.phone }}</p>
                    <p><span style="color:green;">{{$t('admin.email') + ' : '}}</span>  {{ item.email }}</p>
                    <!-- <p>{{$t('gender') + ' : ' }} {{ item.gender }}</p> -->
                    <p><span style="color:green;">{{$t('admin.wallet') + ' : ' }}</span>  {{ item.wallet }}</p>
                    <p><span style="color:green;">{{$t('admin.status') + ' : ' }}</span>  {{item.is_active ? $t('active') : $t('inactive')}}</p>

                </b-col>
                <b-col md="6">
                  <img v-if="item.avatar" :src="item.avatar"/>
                </b-col>
            </b-row>
          </div>
          <hr>
          <div class="table_wrap" v-if="item.addresses.length > 0">
              <h3 style="color:green;">{{$t('admin.user_addresses')}}</h3>
              <Table
              :collection="item.addresses"
              :records="addressesData"
              >
              </Table>
          </div>
        <div class="text-center mt-3 mb-2">
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>
    </div>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

