import * as VeeValidate from 'vee-validate';
import Vue from 'vue'

export default function ({ app, store }) {
  app.i18n.locale = app.$cookies.get('i18n_redirected')

  store.commit(
    "localStorage/SET_CURRENT_LOCALE",
      app.$cookies.get('i18n_redirected')
  );
  Vue.use(VeeValidate, {
    defaultMessage: (field, values) => {
            values._field_ = app.i18n.t(`${field}`);
            return app.i18n.t(`validation.${values._rule_}`, values);
        }
    })
}
