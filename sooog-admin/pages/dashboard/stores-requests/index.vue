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

            <span class="table_icon mr-2" @click.prevent="handleStatus(el.item, 'accepted')" v-show="permissions.includes('stores.update')"
              :title="$t('admin.acceptTitle')">
              <i class="green fa fa-check-square" />
            </span>
            <span class="table_icon mr-2" @click.prevent="handleStatus(el.item, 'rejected')" v-show="permissions.includes('stores.update')"
              :title="$t('admin.rejectTitle')">
              <i class="red fa fa-times-circle" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/stores-requests/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>

            <!-- <span class="table_icon mr-2" @click="trashModal(el.item.id)"
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
