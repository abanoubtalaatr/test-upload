<template>
    <div>
        <b-row>
            <b-col lg="6">
                <p><span style="color:green;">{{$t('admin.username') + ' : '}} </span> {{ item.username || '' }}</p>
                <p v-show="item.type =='stores'"><span style="color:green;">{{$t('admin.store_name') + ' : '}} </span> {{ item.name || '' }}</p>
                <p v-show="item.type =='centers'"><span style="color:green;">{{$t('admin.center_name') + ' : '}} </span> {{ item.name || '' }}</p>
                <p><span style="color:green;">{{$t('admin.phone') + ' : '}}</span> {{ item.phone || '' }}</p>
                <p><span style="color:green;">{{$t('admin.email') + ' : '}}</span> {{ item.email || '' }}</p>
                <p><span style="color:green;">{{$t('admin.country') + ' : ' }}</span> {{ item.city ? (item.city.state? item.city.state.country ? item.city.state.country.name : '' : '') : '' }}</p>
                <p><span style="color:green;">{{$t('admin.state') + ' : ' }}</span> {{ item.city ? item.city.state? item.city.state.name : '' : '' }}</p>
                <p><span style="color:green;">{{$t('admin.city') + ' : ' }}</span> {{ item.city ? item.city.name : '' }}</p>
                <p><span style="color:green;">{{$t('admin.address') + ' : ' }}</span> {{ item.address || '' }}</p>
                <p><span style="color:green;">{{$t('admin.bank_name') + ' : ' }}</span> {{ item.bank_name || '' }}</p>
                <p><span style="color:green;">{{$t('admin.iban') + ' : ' }}</span> {{ item.iban || '' }}</p>
                <p><span style="color:green;">{{$t('admin.swift_code') + ' : ' }}</span> {{ item.swift_code || '' }}</p>
                <p><span style="color:green;">{{$t('admin.bank_account_no') + ' : ' }}</span> {{ item.bank_account_no || '' }}</p>
                <p><span style="color:green;">{{$t('admin.commercial_registry_no') + ' : ' }}</span> {{ item.commercial_registry_no || '' }}</p>
                <p><span style="color:green;">{{$t('admin.status') + ' : ' }}</span> {{item.is_active ? $t('active') : $t('inactive')}}</p>
              <p><span style="color:green;">{{$t('admin.package') + ' : ' }}</span> {{item.package?item.package.package_name:''}}</p>
                <img :src="item.commercial_registry_photo" alt="" />

            </b-col>
            <b-col lg="6">
                <img :src="item.image" v-if="item.image" width="200" height="200"/>
            </b-col>
        </b-row>
        <div class="text-center mt-3 mb-2">
            <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>
    </div>
</template>

<script src="./-index.js"></script>
