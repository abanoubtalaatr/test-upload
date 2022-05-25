<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--product filter-->
      <section class="filter custom-padd">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="h3">{{products.length && this.$route.query.store ? products[0].store.name : $t('front.products')}}
              <span class="blue">({{meta.total}}) {{$t('front.product')}}</span></div>
            </div>
            <div class="col-md-9 text-right">
              <div class="row">
                <div class="col-6 col-md-3 padd-r-0">
                  <div class="row">
                    <div class="col-6">
                      <label class="dred mr-0">{{$t('front.select_price')}}</label>
                    </div>
                    <div class="col-6 text-right">
                      <span class="grey">{{$t('front.less_than')}} </span>
                      <span class="grey" id="slide-info">{{filter.price_to}}</span></div>
                  </div>
                  <div class="rSlider">
                    <div class="slide"></div>
                    <input v-model="filter.price_to" class="range" type="range"
                      @input="debouncedPrice"
                      id="points" name="points" min="0" max="20000">
                  </div>
                </div>
                <div class="col-6 col-md-3 padd-r-0">
                 <select class="form-control select-g" v-model="filter.brand" name="brand" @change="changeSelect">
                    <option value="" selected disabled>{{$t('front.select_brand')}}</option>
                    <option v-for="(brand, key) in brands" :key="key" :value="brand.id">
                      {{brand.name}}
                    </option>
                  </select>
                </div>
                <div class="col-6 col-md-3 padd-r-0">
                  <select class="form-control select-g" v-model="filter.selectedOrder" @change="changeSort">
                    <option value="" selected disabled>{{$t('front.sort_by')}}</option>
                    <option v-for="(sort, key) in sorting" :key="key" :value="sort.key">
                      {{sort.name}}
                    </option>
                  </select>
                </div>
                <div class="col-6 col-md-3 padd-r-0">
                  <select class="form-control select-g" name="category" v-model="filter.category" @change="changeSelect">
                    <option value="" selected disabled>{{$t('front.display_all_categories')}}</option>
                    <option v-for="(category, key) in categories" :key="key" :value="category.id">
                      {{category.name}}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--products-->
      <section class="products">
        <div class="container">
          <div class="row" v-if="products.length">
            <div v-for="(product, key) in products" :key="key" class="col-6 col-md-3">
              <a href="#">
                <productBlock :product="product" />
              </a>
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
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
