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
            <!--addresses-->
            <section class="profile">

              <h3>{{$t('front.myservices')}}</h3>
              <p class="grey">{{$t('front.display_all_myservices')}}</p>

              <div class="table-responsive" v-if="collection.length">
                <table class="table table-striped">
                  <tr>
                    <th></th>
                    <th>{{$t('front.service')}} </th>
                    <th>{{$t('front.center')}}</th>
                    <th>{{$t('front.preview_fees')}}</th>
                    <th>{{$t('front.cost')}}</th>
                    <th>{{$t('front.status')}}</th>
                    <th>{{$t('front.avg_rate')}}</th>
                    <th> </th>
                  </tr>
                  <tr v-for="(order, key) in collection" :key="key">
                    <td>
                      <div class="pro-img"><img :src="order.item.service.image" alt=""></div>
                    </td>
                    <td>
                      <p class="b">{{order.item.service.name}}</p>
                      <span class="blue">{{`${order.item.id}A`}}</span>
                    </td>
                    <td>
                      <p class="dred">{{order.item.service.store.name}}</p>
                    </td>
                    <td>
                      <div class="h6 price blue">{{order.item.preview_fees}}<span>{{$t('front.riyal')}}</span></div>
                    </td>
                    <td>
                      <div class="h6 price blue">{{order.total}}<span>{{$t('front.riyal')}}</span></div>
                    </td>
                    <td>
                      <button :class="`acc-btn ${order.status.key == 'new' ? 'btn-default' : (order.status.key == 'canceled' ? 'btn-del' : 'btn-confirm')}`">
                        {{order.status.name}}
                      </button>
                    </td>
                    <td>
                      <div class="inline-d rate">
                        <!--<i
                          v-for="idx in parseInt(order.item.service.rate)"
                          :key="`incre${idx}`"
                          class="fas fa-star rated"
                        ></i>
                        <i
                          v-for="idx in 5 - parseInt(order.item.service.rate)"
                          :key="`decre${idx}`"
                          class="fas fa-star"
                        ></i>-->
                        <span class="yellow">{{order.item.service.rate}}</span>
                        <button class="acc-btn btn-yellow" v-if="!order.item.service.is_rated && canRate && order.status.key == 'delivered'" @click="openRateModal(order.item.service.id)">
                          {{$t('front.rate_service')}}
                        </button>
                      </div>
                    </td>
                    <td>
                      <div class="input-group">
                        <div class="text-center" v-if="order.status.key == 'new'">
                          <button class="no-btn red" @click="openCancelModal(order.id)">
                            <!--{{$t('front.cancel')}}-->
                            <i class="far fa-times-circle"></i>
                          </button>
                        </div>
                        <div class="text-center" v-if="order.status.key == 'accepted'">
                          <button class="no-btn blue" @click="changeStatus(order.id)" :title="$t('front.delivered_service')" data-toggle="tooltip">
                            <i class="fas fa-truck"></i>
                          </button>
                        </div>
                        <div class="text-center" v-if="order.invoice != ''">
                          <a class="serv-info no-btn text-center green" target="_blank" :href="order.invoice">
                            <i class="fas fa-file-pdf"></i>
                            <!-- {{$t('front.invoice')}} -->
                          </a>
                        </div>
                      </div>
                    </td>
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

            <RatingModal />
            <CancelModal />

          </div>
        </div>
      </div>
      </client-only>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
