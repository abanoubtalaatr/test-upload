<template>
<div>

  <title-bar :title-stack="titleStack" />
  <b-container>

      <b-row>
        <b-col md="4">
          <input type="number" class="form-control" v-model="filter.order_id" :placeholder="$t('admin.order_id')"/>
        </b-col>

        <b-col md="4">
          <select class="form-control" v-model="filter.store_id"
            name="store_id" @change="changeStore">
              <option selected disabled value="">
                {{$t('admin.store')}}
              </option>
              <option v-for="(store, key) in stores" :key="key" :value="store.id">
                {{store.name}}
              </option>
          </select>
        </b-col>

        <b-col md="4" class="text-left">
          <a @click="onPageChange(1)"
            class="btn btn-info"
          >
            <i class="fas fa-search"></i>
            {{ $t("admin.filter") }}
          </a>
          <a @click="resetFilter"
            class="btn btn-dark"
          >
            <i class="fas fa-undo"></i>
            {{ $t("admin.reset") }}
          </a>
        </b-col>
      </b-row>
      <br>
      <div class="row align-items-center">
        <div class="col-md-4"></div>
        <div :class="`col-md-8 ${currentLocale == 'en' ? 'text-left' : 'text-right'}`">
          <button @click="exportToExcel"
            class="btn btn-info"
          >
            <i class="fas fa-file-excel"></i>
            Excel
          </button>
          <!-- <button @click="exportToPdf"
            class="btn btn-danger"
          >
            <i class="fas fa-file-pdf"></i>
            PDF
          </button> -->
        </div>
        <!--<div class="col-md-4">
          <span style="line-height: 24px">
            {{$t('admin.select_all')}}
            <input type="checkbox" name="orderIds"
              v-model="select_all" @change="selectAll" />
          </span>
        </div>-->
      </div>
      <br>
    <div class="countries">
      <b-row :key="uniqueId" class="align-items-center">

        <b-col md="4">
          <span class="green">
            {{ `${$t('admin.amount_before_commission')}: ${totalPayment}` }}
            <span>{{$t('admin.riyal')}}</span>
          </span>
        </b-col>

        <b-col md="8" class="adj-form text-left">
          <button :disabled="!enableSubmit" @click="handlePayment" type="button" class="btn btn-success" size="sm" bgGreen>{{$t('admin.payment')}}</button>
          <b-form-file
          :placeholder="$t('admin.choose_file')"
          :browse-text="$t('admin.browse_file')"
          name="image"
          ref="fileupload"
          @change="handleUploadFile"
          ></b-form-file>
          <span v-show="errors.has('image')" class="text-error text-danger text-sm">
              {{ errors.first("image") }}
          </span>
        </b-col>
     </b-row>
      <div class="table_wrap">
        <Table
          :collection="collection"
          :records="fieldsData"
          :pagination="meta"
          @page-changed="onPageChange($event)"
          :key="uniqueId"
        >
          <template v-slot:cell(id)="el">
            <nuxt-link :to="localePath(`/dashboard/product-orders/${el.item.id}`)">{{ Number(el.item.id) }}</nuxt-link>
          </template>

          <template v-slot:cell(store)="el">
            <span class="green">{{ el.item.store.name }}</span>
          </template>

          <template v-slot:cell(total)="el">
            <span>{{ Number(el.item.total) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

          <template v-slot:cell(application_dues_percentage)="el">
            <span>{{ Number(el.item.application_dues_percentage) }}</span>
            <span>%</span>
          </template>

          <template v-slot:cell(application_dues)="el">
            <span>{{ Number(el.item.application_dues) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

          <template v-slot:cell(amount_before_commission)="el">
            <span>{{ (Number(el.item.total) - Number(el.item.application_dues)).toFixed(2) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

          <template v-slot:cell(created_at)="el">
            <div class="text-center">
              <p>
                {{`${$t('admin.date')}: ${el.item.due_date}`}}
              </p>
              <p>
                {{`${$t('admin.time')}: ${el.item.due_time}`}}
              </p>
            </div>
          </template>

          <template v-slot:cell(action)="el">

            <input type="checkbox" name="order_id" :value="el.item.id"
             @change="togglePayment" :checked="orderIds.includes(el.item.id)" />

          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
