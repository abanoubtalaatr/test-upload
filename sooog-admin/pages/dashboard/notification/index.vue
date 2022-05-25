<template>
<div>

  <DeleteModal
    :is-active="isModalActive"
    @confirm="trashConfirm('event-delete-brand')"
    @cancel="trashCancel"
  />

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <nuxt-link :to="localePath('dashboard-notification-create')"
            class="btn btn-success"
            v-show="permissions.includes('notifications.create')"
          >
            <i class="fas fa-plus"></i>
            {{ $t("admin.create") }}
          </nuxt-link>
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
        >
          <template v-slot:cell(id)="el">
            <span>
              {{collection.indexOf(el.item) + 1}}
            </span>
          </template>

          <template v-slot:cell(action)="el">

            <!--<span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item.id)"-->
              <!--:title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">-->
              <!--<i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />-->
            <!--</span>-->

            <!--<nuxt-link class="table_icon" :to="localePath(`/dashboard/brands/${el.item.id}/edit`)"-->
              <!--&gt;<i class="far fa-edit"></i-->
            <!--&gt;</nuxt-link>-->

            <span class="table_icon mr-2" @click="trashModal(el.item.id)" v-show="permissions.includes('notifications.delete')"
              ><i class="far fa-trash-alt red"></i>
            </span>

          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
