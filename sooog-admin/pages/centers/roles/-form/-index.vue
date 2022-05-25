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
                  v-model="form.en.display_name"
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
                  v-model="form.ar.display_name"
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
              <card-component :title="$t('admin.permissions')" icon="fas fa-clipboard-list 5x">
                <b-col md="12">
                  <b-form-group
                    :label="$t('admin.selectAll')"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                  >
                    <b-form-checkbox-group
                      name="permissions"
                    >
                      <b-form-checkbox
                        v-model="selectAll"
                        name="permissions"
                        @change="selectAllPers"
                      >
                      </b-form-checkbox>
                    </b-form-checkbox-group>
                    <hr>
                  </b-form-group>
                </b-col>
                <b-form-group
                  v-for="(group, key) in groups"
                  :key="`group_${key}`"
                  :label="group.display_name"
                  id="fieldset-horizontal"
                  label-cols-sm="2"
                >
                  <b-form-checkbox-group
                    name="permissions"
                    v-model="form.permissions"
                    v-validate="{ required: true }"
                  >
                    <b-form-checkbox
                      v-for="(permission, index) in group.permissions"
                      :key="`per_${index}`"
                      :value="permission.id"
                    >
                      {{ permission.display_name }}
                    </b-form-checkbox>
                  </b-form-checkbox-group>
                  <hr>
                </b-form-group>

                <span v-show="errors.has('permissions')" class="text-error text-danger text-sm">
                  {{ errors.first("permissions") }}
                </span>
              </card-component>
            </b-col>
          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
          </div>

        </b-form>

</template>

<script src="./-index.js"></script>
