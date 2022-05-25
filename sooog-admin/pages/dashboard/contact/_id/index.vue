<template>
  <div>
    <title-bar :title-stack="titleStack"/>

    <section class="section is-main-section">
      <card-component :title="item.title" icon="fas fa-clipboard-list 5x">
        <div class="countries">
          <div class="level">
            <b-row>
              <b-col lg="12">
                <p><span style="color:green;">{{$t('name') + ' : '}}</span> {{ item.name }}</p>
                <p><span style="color:green;">{{$t('phone') + ' : '}}</span> {{ item.phone }}</p>
                <p><span style="color:green;">{{$t('email') + ' : '}}</span> {{ item.email }}</p>
                <p><span style="color:green;">{{$t('title') + ' : ' }}</span> {{ item.title }}</p>
                <p><span style="color:green;">{{$t('content') + ' : ' }}</span> {{item.body }}</p>
                <p v-if="item.reply"><span style="color:green;">{{$t('admin.the_reply') + ' : ' }}</span> {{item.reply }}</p>
              </b-col>
            </b-row>
          </div>

          <b-form v-if="item.reply==null" @submit.prevent="submit(item.id)">
            <hr>
            <b-row>
              <b-col md="12">
                <b-form-group
                  :label="$t('admin.the_reply')"
                  label-for="input-horizontal"
                  id="fieldset-horizontal"
                  label-cols-sm="2"
                >
                  <b-form-textarea
                    name="reply"
                    rows="3"
                    max-rows="6"
                    v-model="form.body"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.the_reply')"
                    :class="{ 'is-invalid': errors.has('reply') }"
                  ></b-form-textarea>
                  <span v-show="errors.has('reply')" class="text-error text-danger text-sm">
                    {{ errors.first("reply") }}
                </span>
                </b-form-group>
              </b-col>
            </b-row>
            <div class="text-center mt-3 mb-2">
              <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.reply')}}</Button>
            </div>
          </b-form>
        </div>
      </card-component>
      <div class="text-center mt-3 mb-2">
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
      </div>
    </section>
  </div>
</template>

<script src="./index.js"></script>

