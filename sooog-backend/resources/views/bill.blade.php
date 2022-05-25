
<!DOCTYPE html>
<html class="no-js" lang="ar">
  <head>
    <title>bill</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
      * { font-family: DejaVu Sans, sans-serif !important; }
      .head{margin: 10px 0 20px;}
      table{
        border: 1px solid #eee;
      }
      table th{background: rgb(184, 184, 184) !important;color: #fff;}
      table tr td:not(:last-child){border-right: 1px solid #eee;}
      table tr:not(.tname) th:not(:last-child){
        border-right:1px solid #eee; ;
      }
      .bar-wrap img{
        max-width: 100%;
        max-height: 300px;
        float: right;
        border:1px solid #eee;
        padding: 5px;
        margin-bottom: 10px;
      }
      img{
        width: 200px;
        height: 150px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="head text-center">
        <h2>فاتوره ضريبيه</h2>
        <h2>Tax Invoice</h2>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                    <td><label for="">Invoice Number</label></td>
                    <td><span>{{$order->id}}</span></td>
                    <!-- <td class="text-end">
                    <span>{{$order->id}}</span>
                    </td>
                    <td class="text-end">
                    <label for="">رقم الفاتوره</label>
                    </td> -->
                    <td rowspan="4">
                    <img src="{{$order->qr_code}}" alt="">
                    </td>
                </tr>
                <tr>
                    <td><label for="">Vat Number</label></td>
                    <td><span>{{$order->store->commercial_registry_no}}</span></td>
                    <!-- <td class="text-end">
                    <span>{{$order->id}}</span>
                    </td>
                    <td class="text-end">
                    <label for="">رقم الفاتوره</label>
                    </td> -->
                </tr>
                <tr>
                  <td><label for="">Invoice Date</label></td>
                  <td><span>{{$order->created_at}}</span></td>
                  
                  <!-- <td class="text-end">
                    <span>{{$order->created_at}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">تاريخ اصدار الفاتوره</label>
                  </td> --> 
                </tr>
                <tr>
                  <td><label for="">Date of supply</label></td>
                  <td><span>{{$order->created_at}}</span></td>
                  <!-- <td class="text-end">
                    <span>{{$order->created_at}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">تاريخ التنفيذ</label>
                  </td> -->
                </tr>
              </tbody>
            </table>
          </div>
          <!-- <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td><label for="">Invoice Issue Date</label></td>
                  <td><span>{{$order->created_at}}</span></td>
                  <td class="text-end">
                    <span>{{$order->created_at}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">تاريخ اصدار الفاتوره</label>
                  </td>
                </tr>
                <tr>
                  <td><label for="">Date of supply</label></td>
                  <td><span>{{$order->created_at}}</span></td>
                  <td class="text-end">
                    <span>{{$order->created_at}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">تاريخ التنفيذ</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div> -->
        </div>
        <!-- <div class="col-sm-6">
          <div class="bar-wrap">
             <img src="{{$order->qr_code}}" alt="">
          </div>
        </div> -->
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="responsive-table">
            <table class="table">
              <thead>
                <tr>
                  <th>Seller:</th>
                  <th></th>
                  <th></th>
                  <th class="text-end">:البائع</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <label for="">{{$order->store->type == 'stores' ? 'Store Name' : 'Center Name'}}</label>
                  </td>
                  <td>
                    <span>{{$order->store->translate('en')->name}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->store->type == 'stores' ? 'اسم المتجر' : 'اسم المركز'}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">{{$order->store->translate('ar')->name}}</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Phone:</label>
                  </td>
                  <td>
                    <span>{{$order->store->phone}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->store->phone}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: رقم الجوال</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Email :</label>
                  </td>
                  <td>
                    <span>{{$order->store->email}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->store->email}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: البريد الالكترونى</label>
                  </td>
                </tr>
                <tr>
                  <td >
                    <label for="">City :</label>
                  </td>
                  <td>
                    <span>{{$order->store->city->translate('en')->name}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->store->city->translate('ar')->name}}</span>
                  </td>
                  <td class="text-end">
                      <label for="">: المدينة</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Address :</label>
                  </td>
                  <td>
                    <span>{{$order->store->address}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->store->address}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: العنوان</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-6">
          <div class="responsive-table">
            <table class="table">
              <thead>
                <tr>
                  <th>Buyer :</th>
                  <th></th>
                  <th></th>
                  <th class="text-end">: العميل</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <label for="">Name :</label>
                  </td>
                  <td>
                    <span>{{$order->user->name}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->user->name}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: الاسم</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Phone :</label>
                  </td>
                  <td>
                    <span>{{$order->user->phone}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->user->phone}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: رقم الجوال</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Email :</label>
                  </td>
                  <td>
                    <span>{{$order->user->email}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->user->email}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: البريد الالكترونى</label>
                  </td>
                </tr>
                <tr>
                  <td >
                    <label for="">City :</label>
                  </td>
                  <td>
                    <span>{{$order->userAddress->city->translate('en')->name}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->userAddress->city->translate('ar')->name}}</span>
                  </td>
                  <td class="text-end">
                      <label for="">: المدينة</label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="">Address :</label>
                  </td>
                  <td>
                    <span>{{$order->userAddress->address}}</span>
                  </td>
                  <td class="text-end">
                    <span>{{$order->userAddress->address}}</span>
                  </td>
                  <td class="text-end">
                    <label for="">: العنوان</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr class="tname">
              <th>
                <label for="">Line Items</label>
              </th>
              <th></th>
              <th class="text-end">
                <label for="">توصيف السلعه او الخدمه</label>
              </th>
            </tr>
            <tr>
              <th>
                <label for="">Nature of goods</label>
                <label for="">تفاصيل السلع</label>
              </th>
              <th>
                <label for="">Unit price</label>
                <label for="">سعر الوحده</label>
              </th>
              <th>
                <label for="">Quantity</label>
                <label for="">الكميه</label>
              </th>

            </tr>
          </thead>
          <tbody>
            @if($order->store->type == 'stores')
                @foreach($order->orderItems as $item)
                <tr>
                <td>
                    <span>{{$item->product->name}}</span>
                    @if($item->warranty_id)
                    <div>{{$item->warranty->name}} - {{$item->product->name}}</div>
                    @endif
                </td>
                <td>
                    <span>{{number_format($item->product_price - $item->offer_discount, 2, '.', '')}} SAR</span>
                    @if($item->warranty_id)
                    <div>{{$item->warranty->price}} SAR</div>
                    @endif
                </td>
                <td>
                    <span>{{$item->quantity}}</span>
                </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td>
                    <span>{{$order->orderService->service->name}}</span>
                </td>
                <td>
                    <span>{{$order->orderService->service_price}} SAR</span>
                </td>
                <td>
                    <span>1</span>
                </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr class="tname">
              <th>
                <label for=""> Total amounts :</label>
              </th>
              <th></th>
              <th>
                <label for="">: اجمالي المبلغ</label>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <span>Total (excloading VAT) :</span>
              </td>
              <td>
                <span>: الاجمالي (غير شامل ضريبه القيمه  المضافه)</span>
              </td>
              <td>{{number_format(floatval($order->subtotal) - floatval($order->offer_discount), 2, '.', '')}} SAR</td>
            </tr>
            {{--<tr>--}}
              {{--<td>--}}
                {{--<span>Total Warranties :</span>--}}
              {{--</td>--}}
              {{--<td>--}}
                {{--<span>: الاجمالي الضمان</span>--}}
              {{--</td>--}}
              {{--<td>{{$order->warranties_amount}} SAR</td>--}}
            {{--</tr>--}}
            @if(intval($order->promo_code_discount))
            <tr>
              <td>
                <span>Discount :</span>
              </td>
              <td>
                <span>: مجموع الخصومات</span>
              </td>
              <td>{{$order->promo_code_discount}} SAR</td>
            </tr>
            @endif
            <tr>
              <td>
                <span>Delivery Charge</span>
              </td>
              <td>
                <span>: رسوم الشحن</span>
              </td>
              <td>{{$order->delivery_charge}} SAR</td>
            </tr>
            <tr>
              <td>
                <span>Total VAT :</span>
              </td>
              <td>
                <span>: مجموع ضريبه القيمه المضافه</span>
              </td>
              <td>{{$order->order_added_tax}} SAR</td>
            </tr>
            @if($order->wallet_payout)
            <tr>
              <td>
                <span>Use Wallet :</span>
              </td>
              <td>
                <span>: خصم من المحفظة</span>
              </td>
              <td>{{$order->wallet_payout}} SAR</td>
            </tr>
            @endif
            <tr>
              <td>
                <span>Total amount due :</span>
              </td>
              <td>
                <span>: اجمالي المبلغ المستحق</span>
              </td>
              <td>{{$order->total}} SAR</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
