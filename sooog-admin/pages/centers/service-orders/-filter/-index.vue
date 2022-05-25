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
                            :label="$t('admin.start_date')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-datepicker
                            id="example-datepicker"
                            name="start_date"
                            v-model="form.start_date"
                            class="mb-2"
                            v-validate="{ required: false }"
                            :placeholder="$t('admin.start_date')"
                            :locale="currentLocale"
                            today-button
                            reset-button
                            close-button
                            :label-today-button="$t('admin.select_today')"
                            :label-reset-button="$t('admin.reset')"
                            :label-close-button="$t('admin.close')"
                            :class="{ 'is-invalid': errors.has('start_date') }"
                            >
                            </b-form-datepicker>
                            <span v-show="errors.has('start_date')" class="text-error text-danger text-sm">
                                {{ errors.first("start_date") }}
                            </span>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                            :label="$t('admin.end_date')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-datepicker 
                            id="example-datepicker3" 
                            name="end_date"
                            v-model="form.end_date"
                            class="mb-2"
                            v-validate="{ required: false }"
                            :placeholder="$t('admin.end_date')"
                            :locale="currentLocale"
                            today-button
                            reset-button
                            close-button
                            :label-today-button="$t('admin.select_today')"
                            :label-reset-button="$t('admin.reset')"
                            :label-close-button="$t('admin.close')"
                            :class="{ 'is-invalid': errors.has('end_date') }"
                            >
                            </b-form-datepicker>
                            <span v-show="errors.has('end_date')" class="text-error text-danger text-sm">
                                {{ errors.first("end_date") }}
                            </span>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="6">
                            <b-form-group
                            :label="$t('admin.cost_from')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-input
                                name="cost_from"
                                v-model="form.cost_from"
                                v-validate="{ required: false,  decimal: 3, min_value: 0,  max_value: 1000000}"
                                :placeholder="$t('admin.cost_from')"
                                :class="{ 'is-invalid': errors.has('cost_from') }"
                            ></b-form-input>
                            <span v-show="errors.has('cost_from')" class="text-error text-danger text-sm">
                                {{ errors.first("cost_from") }}
                            </span>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                            :label="$t('admin.cost_to')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                            >
                            <b-form-input
                                name="cost_to"
                                v-model="form.cost_to"
                                v-validate="{ required: false,  decimal: 3, max_value: 1000000, min_value: 0 }"
                                :placeholder="$t('admin.cost_to')"
                                :class="{ 'is-invalid': errors.has('cost_to') }"
                            ></b-form-input>
                            <span v-show="errors.has('cost_to')" class="text-error text-danger text-sm">
                                {{ errors.first("cost_to") }}
                            </span>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <!--<b-row>-->
                        <!--<b-col md="6" v-if="stores">-->
                        <!--<b-form-group-->
                            <!--:label="$t('admin.store')"-->
                            <!--label-for="input-horizontal"-->
                            <!--id="fieldset-horizontal"-->
                            <!--label-cols-sm="3"-->
                        <!--&gt;-->
                            <!--<multiselect-->
                            <!--v-model.lazy="form.stores"-->
                            <!--:options="stores.map(obj => obj.id)"-->
                            <!--:custom-label="opt => stores.find(obj => obj.id == opt).name"-->
                            <!--value="key"-->
                            <!--:close-on-select="true"-->
                            <!--:clear-on-select="false"-->
                            <!--:hide-selected="false"-->
                            <!--:preserve-search="true"-->
                            <!--:placeholder="$t('admin.stores')"-->
                            <!--label="key"-->
                            <!--:allowEmpty="true"-->
                            <!--:preselect-first="false"-->
                            <!--id="key"-->
                            <!--name="stores"-->
                            <!--v-validate="{ required: false }"-->
                            <!--&gt;-->
                            <!--<span slot="noOptions">-->
                                <!--{{$t('admin.empty_list')}}-->
                            <!--</span>-->
                            <!--<span slot="noResult">-->
                                <!--{{$t('admin.no_results')}}-->
                            <!--</span>-->
                            <!--</multiselect>-->
                            <!--<span v-show="errors.has(`stores`)" class="text-error text-danger text-sm">-->
                            <!--{{ errors.first(`stores`) }}-->
                            <!--</span>-->
                        <!--</b-form-group>-->
                        <!--</b-col>-->
                    <!--</b-row>-->
                    <b-row>
                        <b-col md="6" v-if="payment_methods">
                        <b-form-group
                            :label="$t('admin.payment_method')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                        >
                            <multiselect
                            v-model.lazy="form.payment_method"
                            :options="payment_methods.map(obj => obj.id)"
                            :custom-label="opt => payment_methods.find(obj => obj.id == opt).name"
                            value="key"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :hide-selected="false"
                            :preserve-search="true"
                            :placeholder="$t('admin.payment_method')"
                            label="key"
                            :allowEmpty="true"
                            :preselect-first="false"
                            id="key"
                            name="payment_method"
                            v-validate="{ required: false }"
                            >
                            <span slot="noOptions">
                                {{$t('admin.empty_list')}}
                            </span>
                            <span slot="noResult">
                                {{$t('admin.no_results')}}
                            </span>
                            </multiselect>
                            <span v-show="errors.has(`payment_method`)" class="text-error text-danger text-sm">
                            {{ errors.first(`payment_method`) }}
                            </span>
                        </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="6" v-if="statuses">
                        <b-form-group
                            :label="$t('admin.status')"
                            label-for="input-horizontal"
                            id="fieldset-horizontal"
                            label-cols-sm="3"
                        >
                            <multiselect
                            v-model.lazy="form.status"
                            :options="statuses.map(obj => obj.id)"
                            :custom-label="opt => statuses.find(obj => obj.id == opt).name"
                            value="key"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :hide-selected="false"
                            :preserve-search="true"
                            :placeholder="$t('admin.status')"
                            label="key"
                            :allowEmpty="true"
                            :preselect-first="false"
                            id="key"
                            name="status"
                            v-validate="{ required: false }"
                            >
                            <span slot="noOptions">
                                {{$t('admin.empty_list')}}
                            </span>
                            <span slot="noResult">
                                {{$t('admin.no_results')}}
                            </span>
                            </multiselect>
                            <span v-show="errors.has(`status`)" class="text-error text-danger text-sm">
                            {{ errors.first(`status`) }}
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

