<?php

namespace App\Models\Concerns;

use Mavinoo\Batch\Batch;

trait HasBatch
{
    /**
     * Update multiple rows.
     *
     * Example:
     * ```
     * use App\Models\User;
     *
     * $values = [
     *     [
     *         'id' => 1,
     *         'status' => 'active',
     *         'nickname' => 'Mohammad',
     *     ],
     *     [
     *         'id' => 5,
     *         'status' => 'deactive',
     *         'nickname' => 'Ghanbari',
     *     ],
     *     [
     *         'id' => 7,
     *         'balance' => ['+', 500],
     *     ],
     * ];
     *
     * User::batchUpdate($values, 'id');
     * ```
     */
    public static function batchUpdate(array $values, string $index = null, bool $raw = false): bool|int
    {
        return app(Batch::class)->update(new static, $values, $index, $raw);
    }

    /**
     * Insert multiple rows.
     *
     * Example:
     * ```
     * use App\Models\User;
     *
     * $columns = [
     *     'firstName',
     *     'lastName',
     *     'email',
     *     'isActive',
     *     'status',
     * ];
     * $values = [
     *     [
     *         'Mohammad',
     *         'Ghanbari',
     *         'emailSample_1@gmail.com',
     *         '1',
     *         '0',
     *     ] ,
     *     [
     *         'Saeed',
     *         'Mohammadi',
     *         'emailSample_2@gmail.com',
     *         '1',
     *         '0',
     *     ] ,
     *     [
     *         'Avin',
     *         'Ghanbari',
     *         'emailSample_3@gmail.com',
     *         '1',
     *         '0',
     *     ] ,
     * ];
     * $batchSize = 500; // insert 500 (default), 100 minimum rows in one query
     *
     * User::batchInsert($columns, $values, $batchSize);
     * ```
     */
    public static function batchInsert(array $columns, array $values, int $batchSize = 500, bool $insertIgnore = false): bool|array
    {
        return app(Batch::class)->insert(new static, $columns, $values, $batchSize, $insertIgnore);
    }
}
