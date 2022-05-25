<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <refundData
          :item="item"
          :refund_reasons="refund_reasons" 
        />
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

