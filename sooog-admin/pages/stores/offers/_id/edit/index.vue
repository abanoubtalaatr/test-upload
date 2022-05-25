<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <formData
          :item="item"
          :products="products"
        />
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

