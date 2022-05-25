<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form @submit.prevent="submit" v-if="stores.length > 0">
          <b-row>
            <b-col md="12">
              <card-component :title="$t('admin.centers')" icon="fas fa-clipboard-list 5x">
                <b-col md="12">
                  <b-form-group
                    :label="$t('admin.selectAll')"
                    id="fieldset-horizontal"
                    label-cols="1"
                    label-cols-sm="1"
                  >
                    <b-form-checkbox-group
                      name="stores"
                    >
                      <b-form-checkbox
                        name="stores"
                        @change="selectAllStores"
                        v-model="selectAll"
                      >
                      </b-form-checkbox>
                    </b-form-checkbox-group>
                  </b-form-group>
                </b-col>
                
                  <b-form-checkbox-group
                    name="stores"
                    v-model="form.stores"
                    v-validate="{ required: true }"
                  >
                    <b-form-checkbox
                      v-for="(store, index) in stores"
                      :key="`store_${index}`"
                      :value="store.id"
                    >
                      {{ store.name }}
                    </b-form-checkbox>
                  </b-form-checkbox-group>

                <span v-show="errors.has('stores')" class="text-error text-danger text-sm">
                  {{ errors.first("stores") }}
                </span>
              </card-component>
            </b-col>
          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen>{{$t('admin.save')}}</Button>
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
          </div>

        </b-form>
        <b-row v-else>
            <b-col md="12">
              {{$t('admin.empty_list')}}
            </b-col>
        </b-row>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

