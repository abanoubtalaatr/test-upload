<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <formData :users="users"/>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

