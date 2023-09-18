<?php

namespace App\Models\Area;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmapRegionBoundaryModel extends BaseModel
{
    use HasFactory;

    protected $table = 'amap_region_boundary';

    protected $fillable = [
        'name',
        'code',
        'pCode',
        'level',
        'cityCode',
        'centerLat',
        'centerLng',
        'boundary',
        'version',
        'createdAt',
        'updatedAt',
    ];


    const LEVEL_PROVINCE = 1;
    const LEVEL_CITY     = 2;
    const LEVEL_DISTRICT = 3;
    const LEVEL_STREET   = 4;

    const LEVEL_MAPPING = [
        self::LEVEL_PROVINCE => 'province',
        self::LEVEL_CITY     => 'city',
        self::LEVEL_DISTRICT => 'district',
        self::LEVEL_STREET   => 'street',
    ];


    /**
     * 省到市
     * @return HasMany
     */
    public function cityTerritorialBoundaryRelByCity(): HasMany
    {
        return $this->hasMany(AmapRegionBoundaryModel::class, 'pCode', 'code')->where('level', self::LEVEL_CITY);
    }


    /**
     * 反向关联
     * @return HasMany
     */
    public function getCityCodeProvinceCode(): HasMany
    {
        return $this->hasMany(AmapRegionBoundaryModel::class, 'code', 'pCode');
    }


}
