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

            <h3>{{$t('front.myorders')}}</h3>
            <p class="grey">{{$t('front.display_all_myorders')}}</p>

            <!--addresses-->
            <section class="acc-orders">

              <div class="table-responsive" v-if="collection.length">
                <table class="table blue-t table-striped">
                  <tr>
                    <th>{{$t('front.operation_id')}}</th>
                    <th>{{$t('front.by_date')}} </th>
                    <th>{{$t('front.shipping_address')}}</th>
                    <th>{{$t('front.cost')}}</th>
                    <th>{{$t('front.status')}}</th>
                    <th> </th>
                  </tr>
                  <tr v-for="(order, key) in collection" :key="key">
                    <td>
                      <p>{{`${order.id}A`}}</p>
                    </td>
                    <td>
                      <p>{{order.created_at}}</p>
                    </td>
                    <td>
                      <p>
                        {{ order.user_address.title }} - {{ order.user_address.city.name || '' }} - {{ order.user_address.city.state.name || '' }}
                      </p>
                    </td>
                    <td>
                      <div class="h6 price">{{order.total}}<span>{{$t('front.riyal')}}</span></div>
                    </td>
                    <td>
                      <button :class="`acc-btn ${order.status.key == 'new' ? 'btn-default' : (order.status.key == 'canceled' ? 'btn-del' : 'btn-confirm')}`">
                        {{order.status.name}}
                      </button>
                    </td>
                    <td><nuxt-link :to="localePath(`/orders/${order.id}`)" class="orange2" >
                      {{$t('front.details')}}
                      </nuxt-link></td>
                  </tr>
                </table>
              </div>

              <div v-else class="text-center alert-div">
                {{$t('front.no_results')}}
              </div>

              <Pagination
                :pagination="meta"
                v-if="meta && meta.last_page != 1"
                @page-changed="onPageChange($event)"
                @prev-page="prevPage($event)"
                @next-page="nextPage($event)"
              />

            </section>

          </div>
        </div>
      </div>
      </client-only>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
