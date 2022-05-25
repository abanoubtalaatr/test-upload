<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <formData :categories="categories" :stores="stores" :brands="brands" :countries="countries" :settings="settings"/>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

