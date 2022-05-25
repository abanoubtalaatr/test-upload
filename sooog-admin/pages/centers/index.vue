<template>
  <div class="home-page">
    <b-container>
      <div class="level">
        <div :class="$i18n.locale == 'en' ? 'level-left' : 'level-right'">
            <span>{{ $t("admin.welcome") }} </span> <span> {{ centerData ? centerData.name : '' }} </span>
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
                  <p> {{ $t("admin.services_types") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['service_types'] }}</span>
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
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.services") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['services'] }}</span>
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
          

        </b-row>
      </div>
    </b-container>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import moment from 'moment'
export default {
  layout: "center",
  // middleware({ redirect, app }) {
  //   // If the user is not authorized
  //   if (!app.$cookies.get("centerPermissions").includes('statistics.index')) {
  //     return redirect(app.localePath('centers-403'))
  //   }
  // },
  data() {
    return {
      date: moment().locale(this.$i18n.locale).format("LL"),
      loading: true,
      statistics: [],
      permissions: this.$cookies.get("centerPermissions")
    };
  },
    computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      centerData: state => JSON.parse(state.localStorage.centerData)
    })
  },
  async asyncData (context) {
    const [ statistics ] = await Promise.all([
        context.$axios.$get(`/center/statistics`).catch(() => {})
    ])
    return { statistics }
  },
  methods: {
  },
};
</script>

<style scoped>
@import "../../assets/css/pages/homePage.css";
</style>
