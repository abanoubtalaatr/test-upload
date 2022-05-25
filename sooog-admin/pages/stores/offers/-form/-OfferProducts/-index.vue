<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
        <b-modal :id="modalId" centered hide-footer size="lg" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
          <template #modal-header="{ close }">
            <!-- <Title medium darkBlue>{{titlePage}}</Title> -->
            <Button @clickFn="close()" size="sm" bgRed>x</Button>
          </template>
          <b-form @submit.prevent="saveProducts">
          <card-component :title="titlePage" icon="fas fa-clipboard-list 5x" v-if="products">
             <b-row>
                        <b-col md="3" >
                        <Search/>
                        </b-col>
                    </b-row>
            <b-row>
                <b-col md="6" v-for="(product, index) in products" :key="`product${index}`">
                    <b-form-group>
                    <!--<b-card
                        :title="product.name"
                        :img-src="product.image"
                        :img-alt="product.name"
                        img-top
                        class="mb-3"
                    >
                        <b-card-text>
                            <b-form-radio v-if="inputType == 'radio'"
                            v-model="selectedProduct"
                            :value="product.id"
                            v-validate="{ required: true }"
                            :placeholder="$t('admin.products')"
                            name="products"
                            :class="{ 'is-invalid': errors.has('products') }"
                            ></b-form-radio>
                            <b-form-checkbox v-else
                                v-model="selectedProducts"
                                :value="product.id"
                                v-validate="{ required: true }"
                                :placeholder="$t('admin.products')"
                                name="products"
                                :class="{ 'is-invalid': errors.has('products') }"
                            ></b-form-checkbox>

                        </b-card-text>
                    </b-card>-->
                    <div class="n-card">
                        <div class="n-check">
                            <b-form-radio v-if="inputType == 'radio'"
                            v-model="selectedProduct"
                            :value="product.id"
                            v-validate="{ required: true }"
                            :placeholder="$t('admin.products')"
                            name="products"
                            :class="{ 'is-invalid': errors.has('products') }"
                            ></b-form-radio>
                            <b-form-checkbox v-else
                                v-model="selectedProducts"
                                :value="product.id"
                                v-validate="{ required: true }"
                                :placeholder="$t('admin.products')"
                                name="products"
                                :class="{ 'is-invalid': errors.has('products') }"
                            ></b-form-checkbox>
                        </div>
                        <div class="n-img">
                            <img :title="product.name" :src="product.image" :alt="product.name">
                        </div>
                        <div class="n-txt">
                            <p>{{product.name}}</p>
                        </div>
                    </div>

                    <span v-show="errors.has('products')" class="text-error text-danger text-sm">
                        {{ errors.first("products") }}
                    </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row v-if="pagination">
                <b-col lg="6" class="my-1">
                    {{$t('admin.showing_page_number')}}
                    {{ products.length ? current_page : 0 }}
                </b-col>

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

