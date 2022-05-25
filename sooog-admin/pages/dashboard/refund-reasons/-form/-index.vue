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

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
