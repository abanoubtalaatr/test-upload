<template>
<div>

  <DeleteModal
    :is-active="isModalActive"
    @confirm="trashConfirm('event-delete-city')"
    @cancel="trashCancel"
  />

  <title-bar :title-stack="titleStack" />
  <b-container>
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <nuxt-link :to="localePath('dashboard-locations-cities-create')"
            class="btn btn-success"
            v-show="permissions.includes('cities.create')"
          >
            <i class="fas fa-plus"></i>
            {{ $t("admin.create") }}
          </nuxt-link>
        </div>
        <div class="level-right flex-d">
          <div>
            <!-- <b-dropdown id="dropdown-1" text="Search for country">
              <b-dropdown-item>First Action</b-dropdown-item>
            </b-dropdown> -->
            <multiselect
                  v-model="country"
                  :options="countries.map(obj => obj.id)"
                  :custom-label="opt => countries.find(obj => obj.id == opt).name"
                  value="id"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.select')+' '+$t('admin.country')+ '  '"
                  label="name"
                  :allowEmpty="true"
                  :preselect-first="false"
                  name="country"
                   @select="changeCountry"
                  @input="loadAsyncData"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
          </div>
          <div>
            <!-- <b-dropdown id="dropdown-2" text="Search for state">
              <b-dropdown-item>First Action</b-dropdown-item>
            </b-dropdown> -->
            <multiselect
                  v-if="states"
                  v-model="state"
                  :options="states.map(obj => obj.id)"
                  :custom-label="opt => states.find(obj => obj.id == opt).name"
                  value="id"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.select')+' '+$t('admin.state')+ '  '"
                  label="name"
                  :allowEmpty="true"
                  :preselect-first="false"
                  name="state"
                  @input="loadAsyncData"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
          </div>
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
          <template v-slot:cell(country)="el">
            <span class="table_icon">
              {{el.item.state.country.name}}
            </span>
          </template>
          <template v-slot:cell(state)="el">
            <span class="table_icon">
              {{el.item.state.name}}
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

            <span class="table_icon mr-2" @click.prevent="handleToggleStatus(el.item.id)" v-show="permissions.includes('cities.update')"
              :title="`${el.item.is_active ? $t('admin.inactiveTitle') : $t('admin.activeTitle')}`">
              <i :class="`${el.item.is_active ? 'red fa fa-times-circle' : 'green fa fa-check-square'}`" />
            </span>

            <nuxt-link class="table_icon" :to="localePath(`/dashboard/locations/cities/${el.item.id}/edit`)" v-show="permissions.includes('cities.update')"
              ><i class="far fa-edit"></i
            ></nuxt-link>

            <span class="table_icon mr-2" @click="trashModal(el.item.id)" v-show="permissions.includes('cities.delete')"
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
