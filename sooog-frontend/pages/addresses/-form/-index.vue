<template>
  <div class="form">
  <b-form @submit.prevent="submit()" class="form">
    <input class="form-control login-input" type="text" name="title" :placeholder="$t('front.title')"
      v-model="form.title" v-validate="{ required: true, max: 150 }">
    <span v-show="errors.has('title')" class="text-error text-danger text-sm">
      {{ errors.first("title") }}
    </span>

    <div class="row">
      <div class="col-md-6">
        <input class="form-control login-input" type="text" name="address" :placeholder="$t('front.address_detail')"
          v-model="form.address" v-validate="{ required: true, max: 150 }">
        <span v-show="errors.has('address')" class="text-error text-danger text-sm">
          {{ errors.first("address") }}
        </span>
      </div>
      <div class="col-md-6">
        <input class="form-control login-input" type="text" name="phone" :placeholder="$t('front.phone')"
          v-model="form.phone" v-validate="{ required: true, numeric: true, max: 15 }">
        <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
          {{ errors.first("phone") }}
        </span>
      </div>
    </div>
     <div class="row">
      <div class="col-md-6">
        <select class="form-control login-input" name="country" v-model="form.country_id"
          v-validate="{ required: true }" @change="changeCountry($event.target.value)">
          <option selected value="" disabled>{{$t('front.country')}}</option>
          <option v-for="(country, key) in countries" :key="key" :value="country.id">{{country.name}}</option>
        </select>
        <span v-show="errors.has('country')" class="text-error text-danger text-sm">
          {{ errors.first("country") }}
        </span>
      </div>
      <div class="col-md-6">
        <!-- <multiselect
          v-model="form.state_id"
          :options="states.map(obj => obj.id)"
          :custom-label="opt => states.find(obj => obj.id == opt).name"
          value="key"
          :close-on-select="true"
          :clear-on-select="false"
          :hide-selected="false"
          :preserve-search="true"
          :placeholder="$t('admin.state')"
          label="key"
          :allowEmpty="true"
          :preselect-first="false"
          id="key"
          name="state"
          @select="changeState"
          v-validate="{ required: true }"
        >
          <span slot="noOptions">
            {{$t('admin.empty_list')}}
          </span>
          <span slot="noResult">
            {{$t('admin.no_results')}}
          </span>
        </multiselect> -->
        <select class="form-control login-input" v-model="form.state_id"
          v-validate="{ required: true }" name="state" @change="changeState($event.target.value)">
          <option selected value="" disabled>{{$t('front.state')}}</option>
          <option v-for="(state, key) in states" :key="key" :value="state.id">{{state.name}}</option>
        </select>
        <span v-show="errors.has('state')" class="text-error text-danger text-sm">
          {{ errors.first("state") }}
        </span>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <select class="form-control login-input" v-model="form.city_id"
          v-validate="{ required: true }" name="city">
          <option selected value="" disabled>{{$t('front.city')}}</option>
          <option v-for="(city, key) in cities" :key="key" :value="city.id">{{city.name}}</option>
        </select>
        <span v-show="errors.has('city')" class="text-error text-danger text-sm">
          {{ errors.first("city") }}
        </span>
      </div>
      <div class="col-md-6">
        <input class="form-control login-input" type="text" name="nearest_landmarks" :placeholder="$t('front.nearest_landmarks')"
          v-model="form.nearest_landmarks" v-validate="{ required: true }">
        <span v-show="errors.has('nearest_landmarks')" class="text-error text-danger text-sm">
          {{ errors.first("nearest_landmarks") }}
        </span>
      </div>
    </div>
    <div class="row">
      <GmapMap ref="mapRef"
        :center="position"
        :zoom="12"
        map-type-id="terrain"
        style="width: 100%; height: 400px"
        @click="handleMap"
        >
        <GmapMarker
            :position="position"
            :clickable="true"
            :draggable="true"
            @click="position"
            @dragend="handleMap($event)"
        />
      </GmapMap>
    </div>
    <div class="row">
      <div class="col-6 text-left">
        <input class="grey" type="checkbox" v-model="form.is_primary" id="primary-check">
        <label class="grey" for="primary-check">{{ $t('front.primary_address') }}</label>
      </div>
    </div>

    <button type="submit" class="button btn-gredient big">{{$t('front.save')}}</button>
    <button class="no-btn prev-profile" @click="back()">{{$t('front.back')}}</button>
  </b-form>
  </div>
</template>

<script src="./-index.js"></script>
