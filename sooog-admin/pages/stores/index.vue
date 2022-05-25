<template>
  <div class="home-page">
    <b-container>
      <div class="level">
        <div :class="$i18n.locale == 'en' ? 'level-left' : 'level-right'">
          <span>{{ $t("admin.welcome") }} </span> <span> {{ storeData ? storeData.name : '' }} </span>
        </div>
        <div :class="$i18n.locale == 'en' ? 'level-right' : 'level-left'">
          <span> </span> <span> {{ date }} </span>
        </div>
      </div>

      <div class="Statistecs" v-if="statistics" v-show="permissions.includes('statistics.index')">
        <b-row>
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.categories") }} </p>
                  <img src="../../assets/images/customer.png" alt=""/>
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['categories'] }}</span>
                    </p>

                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->

          </b-col>
          <!--<b-col lg="4">-->
          <!--<div class="users">-->
          <!--<b-row>-->
          <!--<b-col lg="8" class="text-center">-->
          <!--<p> {{ $t("admin.warranties") }} </p>-->
          <!--<img src="../../assets/images/customer.png" alt="" />-->
          <!--</b-col>-->
          <!--<b-col lg="4">-->
          <!--<div class="users-statistics">-->
          <!--<p>-->
          <!--<span>{{ statistics['warranties'] }}</span>-->
          <!--</p>-->

          <!--</div>-->
          <!--</b-col>-->
          <!--</b-row>-->
          <!--<div class="add-user">-->
          <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
          <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
          <!--</nuxt-link> &ndash;&gt;-->
          <!--</div>-->
          <!--<br>-->
          <!--</div>-->
          <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.products") }} </p>
                  <img src="../../assets/images/customer.png" alt=""/>
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['products'] }}</span>
                    </p>

                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->
          </b-col>
          <!--<b-col lg="12">-->
            <!--<div class="users">-->
              <!--<b-row>-->
              <!--<b-col lg="12" class="text-center">-->
                <!--<p> {{ $t("admin.most_selling_product") }} </p>-->
              <!--</b-col>-->
              <!--</b-row>-->
              <!--<client-only>-->
                <!--<bar-chart :data="this.chartData()" :options="this.options()"></bar-chart>-->
              <!--</client-only>-->
              <!--<div class="add-user">-->
                <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
                  <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
                <!--</nuxt-link> &ndash;&gt;-->
              <!--</div>-->
              <!--<br>-->
            <!--</div>-->
            <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->

        </b-row>
      </div>
    </b-container>
  </div>
</template>
<script>
  import {mapState} from 'vuex'
  import moment from 'moment'

  export default {
    layout: "store",
    // middleware({ redirect, app }) {
    //   // If the user is not authorized
    //   if (!app.$cookies.get("storePermissions").includes('statistics.index')) {
    //     return redirect(app.localePath('stores-403'))
    //   }
    // },
    data() {
      return {
        date: moment().locale(this.$i18n.locale).format("LL"),
        loading: true,
        statistics: [],
        permissions: this.$cookies.get("storePermissions"),
        // chartData: {
        //   labels: this.collection.product,
        //   datasets: [{
        //     label: 'qty',
        //     data: this.collection.qty,
        //     // backgroundColor: [
        //     //   'rgba(255, 99, 132, 0.2)',
        //     //   'rgba(54, 162, 235, 0.2)',
        //     //   'rgba(255, 206, 86, 0.2)',
        //     //   'rgba(75, 192, 192, 0.2)',
        //     //   'rgba(153, 102, 255, 0.2)',
        //     //   'rgba(255, 159, 64, 0.2)'
        //     // ],
        //     // borderColor: [
        //     //   'rgba(255, 99, 132, 1)',
        //     //   'rgba(54, 162, 235, 1)',
        //     //   'rgba(255, 206, 86, 1)',
        //     //   'rgba(75, 192, 192, 1)',
        //     //   'rgba(153, 102, 255, 1)',
        //     //   'rgba(255, 159, 64, 1)'
        //     // ],
        //     borderWidth: 1
        //   }]
        // },
        // options: {
        //   scales: {
        //     yAxes: [{
        //       ticks: {
        //         beginAtZero: true
        //       }
        //     }]
        //   }
        // }
      };
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
        storeData: state => JSON.parse(state.localStorage.storeData)
      })
    },
    async asyncData(context) {
      const [statistics, collection] = await Promise.all([
        context.$axios.$get(`/store/statistics`).catch(() => {
        }),
        // context.$axios.$get(`/store/most-selling?type=stores`).catch(() => {
        // })
      ])
      return {statistics, collection}
    },
    methods: {
      // chartData() {
      //   return {
      //     labels: this.collection.product,
      //     datasets: [{
      //       label: this.$t('admin.quantity'),
      //       data: this.collection.qty,
      //       backgroundColor: [
      //         'rgba(255, 99, 132, 0.2)',
      //         'rgba(54, 162, 235, 0.2)',
      //         'rgba(255, 206, 86, 0.2)',
      //         'rgba(75, 192, 192, 0.2)',
      //         'rgba(153, 102, 255, 0.2)',
      //         'rgb(210, 255, 99,0.2)',
      //         'rgba(45, 0, 156, 0.2)',
      //         'rgba(255, 144, 99, 0.2)',
      //         'rgba(102, 102, 102, 0.2)',
      //         'rgba(255, 159, 64, 0.2)',
      //       ],
      //       borderColor: [
      //         'rgba(255, 99, 132, 1)',
      //         'rgba(54, 162, 235, 1)',
      //         'rgba(255, 206, 86, 1)',
      //         'rgba(75, 192, 192, 1)',
      //         'rgba(153, 102, 255, 1)',
      //         'rgba(210, 255, 99, 1)',
      //         'rgba(45, 0, 156, 1)',
      //         'rgba(255, 144, 99, 1)',
      //         'rgba(102, 102, 102, 1)',
      //         'rgba(255, 159, 64, 1)',
      //       ],
      //       borderWidth: 1
      //     }]
      //   }
      // },
      // options(){
      //  return {
      //     scales: {
      //       yAxes: [{
      //         ticks: {
      //           beginAtZero: true
      //         }
      //       }]
      //     }
      //   }
      // }
    },
  };
</script>

<style scoped>
  @import "../../assets/css/pages/homePage.css";
</style>
