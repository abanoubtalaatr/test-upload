<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="item.name" icon="fas fa-clipboard-list 5x">
        <detailsData
          :item="item"
          :back_route="`dashboard-centers-requests`"
        />
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

