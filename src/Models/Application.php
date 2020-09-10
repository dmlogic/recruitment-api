<?php

namespace Dmlogic\RecruitmentApi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dmlogic\RecruitmentApi\ApplicationPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'confirmed_at' => 'datetime'
    ];

    public function toArray()
    {
        return (new ApplicationPresenter($this))->toArray();
    }

    public function isComplete()
    {
        if(!array_filter([$this->name, $this->cover_letter, $this->code_example])) {
            return false;
        }
        if(!$this->cv && !$this->cv_upload) {
            return false;
        }
        return true;
    }

    public function position()
    {
        return $this->hasOne(Position::class,'reference','position_reference');
    }
}
