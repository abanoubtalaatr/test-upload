<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
        <b-modal :id="modalId" centered hide-footer size="lg" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
            <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
                <b-form @submit.prevent="submit">
                    <b-row>
                      <b-col md="6">
                            <b-form-group
                            :label="$t('admin.name')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-input
                                name="name"
                                v-model="form.name"
                                v-validate="{ required: false}"
                                :placeholder="$t('admin.name')"
                                :class="{ 'is-invalid': errors.has('name') }"
                            ></b-form-input>
                            <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                                {{ errors.first("name") }}
                            </span>
                            </b-form-group>
                        </b-col>

                        <b-col md="6">
                            <b-form-group
                            :label="$t('admin.product_name')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-input
                                name="name"
                                v-model="form.product_name"
                                v-validate="{ required: false}"
                                :placeholder="$t('admin.product_name')"
                                :class="{ 'is-invalid': errors.has('name') }"
                            ></b-form-input>
                            <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                                {{ errors.first("name") }}
                            </span>
                            </b-form-group>
                        </b-col>

                    </b-row>

                    <b-row>
                        <b-col md="12">
                            <b-form-group
                            :label="$t('admin.offer_type')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="2"
                            >
                            <b-form-radio-group
                              id="radio-group-1"
                              v-model="form.type"
                              v-validate="{ required: false }"
                              :placeholder="$t('admin.offer_type')"
                              :options="options"
                              name="offer_type"
                              :class="{ 'is-invalid': errors.has('offer_type') }"
                            ></b-form-radio-group>
                            <span v-show="errors.has('offer_type')" class="text-error text-danger text-sm">
                                {{ errors.first("offer_type") }}
                            </span>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                      <b-col md="6">
                            <b-form-group
                            :label="$t('admin.date')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-datepicker
                              id="start_date-datepicker"
                              name="date"
                              v-model="form.date"
                              class="mb-2"
                              v-validate="{ required: false }"
                              :placeholder="$t('admin.date')"
                              :locale="currentLocale"
                              today-button
                              reset-button
                              close-button
                              :label-today-button="$t('admin.select_today')"
                              :label-reset-button="$t('admin.reset')"
                              :label-close-button="$t('admin.close')"
                              :class="{ 'is-invalid': errors.has('date') }"
                            >
                            </b-form-datepicker>
                            <span v-show="errors.has('date')" class="text-error text-danger text-sm">
                                {{ errors.first("date") }}
                            </span>
                            </b-form-group>
                        </b-col>

                    </b-row>

                    <div class="text-center mt-3 mb-2">
                        <Button type="submit" size="sm" bgGreen>{{$t('admin.save')}}</Button>
                        <Button @clickFn="hideModal()" size="sm" bgRed>{{$t('admin.cancel')}}</Button>
                    </div>

                </b-form>
            </card-component>
            <!-- <div class="text-center mt-3 mb-2">
              <Button type="submit" size="sm" bgGreen>{{$t('admin.save')}}</Button>
            </div> -->
          <!-- </b-form> -->
        </b-modal>
    </section>
 </div>
</template>

<script src="./-index.js"></script>

