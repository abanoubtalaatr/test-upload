export default ({app, context, store}) => {
  let permissions = app.$cookies.get('permissions')
  let currentLocale = app.i18n.locale
  let adminRoutes = []
  if (permissions.length > 0) {
    adminRoutes = [
      {
        name: `dashboard-auth-login___${currentLocale}`,
        has_permission: true,
      },
      {
        name: `dashboard-financial-dues___${currentLocale}`,
        has_permission: permissions.includes('financial_dues.index'),
      },
      {
        name: `dashboard-payments___${currentLocale}`,
        has_permission: permissions.includes('payments.index'),
      },
      {
        name: `dashboard-payments-id___${currentLocale}`,
        has_permission: permissions.includes('payments.index'),
      },
      {
        name: `dashboard___${currentLocale}`,
        has_permission: true,
      },
      {
        name: `dashboard-settings___${currentLocale}`,
        has_permission: permissions.includes('settings.index'),
      },
      {
        name: `dashboard-admins___${currentLocale}`,
        has_permission: permissions.includes('admins.index'),
      },
      {
        name: `dashboard-admins-create___${currentLocale}`,
        has_permission: permissions.includes('admins.create'),
      },
      {
        name: `dashboard-admins-id-edit___${currentLocale}`,
        has_permission: permissions.includes('admins.update'),
      },
      {
        name: `dashboard-roles___${currentLocale}`,
        has_permission: permissions.includes('roles.index'),
      },
      {
        name: `dashboard-roles-create___${currentLocale}`,
        has_permission: permissions.includes('roles.create'),
      },
      {
        name: `dashboard-roles-id-edit___${currentLocale}`,
        has_permission: permissions.includes('roles.update'),
      },
      {
        name: `dashboard-slides___${currentLocale}`,
        has_permission: permissions.includes('ads.index'),
      },
      {
        name: `dashboard-slides-create___${currentLocale}`,
        has_permission: permissions.includes('ads.create'),
      },
      {
        name: `dashboard-slides-id-edit___${currentLocale}`,
        has_permission: permissions.includes('ads.update'),
      },
      {
        name: `dashboard-content-id___${currentLocale}`,
        has_permission: permissions.includes('pages.index'),
      },
      {
        name: `dashboard-contact-us___${currentLocale}`,
        has_permission: permissions.includes('contact_us.index'),
      },
      {
        name: `dashboard-contact-us-id___${currentLocale}`,
        has_permission: permissions.includes('contact_us.show'),
      },
      {
        name: `dashboard-additional-fields___${currentLocale}`,
        has_permission: permissions.includes('properties.index'),
      },
      {
        name: `dashboard-additional-fields-create___${currentLocale}`,
        has_permission: permissions.includes('properties.create'),
      },
      {
        name: `dashboard-additional-fields-id-edit___${currentLocale}`,
        has_permission: permissions.includes('properties.update'),
      },
      {
        name: `dashboard-bank-accounts___${currentLocale}`,
        has_permission: permissions.includes('bank_accounts.index'),
      },
      {
        name: `dashboard-bank-accounts-create___${currentLocale}`,
        has_permission: permissions.includes('bank_accounts.create'),
      },
      {
        name: `dashboard-bank-accounts-id-edit___${currentLocale}`,
        has_permission: permissions.includes('bank_accounts.update'),
      },
      {
        name: `dashboard-brands___${currentLocale}`,
        has_permission: permissions.includes('brands.index'),
      },
      {
        name: `dashboard-brands-create___${currentLocale}`,
        has_permission: permissions.includes('brands.create'),
      },
      {
        name: `dashboard-brands-id-edit___${currentLocale}`,
        has_permission: permissions.includes('brands.update'),
      },
      {
        name: `dashboard-packages___${currentLocale}`,
        has_permission: permissions.includes('packages.index'),
      },
      {
        name: `dashboard-packages-create___${currentLocale}`,
        has_permission: permissions.includes('packages.create'),
      },
      {
        name: `dashboard-packages-id-edit___${currentLocale}`,
        has_permission: permissions.includes('packages.update'),
      },
      {
        name: `dashboard-categories___${currentLocale}`,
        has_permission: permissions.includes('categories.index'),
      },
      {
        name: `dashboard-categories-create___${currentLocale}`,
        has_permission: permissions.includes('categories.create'),
      },
      {
        name: `dashboard-categories-id-edit___${currentLocale}`,
        has_permission: permissions.includes('categories.update'),
      },
      {
        name: `dashboard-subcategories___${currentLocale}`,
        has_permission: permissions.includes('subcategories.index'),
      },
      {
        name: `dashboard-subcategories-create___${currentLocale}`,
        has_permission: permissions.includes('subcategories.create'),
      },
      {
        name: `dashboard-subcategories-id-edit___${currentLocale}`,
        has_permission: permissions.includes('subcategories.update'),
      },
      {
        name: `dashboard-services-types___${currentLocale}`,
        has_permission: permissions.includes('service_types.index'),
      },
      {
        name: `dashboard-services-types-create___${currentLocale}`,
        has_permission: permissions.includes('service_types.create'),
      },
      {
        name: `dashboard-services-types-id-edit___${currentLocale}`,
        has_permission: permissions.includes('service_types.update'),
      },
      {
        name: `dashboard-offers___${currentLocale}`,
        has_permission: permissions.includes('offers.index'),
      },
      {
        name: `dashboard-offers-create___${currentLocale}`,
        has_permission: permissions.includes('offers.create'),
      },
      {
        name: `dashboard-offers-id-edit___${currentLocale}`,
        has_permission: permissions.includes('offers.update'),
      },
      {
        name: `dashboard-products___${currentLocale}`,
        has_permission: permissions.includes('products.index'),
      },
      {
        name: `dashboard-products-create___${currentLocale}`,
        has_permission: permissions.includes('products.create'),
      },
      {
        name: `dashboard-products-id-edit___${currentLocale}`,
        has_permission: permissions.includes('products.update'),
      },
      {
        name: `dashboard-services___${currentLocale}`,
        has_permission: permissions.includes('services.index'),
      },
      {
        name: `dashboard-services-create___${currentLocale}`,
        has_permission: permissions.includes('services.create'),
      },
      {
        name: `dashboard-services-id-edit___${currentLocale}`,
        has_permission: permissions.includes('services.update'),
      },
      {
        name: `dashboard-promo-codes___${currentLocale}`,
        has_permission: permissions.includes('promo_codes.index'),
      },
      {
        name: `dashboard-promo-codes-create___${currentLocale}`,
        has_permission: permissions.includes('promo_codes.create'),
      },
      {
        name: `dashboard-promo-codes-id-edit___${currentLocale}`,
        has_permission: permissions.includes('promo_codes.update'),
      },
      {
        name: `dashboard-refund-reasons___${currentLocale}`,
        has_permission: permissions.includes('refund_reasons.index'),
      },
      {
        name: `dashboard-refund-reasons-create___${currentLocale}`,
        has_permission: permissions.includes('refund_reasons.create'),
      },
      {
        name: `dashboard-refund-reasons-id-edit___${currentLocale}`,
        has_permission: permissions.includes('refund_reasons.update'),
      },
      {
        name: `dashboard-warranties___${currentLocale}`,
        has_permission: permissions.includes('warranties.index'),
      },
      {
        name: `dashboard-warranties-create___${currentLocale}`,
        has_permission: permissions.includes('warranties.create'),
      },
      {
        name: `dashboard-warranties-id-edit___${currentLocale}`,
        has_permission: permissions.includes('warranties.update'),
      },
      {
        name: `dashboard-ratings___${currentLocale}`,
        has_permission: permissions.includes('comments.index'),
      },
      {
        name: `dashboard-locations-countries___${currentLocale}`,
        has_permission: permissions.includes('countries.index'),
      },
      {
        name: `dashboard-locations-countries-create___${currentLocale}`,
        has_permission: permissions.includes('countries.create'),
      },
      {
        name: `dashboard-locations-countries-id-edit___${currentLocale}`,
        has_permission: permissions.includes('countries.update'),
      },
      {
        name: `dashboard-locations-states___${currentLocale}`,
        has_permission: permissions.includes('states.index'),
      },
      {
        name: `dashboard-locations-states-create___${currentLocale}`,
        has_permission: permissions.includes('states.create'),
      },
      {
        name: `dashboard-locations-states-id-edit___${currentLocale}`,
        has_permission: permissions.includes('states.update'),
      },
      {
        name: `dashboard-locations-cities___${currentLocale}`,
        has_permission: permissions.includes('cities.index'),
      },
      {
        name: `dashboard-locations-cities-create___${currentLocale}`,
        has_permission: permissions.includes('cities.create'),
      },
      {
        name: `dashboard-locations-cities-id-edit___${currentLocale}`,
        has_permission: permissions.includes('cities.update'),
      },
      {
        name: `dashboard-centers-requests___${currentLocale}`,
        has_permission: permissions.includes('centers.index'),
      },
      {
        name: `dashboard-centers-requests-id___${currentLocale}`,
        has_permission: permissions.includes('centers.index'),
      },
      {
        name: `dashboard-current-centers___${currentLocale}`,
        has_permission: permissions.includes('centers.index'),
      },
      {
        name: `dashboard-current-centers-id___${currentLocale}`,
        has_permission: permissions.includes('centers.index'),
      },
      {
        name: `dashboard-current-centers-id-edit___${currentLocale}`,
        has_permission: permissions.includes('centers.update'),
      },
      {
        name: `dashboard-current-centers-featured___${currentLocale}`,
        has_permission: permissions.includes('centers.featured'),
      },
      {
        name: `dashboard-stores-requests___${currentLocale}`,
        has_permission: permissions.includes('stores.index'),
      },
      {
        name: `dashboard-stores-requests-id___${currentLocale}`,
        has_permission: permissions.includes('stores.index'),
      },
      {
        name: `dashboard-current-stores___${currentLocale}`,
        has_permission: permissions.includes('stores.index'),
      },
      {
        name: `dashboard-current-stores-id___${currentLocale}`,
        has_permission: permissions.includes('stores.index'),
      },
      {
        name: `dashboard-current-stores-id-edit___${currentLocale}`,
        has_permission: permissions.includes('stores.update'),
      },
      {
        name: `dashboard-current-stores-featured___${currentLocale}`,
        has_permission: permissions.includes('stores.featured'),
      },
      {
        name: `dashboard-profile___${currentLocale}`,
        has_permission: true,
      },
      {
        name: `dashboard-service-orders___${currentLocale}`,
        has_permission: permissions.includes('orders.index'),
      },
      {
        name: `dashboard-service-orders___${currentLocale}`,
        has_permission: permissions.includes('orders.index'),
      },
      {
        name: `dashboard-service-orders-id___${currentLocale}`,
        has_permission: permissions.includes('orders.index'),
      },
      {
        name: `dashboard-service-orders-id-edit___${currentLocale}`,
        has_permission: permissions.includes('orders.update'),
      },
      {
        name: `dashboard-product-orders___${currentLocale}`,
        has_permission: permissions.includes('orders.index'),
      },
      {
        name: `dashboard-product-orders-id___${currentLocale}`,
        has_permission: permissions.includes('orders.index'),
      },
      {
        name: `dashboard-product-orders-id-edit___${currentLocale}`,
        has_permission: permissions.includes('orders.update'),
      },
      {
        name: `dashboard-product-orders-id-refund___${currentLocale}`,
        has_permission: permissions.includes('refunds.create'),
      },
      {
        name: `dashboard-refunds___${currentLocale}`,
        has_permission: permissions.includes('refunds.index'),
      },
      {
        name: `dashboard-refunds-id___${currentLocale}`,
        has_permission: permissions.includes('refunds.index'),
      },
      {
        name: `dashboard-users___${currentLocale}`,
        has_permission: permissions.includes('users.index'),
      },
      {
        name: `dashboard-users-id___${currentLocale}`,
        has_permission: permissions.includes('users.index'),
      },
      {
        name: `dashboard-users-id-transactions___${currentLocale}`,
        has_permission: permissions.includes('users.transactions'),
      },
      {
        name: `dashboard-notification___${currentLocale}`,
        has_permission: permissions.includes('notifications.index'),
      },
      {
        name: `dashboard-notification-create___${currentLocale}`,
        has_permission: permissions.includes('notifications.create'),
      },
      {
        name: `dashboard-contact___${currentLocale}`,
        has_permission: permissions.includes('contact_us.index'),
      },
      {
        name: `dashboard-contact-id___${currentLocale}`,
        has_permission: permissions.includes('contact_us.index'),
      },
      {
        name: `dashboard-banner___${currentLocale}`,
        has_permission: permissions.includes('banners.index'),
      },
      {
        name: `dashboard-banner-id-edit___${currentLocale}`,
        has_permission: permissions.includes('banners.update'),
      },

    ]
  }
  //console.log('routes:', adminRoutes)

  app.router.beforeEach((to, from, next) => {
    if (adminRoutes.length <= 0)
      next()
    let has_permission = false
    has_permission = adminRoutes.find((element) => element.name == to.name)?.has_permission
    console.log('has_perm', has_permission)
    if (has_permission) {
      next()
    } else {
      // next(false)
      return redirect(app.localePath('dashboard-403'))
    }
  })
}
