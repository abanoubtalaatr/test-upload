<template>
<div>

  <title-bar :title-stack="titleStack" />
  <b-container>

      <b-row>
        <b-col md="4">
          <input type="number" class="form-control" v-model="filter.order_id" :placeholder="$t('admin.order_id')"/>
        </b-col>

        <b-col md="4">
          <select class="form-control" v-model="filter.store"
            name="store_id">
              <option selected disabled value="">
                {{$t('admin.store')}}
              </option>
              <option v-for="(store, key) in stores" :key="key" :value="store.id">
                {{store.name}}
              </option>
          </select>
        </b-col>

        <b-col md="4" >
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

    <div class="countries">
      <div class="level">
        <div class="level-left">
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

        <div class="level-right">
          <Search />
        </div>
      </div>

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

          <!-- <template v-slot:cell(application_dues_percentage)="el">
            <span>{{ Number(el.item.application_dues_percentage) }}</span>
            <span>%</span>
          </template>

          <template v-slot:cell(application_dues)="el">
            <span>{{ Number(el.item.application_dues) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template> -->

          <template v-slot:cell(amount_before_commission)="el">
            <span>{{ (Number(el.item.total) - Number(el.item.application_dues)).toFixed(2) }}</span>
            <span>{{$t('admin.riyal')}}</span>
          </template>

          <template v-slot:cell(created_at)="el">
            <div class="text-center">
              <p>
                {{`${el.item.created_at}`}}
              </p>
              <!-- <p>
                {{`${$t('admin.time')}: ${el.item.due_time}`}}
              </p> -->
            </div>
          </template>

          <template v-slot:cell(receipt)="el">

            <a target="_blank" :href="el.item.receipt">
              <!-- {{$t('admin.payment_attachment')}} -->
              <img :src="el.item.receipt" width="100" height="50" class="img-thumbnail" v-if="el.item.file_type == 'image'" />

              <object width="120" height="50" type="application/pdf"
               :data="el.item.receipt" class="img-thumbnail" v-else />

            </a>

          </template>

          <template v-slot:cell(action)="el">

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/payments/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>

          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
