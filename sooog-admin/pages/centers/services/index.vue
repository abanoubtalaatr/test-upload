<template>
<div>

  <DeleteModal
    :is-active="isModalActive"
    @confirm="trashConfirm('event-delete-service')"
    @cancel="trashCancel"
  />

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <nuxt-link :to="localePath('centers-services-create')"
            class="btn btn-success"
            v-show="permissions.includes('services.create')"
          >
            <i class="fas fa-plus"></i>
            {{ $t("admin.create") }}
          </nuxt-link>
          <button @click="openFilter"
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

            <span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item.id)" v-show="permissions.includes('services.update')"
              :title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">
              <i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/centers/services/${el.item.id}/edit`)" v-show="permissions.includes('services.update')"
              ><i class="far fa-edit"></i
            ></nuxt-link>

            <span class="table_icon mr-2" @click="trashModal(el.item.id)" v-show="permissions.includes('services.delete')"
              ><i class="far fa-trash-alt red"></i>
            </span>

          </template>
        </Table>
      </div>
    </div>
  </b-container>

  <FilterModal />

</div>

</template>

<script src="./index.js"></script>
