<template>
  <!-- sidebar -->
  <b-navbar class="sidebar" toggleable="lg">
    <!-- logo -->
    <b-navbar-brand class="logo">
      <h4>
        <img src="~/assets/logo.png" />
      </h4>
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse">
      <i class="fas fa-bars"></i>
    </b-navbar-toggle>

    <!-- Routes -->
    <b-collapse id="nav-collapse" is-nav>
      <ul class="main-list">
        <li v-show="storePermissions.includes('statistics.index')">
          <nuxt-link :to="localePath('stores')" exact>
            <span>{{ $t("admin.home") }}</span>
          </nuxt-link>
        </li>
        <!--<li>-->
          <!--<b-dropdown block-->
            <!--:menu-class="`w-100 ${[`dashboard-locations-states___${currentLocale}`, `dashboard-locations-cities___${currentLocale}`].includes(routeName) ? 'show' : ''}`"-->
          <!--:text="$t('admin.locations')">-->
            <!--<nuxt-link :to="localePath('dashboard-locations-countries')" v-show="storePermissions.includes('countries.index')">-->
              <!--<span>{{ $t("admin.countries") }}</span>-->
            <!--</nuxt-link>-->
            <!--<nuxt-link :to="localePath('dashboard-locations-states')" v-show="storePermissions.includes('states.index')">-->
              <!--<span>{{ $t("admin.states") }}</span>-->
            <!--</nuxt-link>-->
            <!--<nuxt-link :to="localePath('dashboard-locations-cities')" v-show="storePermissions.includes('cities.index')">-->
              <!--<span>{{ $t("admin.cities") }}</span>-->
            <!--</nuxt-link>-->
          <!--</b-dropdown>-->
        <!--</li>-->

        <li v-show="storePermissions.includes('admins.index')">
          <nuxt-link :to="localePath('stores-admins')" v-show="storePermissions.includes('admins.index')">
            <span>{{ $t("admin.admins") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('roles.index')">
          <nuxt-link :to="localePath('stores-roles')" v-show="storePermissions.includes('roles.index')">
            <span>{{ $t("admin.roles") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('warranties.index')">
          <nuxt-link :to="localePath('stores-warranties')" v-show="storePermissions.includes('warranties.index')">
            <span>{{ $t("admin.warranties") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('orders.index')">
          <nuxt-link class="table_icon" :to="localePath(`stores-product-orders`)" v-show="storePermissions.includes('orders.index')">
            <span>{{ $t("admin.product_orders") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('refunds.index')">
          <nuxt-link class="table_icon" :to="localePath(`stores-refunds`)" v-show="storePermissions.includes('refunds.index')">
            <span>{{ $t("admin.refunds") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('promo_codes.index')">
          <nuxt-link class="table_icon" :to="localePath(`/stores/promo-codes`)" v-show="storePermissions.includes('promo_codes.index')"
          >
            <span>{{ $t("admin.promoCodes") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('offers.index')">
          <nuxt-link class="table_icon" :to="localePath(`/stores/offers`)" v-show="storePermissions.includes('offers.index')"
          >
            <span>{{ $t("admin.offers") }}</span>
          </nuxt-link>
        </li>
        <li>
          <nuxt-link class="table_icon" :to="localePath(`/stores/packages`)">
            <span>{{ $t("admin.packages") }}</span>
          </nuxt-link>
        </li>
        <li v-show="storePermissions.includes('products.index')">
          <nuxt-link class="table_icon" :to="localePath(`stores-products`)" v-show="storePermissions.includes('products.index')">
            <span>{{ $t("admin.products") }}</span>
          </nuxt-link>
        </li>


        <!-- <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-admins___${currentLocale}`, `dashboard-roles___${currentLocale}`, `dashboard-users${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.users_management')">
            <nuxt-link :to="localePath('dashboard-admins')" v-show="storePermissions.includes('admins.index')">
              <span>{{ $t("admin.admins") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-roles')" v-show="storePermissions.includes('roles.index')">
              <span>{{ $t("admin.roles") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-users')" v-show="storePermissions.includes('users.index')">
              <span>{{ $t("admin.users") }}</span>
            </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-settings${currentLocale}`, `dashboard-brands${currentLocale}`, `dashboard-warranties${currentLocale}`, `dashboard-services-types${currentLocale}`, `dashboard-categories${currentLocale}`, `dashboard-subcategories${currentLocale}`, `dashboard-bank-accounts${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.settings')">
            <nuxt-link class="table_icon" :to="localePath(`dashboard-settings`)" v-show="storePermissions.includes('settings.index')">
              <span>{{ $t("admin.general_settings") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-brands')" v-show="storePermissions.includes('brands.index')">
              <span>{{ $t("admin.brands") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-warranties')" v-show="storePermissions.includes('warranties.index')">
              <span>{{ $t("admin.warranties") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-services-types')" v-show="storePermissions.includes('service_types.index')">
              <span>{{ $t("admin.services_types") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-categories')" v-show="storePermissions.includes('categories.index')">
              <span>{{ $t("admin.categories") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-subcategories')" v-show="storePermissions.includes('subcategories.index')">
              <span>{{ $t("admin.subcategories") }}</span>
            </nuxt-link>
            <nuxt-link :to="localePath('dashboard-bank-accounts')" v-show="storePermissions.includes('bank_accounts.index')">
              <span>{{ $t("admin.bank_accounts") }}</span>
            </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`/dashboard/content/terms${currentLocale}`, `/dashboard/content/about-us${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.content_management')">
            <nuxt-link class="table_icon" :to="localePath(`/dashboard/content/terms`)" v-show="storePermissions.includes('pages.index')">
              <span>{{ $t("admin.terms") }}</span>
            </nuxt-link>
            <nuxt-link class="table_icon" :to="localePath(`/dashboard/content/about-us`)" v-show="storePermissions.includes('pages.index')">
              <span>{{ $t("admin.about-us") }}</span>
            </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-products${currentLocale}`, `dashboard-additional-fields${currentLocale}`, `dashboard-services${currentLocale}`, `dashboard-ratings${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.products')">
          <nuxt-link class="table_icon" :to="localePath(`dashboard-services`)" v-show="storePermissions.includes('products.index')">
            <span>{{ $t("admin.services") }}</span>
          </nuxt-link>
          <nuxt-link class="table_icon" :to="localePath(`dashboard-additional-fields`)" v-show="storePermissions.includes('properties.index')">
            <span>{{ $t("admin.properties") }}</span>
          </nuxt-link>
          <nuxt-link class="table_icon" :to="localePath(`dashboard-products`)" v-show="storePermissions.includes('products.index')">
            <span>{{ $t("admin.products") }}</span>
          </nuxt-link>
          <nuxt-link class="table_icon" :to="localePath(`dashboard-ratings`)" v-show="storePermissions.includes('comments.index')">
            <span>{{ $t("admin.ratings") }}</span>
          </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-current-stores${currentLocale}`, `dashboard-stores-requests${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.stores')">
            <nuxt-link class="table_icon" :to="localePath(`dashboard-current-stores`)" v-show="storePermissions.includes('stores.index')">
              <span>{{ $t("admin.current_stores") }}</span>
            </nuxt-link>
            <nuxt-link class="table_icon" :to="localePath(`dashboard-stores-requests`)" v-show="storePermissions.includes('stores.index')">
              <span>{{ $t("admin.stores_join_requests") }}</span>
            </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-current-centers${currentLocale}`, `dashboard-centers-requests${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.centers')">
            <nuxt-link class="table_icon" :to="localePath(`dashboard-current-centers`)" v-show="storePermissions.includes('stores.index')">
              <span>{{ $t("admin.current_centers") }}</span>
            </nuxt-link>
            <nuxt-link class="table_icon" :to="localePath(`dashboard-centers-requests`)" v-show="storePermissions.includes('stores.index')">
              <span>{{ $t("admin.centers_requests") }}</span>
            </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-product-orders${currentLocale}`, `dashboard-service-orders${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.orders_management')">
          <nuxt-link class="table_icon" :to="localePath(`dashboard-product-orders`)" v-show="storePermissions.includes('orders.index')">
            <span>{{ $t("admin.product_orders") }}</span>
          </nuxt-link>
          <nuxt-link class="table_icon" :to="localePath(`dashboard-service-orders`)" v-show="storePermissions.includes('orders.index')">
            <span>{{ $t("admin.service_orders") }}</span>
          </nuxt-link>
          </b-dropdown>
        </li>
        <li>
          <b-dropdown block
            :menu-class="`w-100 ${[`dashboard-refund-reasons${currentLocale}`, `dashboard-refunds${currentLocale}`].includes(routeName) ? 'show' : ''}`"
          :text="$t('admin.refunds_management')">
          <nuxt-link class="table_icon" :to="localePath(`dashboard-refund-reasons`)" v-show="storePermissions.includes('refund_reasons.index')">
            <span>{{ $t("admin.refund_reasons") }}</span>
          </nuxt-link>
          <nuxt-link class="table_icon" :to="localePath(`dashboard-refunds`)" v-show="storePermissions.includes('refunds.index')">
            <span>{{ $t("admin.refunds") }}</span>
          </nuxt-link>
          </b-dropdown>
        </li>

        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/slides`)" v-show="storePermissions.includes('ads.index')"
                >
            <span>{{ $t("admin.ads") }}</span>
          </nuxt-link>
        </li>
        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/banner`)">
            <span>{{ $t("admin.banners") }}</span>
          </nuxt-link>
        </li>

        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/offers`)" v-show="storePermissions.includes('offers.index')"
                >
            <span>{{ $t("admin.offers") }}</span>
          </nuxt-link>
        </li>
        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/notification`)" v-show="storePermissions.includes('notifications.index')"
                >
            <span>{{ $t("admin.notifications") }}</span>
          </nuxt-link>
        </li>
        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/contact`)" v-show="storePermissions.includes('contact_us.index')"
                >
            <span>{{ $t("admin.contact") }}</span>
          </nuxt-link>
        </li>
        <li>
          <nuxt-link class="table_icon" :to="localePath(`/dashboard/promo-codes`)" v-show="storePermissions.includes('promo_codes.index')"
                >
            <span>{{ $t("admin.promoCodes") }}</span>
          </nuxt-link>
        </li> -->

        <!-- <li class="logout_list">
          <a @click="logOut()">
            <i class="fas fa-sign-out-alt"></i>
            <span>{{ $t("logout") }}</span>
          </a>
        </li> -->
      </ul>
    </b-collapse>
  </b-navbar>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data() {
    return {
      routeName: this.$route.name, // dashboard-locations-states___en
      storePermissions: this.$cookies.get('storePermissions') || [],
    };
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  methods: {

  }
};
</script>
<style >
  .sidebar .dropdown button{
    background: transparent;
    border: 0;
    color: var(--color);
    border-radius: 0;
  }
  .sidebar .dropdown button:focus{
    outline: 0;
    box-shadow: none;
  }
  .dropdown-menu{width: 100%;position: relative;border-radius: 0;}
  @media(max-width : 992px){
    /* .sidebar .dropdown button{
      text-align: center !important;
    } */
  }

</style>
<style scoped>
/* update */
.sidebar {
  position: relative;
  min-width: 17%;
  background-color: var(--bg-secondary);
  flex-direction: column;
  padding: 0;
}
.main-list{width:100%;}
.sidebar .main-list li a{padding-left: 10px !important;}
.navbar-brand{margin-right: 0;}
.navbar-expand-lg .navbar-collapse {
  flex-direction: column;
  width: 100%;
  max-height: 550px;
  overflow-y: auto;
}
.navbar-toggler{
  color: #fff;
  border:1px solid #fff;
  margin:15px 15px 0;
  margin-right: auto;
}
.dropdown{
  width:100%;
}

.dropdown span{color: #525961;}
@media (max-width:600px) {
  .sidebar{
    position: absolute;
    min-width: 100%;
    z-index: 9;
    background-color: transparent;
  }
  .sidebar .main-list{
    background: #525961;
    padding-top:10px !important;
  }
}
@media (min-width:600px) and (max-width : 992px){
  .sidebar{
    position: absolute;
    min-width: 60%;
    z-index: 9;
    background-color: transparent;
  }
  .sidebar .main-list{
    background: #525961;
    padding-top:10px !important;
  }
}
/*---*/
.sidebar .logo {
  /* padding: 2em 0; */
  padding: 0.7em 0;
  background-color: #fff;
  width: 100%;
  text-align: center;
}
.sidebar .main-list {
  /* padding: 3em 0; */
}
.logout_list {
  padding-top: 1rem;
  cursor: pointer;
}

.sidebar .main-list li a {
  padding: 0.5em 1em 0.5em 0;
  font-size: 16px;
  display: block;
  color: var(--color);
  text-decoration: none;
  margin: 0.5em 0;
}

.sidebar .main-list li a i {
  font-size: 20px;
  display: inline-block;
}

.sidebar .main-list li a span {
  display: inline-block;
  margin-right: 10px;
}
.sidebar .main-list li a span.statistics {
  background-color: #381058;
  color: #fff;
  padding: 5px 10px;
  border-radius: 10px;
}
/* Active Link */
.nuxt-link-active {
  color: #fff !important;
  background-color: #381058;
}
.nuxt-link-active .statistics {
  color: #000 !important;
  background-color: #fff !important;
}

/* Media */
@media (max-width: 1200px) {
  .sidebar .logo,
  .logout_list span {
    display: none;
  }
  /* update */
  /*.sidebar .main-list li a span {
    display: none;
  }*/
  /* */
  .sidebar .main-list li a {
    text-align: center;
    padding-right: 0;
  }

  .sidebar .main-list li a i,
  .logout_list i {
    font-size: 25px;
    display: inline-block;
  }
}

</style>
