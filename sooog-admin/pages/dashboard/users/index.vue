<template>
<div>

  <deactivateModal/>

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <button @click="exportToExcel"
            class="btn btn-info"
          >
            <i class="fas fa-file-excel-o"></i>
            {{ $t("admin.export_to_excel") }}
          </button>

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
          @sort-updated="sortingChanged"
        >
          <template v-slot:cell(is_active)="el">
            <span class="table_icon">
              <i
                v-if="el.item.is_active == true"
                class="fas fa-circle green"
              ></i>
              <i
                v-if="el.item.is_active == false"
                class="fas fa-circle red"
              ></i>
            </span>
          </template>

          <template v-slot:cell(action)="el">

            <span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item)" v-show="permissions.includes('users.update')"
              :title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">
              <i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/users/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>
            <nuxt-link :to="{path: localePath(`/dashboard/product-orders`), query:{customer_id: el.item.id}}"
             :title="$t('admin.product_orders')" v-show="permissions.includes('orders.index')">
              <i class="fas fa-list"></i>
            </nuxt-link>
             <!--<nuxt-link :to="{path: localePath(`/dashboard/service-orders`), query:{customer_id: el.item.id}}"-->
             <!--:title="$t('admin.service_orders')" v-show="permissions.includes('orders.index')">-->
              <!--<i class="fas fa-wallet"></i>-->
            <!--</nuxt-link>-->

          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
