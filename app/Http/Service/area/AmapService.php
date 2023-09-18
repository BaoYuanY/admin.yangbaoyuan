<?php

namespace App\Http\Service\area;

use App\Models\Area\AmapRegionBoundaryModel;
use Illuminate\Support\Facades\Cache;
use League\Geotools\Coordinate\Coordinate;
use League\Geotools\Polygon\Polygon;

class AmapService
{

    /**
     * 获得高德web服务的key
     * @return string
     */
    public static function getRandomAmapKey(): string
    {
        //$keys = [
        //    '49ac92f420af133e6bf6ce5586219c2a',   //彼得潘
        //    'fbe7159dbb34e2a0dbdd687cb7db7933',   //五郎
        //    '638a5878af3080db5d6265cd644f170a',   //飞雨
        //    'dcdd5a123832dc8c534c6d2a3285bd67',   //希曼
        //    '5338a2a7cde8987621846caf53f0b1c1',   //太狼
        //    'ffa97277887e1cf2b2fc0944cd86ec7d',   //公司
        //];

//        $configValue = Cache::remember('amap:web_serve_api_key', 3600, function () {
//            return (string)ConfigModel::query()
//                ->where('module', 'amap')
//                ->where('name', 'webServeApiKey')
//                ->value('value');
//        });
//
//        if ('' === $configValue) {
//            $keys = ['ffa97277887e1cf2b2fc0944cd86ec7d'];  // 公司的key兜底
//            Cache::forget('amap:web_serve_api_key');
//        } else {
//            $configArr = json_decode($configValue, true);
//            $keys      = collect($configArr['normal'])->pluck('key')->toArray();
//        }
//
//        return collect($keys)->random(1)[0];
        return 'ffa97277887e1cf2b2fc0944cd86ec7d';
    }

    /**
     * 通过经纬度获得省市区
     * 纯资源类型获取 不调用api
     * @param $lat
     * @param $lng
     * @param string $province  可选参数 增加查询性能
     * @return array
     */
    public static function getAdCodeByLatAndLng($lat, $lng, string $province = ''): array
    {
        // 获得省份下市code查询 增加效率
        $paramCode = Cache::remember('tiger:amap:cityCodeList', 3600, function () use ($province){
            $city = AmapRegionBoundaryModel::query()
                ->where('level', AmapRegionBoundaryModel::LEVEL_PROVINCE)
                ->when(mb_strlen($province), function ($query) use ($province) {
                    if (is_numeric($province)) {
                        $query->where('code', $province);
                    } else {
                        $province = mb_substr($province, 0, 2);
                        $query->where('name', 'like', "{$province}%");
                    }
                })
                ->with(['cityTerritorialBoundaryRelByCity'])
                ->select(['code', 'pCode'])
                ->first();

            if (null == $city) {
                Cache::forget('tiger:amap:cityCodeList');
                return [];
            } else {
                return optional($city->cityTerritorialBoundaryRelByCity)->pluck('code')->toArray() ?: [];
            }
        });

        // 获得区域code
        $districtCode = 0;
        $cityCode     = 0;
        $districtName = '';
        AmapRegionBoundaryModel::query()
            ->when(!empty($paramCode), function ($query) use ($paramCode) {
                $query->whereIn('pCode', $paramCode);
            })
            ->where('level', AmapRegionBoundaryModel::LEVEL_DISTRICT)
            ->chunkById(20, function ($districtList) use ($lat, $lng, &$cityCode, &$districtCode, &$districtName) {
                foreach ($districtList as $district) {
                    $boundary = collect(json_decode($district->boundary, true))
                        ->map(function ($dot) {
                            if (!isset($dot[0]) || !isset($dot[1]) || $dot[0] == 0 || $dot[1] == 0) {
                                return null;
                            }
                            return [
                                (float)$dot[0],
                                (float)$dot[1]
                            ];
                        })->filter()->values()->toArray();
                    // 创建一个多边形
                    $polygon = new Polygon($boundary);
                    // 判断是否在多边形上
                    $res = $polygon->pointInPolygon(new Coordinate([$lng, $lat]));
                    if ($res) {
                        $cityCode     = $district->pCode;
                        $districtCode = $district->code;
                        $districtName = $district->name;
                        break;
                    }
                }
            });

        // 根据$districtCode获得省市区的code
        $cityModel     = AmapRegionBoundaryModel::query()->where('code', $cityCode)->select(['code', 'pCode', 'name'])->first();
        $provinceModel = AmapRegionBoundaryModel::query()->where('code', $cityModel->pCode)->select(['code', 'name'])->first();

        return [
            'provinceCode' => $provinceModel->code,
            'cityCode'     => $cityModel->code,
            'districtCode' => $districtCode,
            'provinceName' => $provinceModel->name,
            'cityName'     => $cityModel->name,
            'districtName' => $districtName,
        ];
    }

}
