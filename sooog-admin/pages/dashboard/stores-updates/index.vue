<template>
<div>

  <deactivateModal/>

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
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

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/stores-updates/${el.item.id}`)"
              ><i class="far fa-eye"></i
            ></nuxt-link>
            <span class="table_icon mr-2" @click.prevent="updatedAction(el.item.store_id,'accept')" v-show="permissions.includes('stores.update')"
                  :title=" $t('admin.acceptTitle')">
              <i class="reen fa fa-check-square" />
            </span>
            <span class="table_icon mr-2" @click.prevent="updatedAction(el.item.store_id,'reject')" v-show="permissions.includes('stores.update')"
                  :title=" $t('admin.rejectTitle')">
              <i class="red fa fa-times-circle" />
            </span>
            <!--<nuxt-link class="table_icon" :to="localePath(`/dashboard/current-stores/${el.item.id}/edit`)" v-show="permissions.includes('stores.update')"-->
              <!--&gt;<i class="far fa-edit"></i-->
            <!--&gt;</nuxt-link>-->

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
