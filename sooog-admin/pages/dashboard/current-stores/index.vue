<template>
<div>

  <deactivateModal/>

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <nuxt-link :to="localePath('dashboard-current-stores-featured')"
            class="btn btn-success"
            v-show="permissions.includes('stores.featured')"
          >
            <i class="fas fa-diamond"></i>
            {{ $t("admin.set_featured_stores") }}
          </nuxt-link>
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
          <template v-slot:cell(is_featured)="el">
            <span class="table_icon">
              <i
                v-if="el.item.is_featured == true"
                class="fas fa-circle green"
              ></i>
              <i
                v-if="el.item.is_featured == false"
                class="fas fa-circle red"
              ></i>
            </span>
          </template>

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

            <span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item)" v-show="permissions.includes('stores.update')"
              :title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">
              <i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/current-stores/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>
            <nuxt-link class="table_icon" :to="localePath(`/dashboard/current-stores/${el.item.id}/edit`)" v-show="permissions.includes('stores.update')"
              ><i class="far fa-edit"></i
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
