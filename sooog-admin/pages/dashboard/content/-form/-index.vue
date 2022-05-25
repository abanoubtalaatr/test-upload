<template>
    <b-form @submit.prevent="submit">

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.title\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.title"
                    v-model="form.en.title"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.title\']')"
                    :class="{ 'is-invalid': errors.has('en.title') }"
                ></b-form-input>
                <span v-show="errors.has('en.title')" class="text-error text-danger text-sm">
                    {{ errors.first("en.title") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.title\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.title"
                    v-model="form.ar.title"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.title\']')"
                    :class="{ 'is-invalid': errors.has('ar.title') }"
                ></b-form-input>
                <span v-show="errors.has('ar.title')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.title") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'en.body\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <!-- <b-form-textarea
                    v-model="form.en.body"
                    :placeholder="$t('admin[\'en.body\']')"
                    rows="3"
                    max-rows="6"
                    name='en.body'
                    v-validate="{ required: true, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('en.body') }"
                ></b-form-textarea> -->
                 <!-- wysiwyg editor -->
                  <TuiEditor
                    mode="markdown"
                    preview-style="tab"
                    height="200px"
                    name="en.body"
                    v-model="form.en.body"
                    v-validate="{ required: true, max: 1000 }"
                  />
                  <!-- markdown viewer -->
                  <!-- <TuiEditorViewer /> -->
                <span v-show="errors.has(`en.body`)" class="text-error text-danger text-sm">
                  {{ errors.first(`en.body`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'ar.body\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <!-- <b-form-textarea
                    v-model="form.ar.body"
                    :placeholder="$t('admin[\'ar.body\']')"
                    rows="3"
                    max-rows="6"
                    name='ar.body'
                    v-validate="{ required: true, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('ar.body') }"
                ></b-form-textarea> -->
                <!-- wysiwyg editor -->
                  <TuiEditor
                    mode="markdown"
                    height="200px"
                    preview-style="tab"
                    :visible="true"
                    v-model="form.ar.body"
                    v-validate="{ required: true, max: 1000 }"
                    name="ar.body"
                  />
                <!-- <TuiEditorViewer /> -->

                <span v-show="errors.has(`ar.body`)" class="text-error text-danger text-sm">
                  {{ errors.first(`ar.body`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <!-- <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button> -->
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
