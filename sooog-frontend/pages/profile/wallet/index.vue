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
            <!--profile-info-->
            <h3>{{$t('front.wallet')}}</h3>
            <div class="flex-div">
              <h4 class="grey mb-30">{{$t('front.wallet_operations')}}</h4>
              <h4 class="dred">
                {{total}}
                <span>{{$t('front.riyal')}}</span>
              </h4>
            </div>
            <div v-if="collection.length">
              <div class="w-div" v-for="(transaction, key) in collection" :key="key">
                <div class="flex-div">
                  <div class="icon-div">
                    <i class="far fa-arrow-alt-circle-up dred" v-if="transaction.type == 'pay_in'"></i>
                    <i class="far fa-arrow-alt-circle-down red" v-else></i>
                    <div class="w-date">
                      <p class="grey">{{transaction.created_at}}</p>
                      <p class="b">{{transaction.reason}}</p>
                    </div>
                  </div>
                  <h5 :class="`${transaction.type == 'pay_in' ? 'green' : 'red'}`">
                    {{Number(transaction.amount)}}
                    <span>{{$t('front.riyal')}}</span>
                  </h5>
                </div>
              </div>

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

          </div>
        </div>
      </div>
      </client-only>
    </main>
    <!-- End Main Content-->
</template>


<script src="./index.js"></script>
