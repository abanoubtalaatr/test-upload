<template>

      <b-modal id="form-transaction-modal" centered hide-footer size="lg" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
        <template #modal-title>
          <p>{{$t('admin.add_transaction')}}</p>
        </template>

            <b-form @submit.prevent="submit()">
              <div id="info">
                <b-row>
                      <b-col md="12">
                            <b-form-group>
                              <label>{{$t('admin.ar_reason')}}</label>
                            <b-form-input
                                v-model="payload.ar.reason"
                                v-validate="{ required: true, max: 150 }"
                                :placeholder="$t('admin.ar_reason')"
                                name="ar_reason"
                                :class="{ 'is-invalid': errors.has('ar_reason') }"
                            ></b-form-input>
                            <span v-show="errors.has('ar_reason')" class="text-error text-sm">
                            {{ errors.first("ar_reason") }}
                          </span>
                            </b-form-group>
                        </b-col>

                        <b-col md="12">
                            <b-form-group>
                              <label>{{$t('admin.en_reason')}}</label>
                            <b-form-input
                                v-model="payload.en.reason"
                                v-validate="{ required: true, max: 150 }"
                                :placeholder="$t('admin.en_reason')"
                                name="en_reason"
                                :class="{ 'is-invalid': errors.has('en_reason') }"
                            ></b-form-input>
                            <span v-show="errors.has('en_reason')" class="text-error text-sm">
                            {{ errors.first("en_reason") }}
                          </span>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                          <b-col md="12">
                        <b-form-group>
                          <label>{{$t('admin.transaction_type')}}</label>
                          <b-form-radio-group
                            id="transaction_type"
                            v-model="payload.type"
                            :options="type_options"
                            name="transaction_type"
                            buttons
                            button-variant="outline-primary"
                          ></b-form-radio-group>
                        </b-form-group>
                      </b-col>
                    </b-row>
                    <b-row>
                      <b-col md="12">
                        <b-form-group
                        :label="$t('admin.amount')"
                        label-for="input-horizontal"
                        id="fieldset-horizontal"
                        label-cols-sm="2"
                        >
                        <b-form-input
                            name="amount"
                            v-model="payload.amount"
                            v-validate="{ required: true,  decimal: 3, min_value: 1 }"
                            :placeholder="$t('admin.amount')"
                            :class="{ 'is-invalid': errors.has('amount') }"
                        ></b-form-input>
                        <span v-show="errors.has('amount')" class="text-error text-danger text-sm">
                            {{ errors.first("amount") }}
                        </span>
                        </b-form-group>
                    </b-col>
                    </b-row>
              </div>
              <div class="text-center mt-3 mb-2">
                <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
                <Button @clickFn="hideModal()" size="sm" bgRed>{{$t('admin.cancel')}}</Button>
              </div>
            </b-form>

      </b-modal>

</template>

<script src="./-index.js"></script>
