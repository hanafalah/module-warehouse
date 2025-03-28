<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\ModuleWarehouse\Resources\Stock\ShowStock;
use Hanafalah\ModuleWarehouse\Resources\Stock\ViewStock;

class Stock extends MainStock
{
    use HasProps;

    protected $list = [
        'id',
        'parent_id',
        'funding_id',
        'subject_type',
        'subject_id',
        'warehouse_type',
        'warehouse_id',
        'stock'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            //CHECK AND CREATE PARENT STOCK IF STOCK HAS FUNDING AND PARENT STOCK DOESNT EXIST
            if (isset($query->funding_id) && !isset($query->parent_id)) {
                $stock_model  = new static();
                $parent_model = $stock_model->firstOrCreate([
                    'subject_type'   => $query->subject_type,
                    'subject_id'     => $query->subject_id,
                    'warehouse_type' => $query->warehouse_type,
                    'warehouse_id'   => $query->warehouse_id
                ], [
                    'stock' => 0
                ]);
                $query->parent_id = $parent_model->getKey();
            }
        });
        // static::created(function($query){
        //     if (isset($query->parent_id)) static::recalculatingStock($query);
        // });
        // static::updated(function($query){
        //     if (isset($query->parent_id)) static::recalculatingStock($query);
        // });
    }

    // private static function recalculatingStock($query){
    //     if ($query->isDirty('stock')) {
    //         $stock          = $query->stock ?? 0;
    //         $original_stock = $query->getOriginal('stock');
    //         $parent         = $query->parent;
    //         if (isset($parent)){
    //             $parent->stock += $stock - $original_stock;
    //             $parent->save();
    //         }
    //     }
    // }

    public function toViewApi()
    {
        return new ViewStock($this);
    }

    public function toShowApi()
    {
        return new ShowStock($this);
    }

    //EIGER SECTION
    public function subject()
    {
        return $this->morphTo('subject');
    }
    public function warehouse()
    {
        return $this->morphTo('warehouse');
    }
    public function stockBatch()
    {
        return $this->hasOneModel('StockBatch', 'stock_id');
    }
    public function stockBatches()
    {
        return $this->hasManyModel('StockBatch', 'stock_id');
    }
    public function funding()
    {
        return $this->belongsToModel('Funding');
    }
    public function batches()
    {
        return $this->belongsToManyModel(
            'Batch',
            'StockBatch',
            'stock_id',
            'batch_id'
        );
    }
}
