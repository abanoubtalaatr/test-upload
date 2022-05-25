<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.name"
                    v-model="form.en.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.name\']')"
                    :class="{ 'is-invalid': errors.has('en.name') }"
                ></b-form-input>
                <span v-show="errors.has('en.name')" class="text-error text-danger text-sm">
                    {{ errors.first("en.name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.name"
                    v-model="form.ar.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.name\']')"
                    :class="{ 'is-invalid': errors.has('ar.name') }"
                ></b-form-input>
                <span v-show="errors.has('ar.name')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.name") }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.start_date')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-datepicker 
                  id="start_date-datepicker" 
                  name="start_date"
                  v-model="form.start_date" 
                  class="mb-2"
                  v-validate="{ required: true }"
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
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.end_date')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-datepicker 
                  id="end_date-datepicker" 
                  name="end_date"
                  v-model="form.end_date" 
                  class="mb-2"
                  v-validate="{ required: true }"
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
                  v-validate="{ required: true }"
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
            <b-col md="12" v-if="form.type == 'value'">
                <b-form-group
                :label="$t('admin.value')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="value"
                    v-model="form.value"
                    v-validate="{ required: true,  decimal: 3, min_value: 0 }"
                    :placeholder="$t('admin.value')"
                    :class="{ 'is-invalid': errors.has('value') }"
                ></b-form-input>
                <span v-show="errors.has('value')" class="text-error text-danger text-sm">
                    {{ errors.first("value") }}
                </span>
                </b-form-group>
            </b-col>
            <b-col md="12" v-else-if="form.type == 'percentage'">
                <b-form-group
                :label="$t('admin.value')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="value"
                    v-model="form.value"
                    v-validate="{ required: true,  decimal: 3, max_value: 100, min_value: 0 }"
                    :placeholder="$t('admin.value')"
                    :class="{ 'is-invalid': errors.has('value') }"
                ></b-form-input>
                <span v-show="errors.has('value')" class="text-error text-danger text-sm">
                    {{ errors.first("value") }}
                </span>
                </b-form-group>
            </b-col>
            <b-col v-else>
                <b-form-group
                :label="$t('admin.free_product')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <Button bgGreen @clickFn="openProductsModal('radio')">{{$t('admin.select_product')}}</Button>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.products')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <Button bgGreen @clickFn="openProductsModal">{{$t('admin.select_products')}}</Button>
                </b-form-group>
            </b-col>
        </b-row>
        <offer-products />
        
        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
