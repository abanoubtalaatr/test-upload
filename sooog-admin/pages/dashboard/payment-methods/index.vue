<template>
<div>

  <title-bar :title-stack="titleStack" />
  <b-container>

    <div class="countries">

      <div class="table_wrap">
        <Table
          :collection="collection"
          :records="fieldsData"
          :pagination="meta"
          @page-changed="onPageChange($event)"
          :key="uniqueId"
        >

          <template v-slot:cell(is_active)="el">
            <span class="table_icon">
              <i
                v-if="el.item.is_active == 1"
                class="fas fa-circle green"
              ></i>
              <i
                v-if="el.item.is_active == 0"
                class="fas fa-circle red"
              ></i>
            </span>
          </template>

          <template v-slot:cell(action)="el">
            <span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item.id)"
                  :title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">
              <i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />
            </span>
          </template>
        </Table>
      </div>
    </div>
  </b-container>
</div>

</template>

<script src="./index.js"></script>
