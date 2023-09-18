<?php

namespace App\Console\Commands\Amap;


use App\Http\Service\area\AmapService;
use App\Models\Area\AmapRegionBoundaryModel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class UpdateAmapRegionBoundary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amap:updateAmapRegionBoundary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定期更新高德行政区域及其区域边界';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed|void
     * @throws GuzzleException
     */
    public function handle()
    {

        ini_set('memory_limit', '2048M');

        // 以当前时间设定一个版本
        $version = Carbon::now()->format('Ymd');

        $amapKey  = AmapService::getRandomAmapKey();
        $url      = "https://restapi.amap.com/v3/config/district?keywords=中国&subdistrict=3&key={$amapKey}";
        $response = (new Client(['http_errors' => false]))
            ->get($url);
        $body     = $response->getBody()->getContents();
        $arr      = json_decode($body, true);

        if (!isset($arr['districts'][0]['districts']) || $arr['status'] != 1) {
            return;
        }

        //获取所有省份
        $provinceList = $arr['districts'][0]['districts'];

        // 省份入库

        foreach ($provinceList as $province) {
            $insertData = [];

            $provinceCenterArr = explode(',', $province['center']);

            $boundary = self::getBoundaryAndStreet($province['adcode']);

            $insertData[] = [
                'name'      => $province['name'] ?? '',
                'code'      => $province['adcode'] ?? 0,
                'pCode'     => 0,
                'level'     => (int)array_search($province['level'], AmapRegionBoundaryModel::LEVEL_MAPPING),
                'cityCode'  => $province['citycode'] ?: 0,
                'centerLat' => $provinceCenterArr[1] ?? 0,
                'centerLng' => $provinceCenterArr[0] ?? 0,
                'boundary'  => self::transformFormat($boundary[0]['polyline'] ?? ''),
                'version'   => $version,
                'createdAt' => time(),
                'updatedAt' => time(),
            ];

            $this->info($province['name'] . ' ing');

            // 城市入库

            foreach ($province['districts'] as $city) {
                $cityCenterArr = explode(',', $city['center']);

                $boundary = self::getBoundaryAndStreet($city['adcode']);

                $insertData[] = [
                    'name'      => $city['name'] ?? '',
                    'code'      => $city['adcode'] ?? 0,
                    'pCode'     => $province['adcode'],
                    'level'     => (int)array_search($city['level'], AmapRegionBoundaryModel::LEVEL_MAPPING),
                    'cityCode'  => $city['citycode'] ?: 0,
                    'centerLat' => $cityCenterArr[1] ?? 0,
                    'centerLng' => $cityCenterArr[0] ?? 0,
                    'boundary'  => self::transformFormat($boundary[0]['polyline'] ?? ''),
                    'version'   => $version,
                    'createdAt' => time(),
                    'updatedAt' => time(),
                ];

                $this->info($province['name'] . '-' . $city['name'] . ' ing');


                // 区县入库

                foreach ($city['districts'] as $district) {
                    $districtCenterArr = explode(',', $district['center']);

                    $boundary = self::getBoundaryAndStreet($district['adcode'], 1);

                    $insertData[] = [
                        'name'      => $district['name'] ?? '',
                        'code'      => $district['adcode'] ?? 0,
                        'pCode'     => $city['adcode'],
                        'level'     => (int)array_search($district['level'], AmapRegionBoundaryModel::LEVEL_MAPPING),
                        'cityCode'  => $district['citycode'] ?: 0,
                        'centerLat' => $districtCenterArr[1] ?? 0,
                        'centerLng' => $districtCenterArr[0] ?? 0,
                        'boundary'  => self::transformFormat($boundary[0]['polyline'] ?? ''),
                        'version'   => $version,
                        'createdAt' => time(),
                        'updatedAt' => time(),
                    ];

                    $this->info($province['name'] . '-' . $city['name'] . '-' . $district['name'] . ' ing');

                    //街道入库

                    $streetDistrict = $boundary['districts'] ?? [];

                    foreach ($streetDistrict as $street) {
                        $this->info($province['name'] . '-' . $city['name'] . '-' . $district['name'] . '-' . $street['name'] . ' ing');
                        $streetCenterArr = explode(',', $street['center']);

                        $insertData[] = [
                            'name'      => $street['name'] ?? '',
                            'code'      => $street['adcode'] ?? 0,
                            'pCode'     => $district['adcode'],
                            'level'     => (int)array_search($street['level'], AmapRegionBoundaryModel::LEVEL_MAPPING),
                            'cityCode'  => $street['citycode'] ?: 0,
                            'centerLat' => $streetCenterArr[1] ?? 0,
                            'centerLng' => $streetCenterArr[0] ?? 0,
                            'boundary'  => [],
                            'version'   => $version,
                            'createdAt' => time(),
                            'updatedAt' => time(),
                        ];

                    }
                }
            }
            // 添加到数据库

            $chunkInsertData = array_chunk($insertData, 50);

            foreach ($chunkInsertData as $chunkInsertDatum) {
                AmapRegionBoundaryModel::query()->insert($chunkInsertDatum);
            }
        }


    }


    /**
     * 获取边界坐标及其街道数据
     * @param $code
     * @param int $subdistrict
     * @return array
     * @throws GuzzleException
     */
    public static function getBoundaryAndStreet($code, int $subdistrict = 0): array
    {
        usleep(500000);
        $amapKey  = AmapService::getRandomAmapKey();
        $url      = "https://restapi.amap.com/v3/config/district?key={$amapKey}&keywords={$code}&subdistrict={$subdistrict}&extensions=all";
        $response = (new Client(['http_errors' => false]))
            ->get($url);
        $body     = $response->getBody()->getContents();
        $arr      = json_decode($body, true);

        if ($arr['status'] != 1) {
            return [];
        }

        return $arr['districts'];

    }


    /**
     * 格式化边界
     * @param $polyline
     * @return string
     */
    public static function transformFormat($polyline): string
    {
        if ($polyline == '') {
            return '[]';
        }
        $polylineArr = explode(';', $polyline);

        $data = [];

        foreach ($polylineArr as $item) {
            $itemArr = explode(',', $item);
            $data[]  = [
                $itemArr[0],
                $itemArr[1]
            ];
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
