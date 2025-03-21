<?php

namespace Hanafalah\ModuleWarehouse\Resources\StockMovement;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewStockMovement extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $props = $this->getOriginal()['props'];
        $arr = [
            'id'            => $this->id,
            'parent_id'     => $this->parent_id,
            'reference'     => $this->relationValidation('reference', function () {
                return $this->reference->toViewApi();
            }),
            'batch_movements' => $this->relationValidation('batchMovements', function () {
                return $this->batchMovements->transform(function ($batchMovement) {
                    return $batchMovement->toViewApi();
                });
            }),
            'goods_receipt_unit' => $this->relationValidation('goodsReceiptUnit', function () {
                return $this->goodsReceiptUnit->toViewApi();
            }),
            'childs'        => $this->relationValidation('childs', function () {
                return $this->childs->transform(function ($child) {
                    return $child->toViewApi();
                });
            }),
            'direction'     => $this->direction,
            'qty'           => $this->qty,
            'opening_stock' => $this->opening_stock,
            'closing_stock' => $this->closing_stock,
            'changes_stock' => abs($this->closing_stock - $this->opening_stock),
            'props'         => $props == [] ? null : $props
        ];

        return $arr;
    }
}
