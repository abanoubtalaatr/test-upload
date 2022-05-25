<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Product\Domain\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Domain\Resources\GenericNameResource;

class CheckPromoCodeService extends Service
{
    public function handle($data = []) 
    {
        try {
            // if($data['items'] <= 0)
            //     return new GenericPayload(__('error.orders.emptyCart'), 422);

            $promo_code = PromoCode::where([
                ['code', $data['promo_code']],
                ['is_active', 1],
                ['start_date', '<=', date('Y-m-d')], 
                ['end_date', '>=', date('Y-m-d')]
            ])->whereRelation('stores', 'stores.id', $data['store_id'])->first();
            if(!$promo_code)
                return new GenericPayload(
                    __('error.coupons.invalidCoupon'), 422
                );
            if($promo_code->applied_to == 'specific_user' && $promo_code->user_id != auth()->id())
                return new GenericPayload(
                    __('error.coupons.invalidCoupon'), 422
                );

            $previous_orders_count = $promo_code->orders->where('promo_code_id', $promo_code->id)->count();
            if($previous_orders_count >= $promo_code->max_use_number)
                return new GenericPayload(
                    __('error.promo_codes.maxUsageNo'), 422
                );
            // $order_calculations = $this->getOrderSubtotal($data['items']);
            // $data['subtotal'] = $order_calculations['subtotal'];
            // $data['offer_discount'] = $order_calculations['offer_discount'];
            // $data['warranties_amount'] = $order_calculations['warranties_amount'];
            // $data['delivery_charge'] = $store->has_delivery_service == 1 ? $store->delivery_charge : setting('delivery_charge');
            // $data['total'] = $data['subtotal'] + $data['delivery_charge'] + $data['warranties_amount'] - $data['offer_discount'];
            // $order_added_tax = setting('order_added_tax');
            // if($order_added_tax)
            //     $data['order_added_tax'] = $data['total'] * $order_added_tax / 100;
            // else
            //     $data['order_added_tax'] = 0.000;
            // $data['total'] += $data['order_added_tax'];
            // $discount = $this->getPromoCodeDiscount($promo_code, $$data['total']);
            
            // return new GenericPayload(['type' => $promo_code->type, 'discount' => $discount], Response::HTTP_RESET_CONTENT);
            return new GenericPayload(new GenericNameResource($promo_code), Response::HTTP_RESET_CONTENT);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }

    private function getOrderSubtotal($items){
        $subtotal = 0.00;
        $offer_discount = 0.00;
        $warranties_amount = 0.000;
        foreach ($items as $item) {
            $product = ProductView::findOrFail($item['product_id']);
            //$subtotal +=  $item->quantity *($product->price_including_tax - $this->getDiscount($product)['value']);
            $subtotal +=  $item->quantity * $product->price_including_tax;
            $offer_discount +=  $item->quantity * $this->getDiscount($product)['value'];
            if(isset($item['warranty_id'])){
                $warranty = Warranty::findOrFail($item['warranty_id']);
                $warranties_amount += $warranty->price;
            }
        }
        return ['subtotal' => $subtotal, 'offer_discount' => $offer_discount, 'warranties_amount' => $warranties_amount];
    }

    private function getDiscount($product){
        $discount = 0.00;
        $free_product = null;
        $offer = $product->offer->first();
        if ($offer){
            if ($offer->type == "free_product"){
                $free_product = $offer->free_product_id;
            }else if ($offer->type == 'percentage'){
                $discount = $product->price_including_tax * $offer->value / 100;
            }else{
                $discount = $offer->value;
            }
        }

        return array ('id' => optional($offer)->id, 'value' => $discount, 'free_product' => $free_product);
    }

    private function getPromoCodeDiscount($promo_code, $total){
        $cart = auth()->user()->cart()->get();
        $discount = 0.00;
        $total = 0.00;
        if ($promo_code){
            if ($promo_code->type == "value"){
                $discount = $total > 0 ? $promo_code->value : 0.00;
            }else if ($promo_code->type == 'percentage'){
                $discount = $total * $promo_code->value / 100;
            }else{
                $discount = 0.00;
            }
        }

        return $discount;
    }

}