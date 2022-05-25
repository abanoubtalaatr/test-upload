<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--brands-->
      <section class="brands custom-padd">
        <div class="container">
          <div class="h3 sub-head">{{$t('front.most_famous_brands')}}
            <!-- <a class="more" href="#">المزيد</a> -->
          </div>
          <div class="row brand-logos" v-if="brands.length">
            <div v-for="(brand, key) in brands" :key="key" class="col-6 col-md-3 col-lg-2">
              <nuxt-link :to="{ path: localePath('products'), query: { brand: brand.id } }">
                <div class="brand">
                  <div class="brand-img"><img :src="brand.image"></div>
                  <div class="brand-wrap">
                    <!-- <div class="row center-v">
                      <div class="col-6"><img src="assets/imgs/home/lg@2x.png"></div>
                      <div class="col-6 text-right"><img src="assets/imgs/home/air-conditioner.svg" alt=""></div>
                    </div> -->
                  </div>
                </div>
              </nuxt-link>
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
      </section>
    </main>
</template>

<script src="./index.js"></script>
