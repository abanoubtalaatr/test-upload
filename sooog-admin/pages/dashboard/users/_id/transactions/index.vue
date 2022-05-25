<template>
  <div>
      <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <button @click="createRow"
            class="btn btn-info"
          >
            <i class="fas fa-file-excel-o"></i>
            {{ $t("admin.add_transaction") }}
          </button>
          
        </div>
        <!-- <div class="level-right">
          <Search />
        </div> -->
      </div>
      <div class="table_wrap">
        <Table
          :collection="transactions"
          :records="fieldsData"
          :pagination="meta"
          @page-changed="onPageChange($event)"
        >
          <template v-slot:cell(type)="el">
            <span  v-if="el.item.type == 'pay_in'">{{$t('admin.pay_in')}}</span>
            <span  v-else>{{$t('admin.pay_out')}}</span>
          </template>
        </Table>
      </div>
    </div>
    <formData />
  </b-container>
  </div>
</template>

<script src="./index.js"></script>
