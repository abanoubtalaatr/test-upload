<template>
  <div>
    <div class="div modal fade" id="modal-order">
      <div class="modal-dialog">
        <div class="modal-content">
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
          <div class="modal-body">
            <h3>طلب عرض سعر</h3>
            <p class="grey">أدخل تفاصيل عرض السعر</p>
            <select class="form-control login-input">
              <option value="">قسم المنتج</option>
            </select>
            <div class="custom-file-upload">
              <input type="file"><img src="assets/imgs/account/upload.svg" alt=""><span>صورة المنتج</span>
            </div>
            <input class="form-control login-input" type="text" placeholder="الكمية">
            <textarea class="form-control login-input" rows="5" placeholder="تفاصيل المنتج"></textarea>
            <div class="text-center">
              <button class="button btn-gredient big">إرسال<img src="assets/imgs/home/arrow-w.svg" alt=""></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    id: String,
    size: String,
    centered: Boolean,
  },
};
</script>




