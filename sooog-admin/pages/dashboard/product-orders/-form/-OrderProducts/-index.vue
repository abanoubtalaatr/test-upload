<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
        <b-modal :id="modalId" centered hide-footer size="lg" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
          <template #modal-header="{ close }">
            <!-- <Title medium darkBlue>{{titlePage}}</Title> -->
            <Button @clickFn="close()" size="sm" bgRed>x</Button>
          </template>
            <div class="level-right">
              <Search />
            </div>
          <b-form @submit.prevent="saveProducts">
          <card-component :title="titlePage" icon="fas fa-clipboard-list 5x" v-if="products">
            <div class="level-right">
              <Search />
            </div>
            <b-row>
                <div v-for="(product, index) in products" :key="`product${index}`">
                  <b-card no-body class="overflow-hidden" style="max-width: 540px;">
                    <b-row no-gutters>
                      <b-col md="6">
                        <b-card-img :src="product.image" :alt="product.name" class="rounded-0"></b-card-img>

                      </b-col>
                      <b-col md="6">
                        <b-card-body title="">
                          <b-card-text>
                            <!-- <label>{{product.name}}</label> -->
                            <b-form-group v-if="warranties"
                              :label="product.name"
                              label-for="input-horizontal"
                              id="fieldset-horizontal"
                              label-cols-sm="10"
                            >
                            <b-form-checkbox
                                v-model="selectedProducts"
                                :value="product.id"
                                v-validate="{ required: true }"
                                :placeholder="$t('admin.products')"
                                name="products"
                                :class="{ 'is-invalid': errors.has('products') }"
                                @input="updateItems(product)"
                            ></b-form-checkbox>
                            </b-form-group>
                            <b-form-input type="number"
                              :min="1"
                              :max="product.max_purchase_quantity"
                              placeholder="1"
                              v-model="product.item_quantity"
                              @input="updateQuantity(product)"
                              ></b-form-input>
                              <br/> <br/> <br/>
                            <b-form-group v-if="warranties"
                              :label="$t('admin.warranty')"
                              label-for="input-horizontal"
                              id="fieldset-horizontal"
                              label-cols-sm="6"
                            >
                              <multiselect
                                v-model="product.warranty_id"
                                :options="warranties.map(obj => obj.id)"
                                :custom-label="opt => warranties.find(obj => obj.id == opt).name"
                                value="key"
                                :close-on-select="true"
                                :clear-on-select="false"
                                :hide-selected="false"
                                :preserve-search="true"
                                :placeholder="$t('admin.warranty')"
                                label="key"
                                :allowEmpty="true"
                                :preselect-first="false"
                                id="key"
                                name="warranty"
                                v-validate="{ required: false }"
                                @input="updateWarranty(product)"
                              >
                                <span slot="noOptions">
                                  {{$t('admin.empty_list')}}
                                </span>
                                <span slot="noResult">
                                  {{$t('admin.no_results')}}
                                </span>
                              </multiselect>
                              <span v-show="errors.has(`warranty`)" class="text-error text-danger text-sm">
                                {{ errors.first(`warranty`) }}
                              </span>
                            </b-form-group>
                          </b-card-text>
                        </b-card-body>
                      </b-col>
                    </b-row>
                  </b-card>
                </div>
            </b-row>
            <b-row v-if="pagination">
                <!-- <b-col lg="6" class="my-1">
                    Showing page number
                    {{ products.length ? current_page : 0 }}
                </b-col> -->

                <b-col v-if="pagination" lg="6" class="my-1">
                    <b-pagination
                    v-model="current_page"
                    :total-rows="pagination.total"
                    :per-page="pagination.per_page"
                    :last-page="pagination.last_page"
                    pills
                    align="right"
                    @input="$emit('page-changed', current_page)"
                    class="my-3 heavy-rain-gradient"
                    />
                </b-col>
            </b-row>
          </card-component>
            <div class="text-center mt-3 mb-2">
              <Button type="submit" size="sm" bgGreen>{{$t('admin.save')}}</Button>
            </div>
          </b-form>
        </b-modal>
    </section>
 </div>
</template>

<script src="./-index.js"></script>

