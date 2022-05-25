<template>
    <b-form @submit.prevent="submit">
      <b-row  v-if="type=='stores'">
            <b-col md="12">
                
                  <b-form-checkbox
                    v-model="form.has_delivery_service"
                    name="has_delivery_service"
                  >
                  {{$t('admin.has_delivery_service')}}
                  </b-form-checkbox>
                <span v-show="errors.has('has_delivery_service')" class="text-error text-danger text-sm">
                    {{ errors.first("has_delivery_service") }}
                </span>
                
            </b-col>
        </b-row>
        <br/>
        <b-row>
            <b-col md="12" v-if="form.has_delivery_service">
                <b-form-group
                :label="$t('admin.delivery_charge')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="delivery_charge"
                    v-model="form.delivery_charge"
                    v-validate="{ required: form.has_delivery_service,  decimal: 3, min_value: 0 }"
                    :placeholder="delivery_charge"
                    :class="{ 'is-invalid': errors.has('delivery_charge') }"
                ></b-form-input>
                <span v-show="errors.has('delivery_charge')" class="text-error text-danger text-sm">
                    {{ errors.first("delivery_charge") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.application_dues')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="application_dues"
                    v-model="form.application_dues"
                    v-validate="{ required: true,  decimal: 3, max_value: 100, min_value: 0 }"
                    :placeholder="$t('admin.application_dues')"
                    :class="{ 'is-invalid': errors.has('application_dues') }"
                ></b-form-input>
                <span v-show="errors.has('application_dues')" class="text-error text-danger text-sm">
                    {{ errors.first("application_dues") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        
        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
