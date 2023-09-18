<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    protected $dateFormat = 'U';

    const DELETE_YES = 1;
    const DELETE_NO  = 0;

    /**
     * 新增记录
     */
    public function addData()
    {
        $arr = [];
        foreach ($this->fillable as $field) {
            if ($this->$field === null) {
                continue;
            }

            $arr[$field] = $this->$field;
        }

        return self::query()->create($arr);
    }

    /**
     * 将Query转换成待参数的sql
     * @param Builder $query
     * @return string
     */
    public static function toSqlWithParam(Builder $query): string
    {
        $rawSql = str_replace('?', '"%s"', $query->toSql());
        return sprintf($rawSql, ...$query->getBindings());
    }
}
