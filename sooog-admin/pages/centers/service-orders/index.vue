<template>
<div>

  <DeleteModal
    :is-active="isModalActive"
    @confirm="trashConfirm('event-delete-order')"
    @cancel="trashCancel"
  />

  <deactivateModal/>

  <filterModal type="centers"/>

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <!-- <nuxt-link :to="localePath('dashboard-product-orders-create')"
            class="btn btn-success"
          >
            <i class="fas fa-plus"></i>
            {{ $t("admin.create") }}
          </nuxt-link>
          <span>&nbsp;&nbsp;&nbsp;&nbsp;</span> -->
          <button @click="exportToExcel"
            class="btn btn-info"
          >
            <i class="fas fa-file-excel-o"></i>
            {{ $t("admin.export_to_excel") }}
          </button>

          <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <button @click="$EventBus.$emit('open-order-filter-modal')"
            class="btn btn-primary"
          >
            <i class="fas fa-filter"></i>
            {{ $t("admin.filter") }}
          </button>
          <a @click="resetFilter"
            class="btn btn-dark"
          >
            <i class="fas fa-undo"></i>
            <!-- {{ $t("admin.reset") }} -->
          </a>

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
            <span class="table_icon mr-2" v-if="el.item.status.key == 'new'" @click.prevent="handleChangeStatus(el.item, 'accepted')"
              :title="$t('admin.accepted')" v-show="permissions.includes('orders.update')">
              <i class="green fa fa-check-square" />
            </span>

            <span class="table_icon mr-2" v-if="el.item.status.key == 'new'" @click.prevent="handleChangeStatus(el.item, 'rejected')"
              :title="$t('admin.rejected')" v-show="permissions.includes('orders.update')">
              <i class="red fa fa-times-circle" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/centers/service-orders/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>

            <nuxt-link class="table_icon" :to="localePath(`/centers/service-orders/${el.item.id}/edit`)" v-show="permissions.includes('orders.update')"
              ><i class="far fa-edit"></i
            ></nuxt-link>

            <!-- <span class="table_icon mr-2" @click="trashModal(el.item.id)" v-show="permissions.includes('orders.delete')"
              ><i class="far fa-trash-alt red"></i>
            </span> -->

          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
