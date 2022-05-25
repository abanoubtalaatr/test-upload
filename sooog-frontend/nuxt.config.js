// import path from 'path'
// import fs from 'fs'

export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  // server: {
  //   https: {
  //     key: fs.readFileSync(path.resolve(__dirname, 'server.key')),
  //     cert: fs.readFileSync(path.resolve(__dirname, 'server.crt'))
  //   }
  // },
  target: 'server',
  generate: {
    minify: {
      collapseWhitespace: false
    },
    routes: [
      '/'
    ]
  },
  head: {
    title: 'sooog-front',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
      script:[
          {
            // src:'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js'
          }
      ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      {
        rel: "stylesheet",
        href:
          "https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
      },
      {
        rel: "stylesheet",
        crossorigin: "anonymous",
        href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      },
      {
        rel: "stylesheet",
        integrity:
          "sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==",
        crossorigin: "anonymous",
        href: "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
      },
      {
        rel: "stylesheet",
        integrity:
          "sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==",
        crossorigin: "anonymous",
        href: "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
      },
      {
        rel: "stylesheet",
        integrity:
          "sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==",
        crossorigin: "anonymous",
        href: "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
      },
      {
        rel: "stylesheet",
        integrity:
          "sha512-kz4Ae66pquz4nVE5ytJyKfPDkQyHSggaDtT1v8oLfOd8bB+ZgZXNLaxex99MNu4fdCsWmi58mhLtfGk5RgfcOw==",
        crossorigin: "anonymous",
        href: "https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.3/pretty-checkbox.min.css"
      },
      //   {
      //   rel: "stylesheet",
      //   href: "https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"
      // },
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    // "~/assets/css/global.css",
    "~/assets/website/css/bootstrap2.css",
    "~/assets/website/css/rtl-b.css",
    "~/assets/website/css/jquery.rateyo.min.css",
    "~/assets/website/css/style.css",
    "~/assets/website/css/enStyle.css",
    "~/assets/css/style.css"
  ],
  loading: "~/components/Spinner.vue",
  // loading: true,

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: "~/plugins/vee-validate" },
    { src: "~/plugins/i18n", ssr:false }, //** call first time in application */
    { src: "~/plugins/axios" },
    { src: "~/plugins/event-bus" },
    { src: "~plugins/vue-js-modal.js" },
    { src: "~/plugins/vue2-google-maps.js"},
    {
      src: "~/plugins/star-rating.js",
      ssr: false,
    },
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: ["@nuxtjs/color-mode"],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    "@nuxtjs/axios",
    '@nuxtjs/toast',
    // https://go.nuxtjs.dev/bootstrap
    "bootstrap-vue/nuxt",
    // https://vue-multiselect.js.org/#sub-props
    'nuxt-vue-multiselect',
    "vue-social-sharing/nuxt",
    "cookie-universal-nuxt",
    'nuxt-vuex-localstorage',
    ['nuxt-i18n', {
      lazy: true,
      loadLanguagesAsync: true,
      // vueI18n: i18n,
      locales: [
        {
          name: 'English',
          code: 'en',
          iso: 'en-US',
          file: "en/index.js",
          // dir: 'en/'
        },
        {
          name: 'Arabic',
          code: 'ar',
          iso: 'ar-AR',
          file: "ar/index.js",
          // dir: 'ar/'
        },
      ],
      langDir: 'locales/',
      defaultLocale: 'en',
      fallbackLocale: 'en',
      strategy: 'prefix',
      detectBrowserLanguage: {
        useCookie: true,
        cookieKey: 'i18n_redirected',
      },
      rootRedirect: 'en'
    }],
    'nuxt-vue-multiselect',

      '@nuxtjs/firebase',
  ],
  firebase:{
    config: {
        apiKey: "AIzaSyCrm8HDTNE0zrb268QJBs-kuwZNekwLZNI",
        authDomain: "sooog-2180d.firebaseapp.com",
        projectId: "sooog-2180d",
        storageBucket: "sooog-2180d.appspot.com",
        messagingSenderId: "404912388323",
        appId: "1:404912388323:web:0e94f8b9955f8f1c1eedd6",
        measurementId: "G-ZS26F458RH"
    },
    services:{
      messaging:{
        createServiceWorker: true,
        fcmPublicVapidKey: 'BMR9w3PVglVSDqqe-dUJ5t-r9XmycoDFK7k8sMTMg-IJnljJw6n_ykGDUKrY2ylHI8ve_QgdGhTa4jHSg3aY8x0',

      },
    }
  },
  // https://openbase.com/js/vue-toasted/documentation
  toast: {
    position: 'top-center',
    duration: 3000,
    theme: 'toasted-primary', // ['toasted-primary', 'outline', 'bubble']
    register: [ // Register custom toasts
      {
        name: 'my-error',
        message: 'Oops...Something went wrong',
        options: {
          type: 'error',
        }
      }
    ]
  },
  router: {
    // middleware: [],
    // base: "/admin/",
    // extendRoutes(routes, resolve) {
    //   routes.push({
    //     name: "custom",
    //     path: "*",
    //     component: resolve(__dirname, "pages/404.vue")
    //   });
    // }
  },
  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
    babel: {
      compact: true
    },
    extractCSS: true,
    optimizeCSS: true,
    // filenames: {
    //   css: `${BUILDID}.[name].css`,
    // },
      extend(config, ctx) {
          config.module.rules.push({
              test: /\.(ogg|mp3|wav|mpe?g)$/i,
              loader: 'file-loader',
              options: {
                  name: '[path][name].[ext]'
              }
          })
      }
  }
}
