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
                              :label="$t('admin.service_type')"
                              label-for="input-horizontal"
                              id="fieldset-horizontal"
                              label-cols-sm="3"
                          >
                              <select name="category" class="form-control" v-model="form.category" >
                                <option value="" disabled selected >{{$t('admin.category')}}</option>
                                <option v-for="(category, key) in categories" :key="key" :value="category.id" >{{category.name}}</option>
                              </select>
                              <span v-show="errors.has(`category`)" class="text-error text-danger text-sm">
                              {{ errors.first(`category`) }}
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
                                v-model="form.price_from"
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
                                v-model="form.price_to"
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

                    <b-row>

                         <b-col md="6">
                          <b-form-group
                              :label="$t('admin.preview_fees')"
                              label-for="input-horizontal"
                              id="fieldset-horizontal"
                              label-cols-sm="3"
                          >
                            <b-form-input
                                name="preview_fees"
                                v-model="form.preview_fees"
                                v-validate="{ required: false,  decimal: 3, min_value: 0,  max_value: 50000}"
                                :placeholder="$t('admin.preview_fees')"
                                :class="{ 'is-invalid': errors.has('preview_fees') }"
                            ></b-form-input>
                              <span v-show="errors.has(`preview_fees`)" class="text-error text-danger text-sm">
                              {{ errors.first(`preview_fees`) }}
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

