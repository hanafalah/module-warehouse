<?php

namespace Hanafalah\ModuleWarehouse\Models\ModelHasRoom;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleWarehouse\Models\Building\Room;

class ModelHasRoom extends BaseModel
{
    use HasProps, HasCurrent;

    public $current_conditions = ['reference_id', 'reference_type'];
    protected $list = [
        'id',
        'room_id',
        'reference_id',
        'reference_type',
        'current',
        'props'
    ];

    //EIGER SECCTION
    public function reference()
    {
        return $this->morphTo(__FUNCTION__, "reference_id", "reference_type");
    }
    public function room()
    {
        return $this->morphOne(Room::class, "reference");
    }
    //END EIGER SECTION
}
