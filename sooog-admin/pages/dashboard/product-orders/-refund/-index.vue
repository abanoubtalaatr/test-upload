<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col md="6" v-if="refund_reasons.length>0">
              <b-form-group
                :label="$t('admin.refund_reason')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="3"
              >
                <multiselect
                  v-model="form.refund_reason_id"
                  :options="refund_reasons.map(obj => obj.id)"
                  :custom-label="opt => refund_reasons.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.refund_reason')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="refund_reason"
                  v-validate="{ required: true }"
                  @input="updateReason"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`refund_reason`)" class="text-error text-danger text-sm">
                  {{ errors.first(`refund_reason`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <b-row v-if="other_reason">
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.note')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="3"
                >
                <b-form-textarea
                    v-model="form.note"
                    :placeholder="$t('admin.reason')"
                    rows="3"
                    max-rows="6"
                    name='other_reason'
                    v-validate="{ required: other_reason, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('other_reason') }"
                ></b-form-textarea>
                <span v-show="errors.has(`other_reason`)" class="text-error text-danger text-sm">
                  {{ errors.first(`other_reason`) }}
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
                label-cols-sm="3"
                >
                <b-form-radio-group
                  id="radio-group-1"
                  v-model="form.refund_type"
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
        
        <b-row v-if="form.refund_type == 'items'">
          <label>{{$t('admin.items')}}</label>
                <div v-for="(item, index) in item.items" :key="`item${index}`">
                  <b-card no-body class="overflow-hidden" style="max-width: 540px;">
                    <b-row no-gutters>
                      <b-col md="6">
                        <b-card-img :src="item.product.image" :alt="item.product.name" class="rounded-0"></b-card-img>
                        
                      </b-col>
                      <b-col md="6">
                        <b-card-body title="">
                          <b-card-text>
                            <b-form-group
                              :label="item.product.name"
                              label-for="input-horizontal"
                              id="fieldset-horizontal"
                              label-cols-sm="10"
                            >
                            <b-form-checkbox
                                v-model="item.product.id"
                                :value="item.product.id"
                                v-validate="{ required: true }"
                                :placeholder="$t('admin.products')"
                                name="products"
                                :class="{ 'is-invalid': errors.has('products') }"
                                @input="updateItems(item)"
                            ></b-form-checkbox>
                            </b-form-group>
                            <b-form-input type="number"
                              :min="1"
                              :max="item.quantity"
                              placeholder="1"
                              v-model="item.quantity"
                              @input="updateQuantity(item)"
                              ></b-form-input>
                              
                            
                          </b-card-text>
                        </b-card-body>
                      </b-col>
                    </b-row>
                  </b-card>
                </div>
            </b-row>
        
        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
