<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <formData 
          :itemType="`stores`" 
          :is_child="true"
          :categories="categories"
        />
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

