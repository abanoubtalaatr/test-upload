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
          <!--orders-->
          <section class="profile">
            <h3>{{$t('admin.notifications')}}</h3>
            <!--<p class="grey">عرض كل المنتجات التي ارغب في شرائها وأبدى اهتمام بها </p>-->
            <div v-if="collection">
              <div class="notification new" v-for="item in collection" :key="item.id">
                <nuxt-link :to="item.data.type == 'order' ? (item.data.type == 'service_order' ? localePath(`/orders/services/${item.data.model_id}`) : localePath(`/orders/${item.data.model_id}`)) : '#'">
                <div class="row">
                  <div class="col-2">
                    <img v-if="item.data.type == 'order'" :src="authUser.avatar" alt="">
                    <img v-else-if="currentLocale == 'en'" src="../../assets/website/imgs/home/logo@2x.png" alt="">
                    <img v-else src="../../assets/website/imgs/home/logo@2x.png" alt="">
                  </div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col-10">
                        <h5 class="b">{{currentLocale == 'en'?item.data.en.title:item.data.ar.title}}</h5>
                      </div>
                      <div class="col-2 text-right">
                        <p class="grey">{{item.created_at}}</p>
                      </div>
                    </div>
                    <p class="grey">{{currentLocale == 'en'?item.data.en.body:item.data.ar.body}}</p>
                  </div>
                </div>
                </nuxt-link>
              </div>
            </div>
            <h4 v-else>{{$t('admin.no_notification')}}</h4>
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
