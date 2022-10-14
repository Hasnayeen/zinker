<?php

namespace App\Actions;

class CreateTableView
{
    public function __invoke(array $data)
    {
        $data = collect($data);
        $isCollection = $data->every(fn ($item, $key) => is_array($item));

        [$thead, $tbody] = match ($isCollection) {
            false => $this->getVerticalTableView($data),
            default => $this->getHorizontalTableView($data),
        };

        return $this->getTableView($thead, $tbody);
    }

    private function getTableView(string $thead, string $tbody)
    {
        return view('table', ['thead' => $thead, 'tbody' => $tbody])->render();
    }

    private function getVerticalTableView($array)
    {
        return [
            '',
            view('table.vertical', ['properties' => $array])->render(),
        ];
    }

    private function getHorizontalTableView($data)
    {
        $keys = array_keys($data->first());

        return [
            view('table.thead', ['keys' => $keys])->render(),
            view('table.horizontal', ['items' => $data])->render(),
        ];
    }
}
