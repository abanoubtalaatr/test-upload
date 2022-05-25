<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form @submit.prevent="submit" v-if="form.settings">

        <b-row v-for="(setting, index) in form.settings" :key="index">
            <b-col md="12">
                <b-form-group
                :label="setting.name"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input v-if="setting.property_type.key == 'text'"
                    :name="setting.key"
                    v-model="setting.body"
                    v-validate="{ required: true }"
                    :placeholder="setting.name"
                    :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-input v-if="setting.property_type.key == 'number'"
                    :name="setting.key"
                    v-model="setting.body"
                    v-validate="{ required: true, numeric: true, min_value: 0, max_value: 100000 }"
                    :placeholder="setting.name"
                    :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-input v-if="setting.property_type.key == 'decimal'"
                    :name="setting.key"
                    v-model="setting.body"
                    v-validate="{ required: true, decimal: 3, min_value: 0, max_value: 100000, max:6 }"
                    :placeholder="setting.name"
                    :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-radio-group v-if="setting.property_type.key == 'radio'"
                  id="radio-group-1"
                  v-model="setting.body"
                  v-validate="{ required: true }"
                  :placeholder="setting.name"
                  :options="options"
                  :aria-describedby="ariaDescribedby"
                  :name="setting.key"
                  :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-radio-group>
                <span v-show="errors.has(`${setting.key}`)" class="text-error text-danger text-sm">
                    {{ errors.first(`${setting.key}`) }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        </div>

    </b-form>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

