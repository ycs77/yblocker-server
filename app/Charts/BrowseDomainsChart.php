<?php

namespace App\Charts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class BrowseDomainsChart implements Arrayable
{
    protected EloquentCollection $histories;
    protected array $labels;
    protected array $data;
    protected int $limit;

    public function __construct(EloquentCollection $histories, int $limit = null)
    {
        $this->histories = $histories;
        $this->limit = $limit ?? 10;
        $this->setData();
    }

    public static function make(EloquentCollection $histories, int $limit = null)
    {
        return new static($histories, $limit);
    }

    public function setData(): void
    {
        $grouped = $this->histories
            ->groupBy('hostname')
            ->mapWithKeys(fn (Collection $group, string $key) => [$key => count($group)])
            ->sortByDesc(fn (int $count, string $key) => $count)
            ->take($this->limit);

        $this->labels = $grouped->keys()->toArray();
        $this->data = $grouped->values()->toArray();
    }

    public function toArray()
    {
        return [
            'labels' => $this->labels,
            'data' => $this->data,
        ];
    }
}
