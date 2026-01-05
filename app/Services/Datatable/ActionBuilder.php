<?php

namespace App\Services\Datatable;

class ActionBuilder
{
    public static function make($row, $actions)
    {
        $html = '';

        if(!empty($actions['edit'])) {
            $can = $actions['edit']['can'] ?? true;
            if ($can) {
                $html .= '<a href="' . $actions['edit']['url'] . '">
                            <i class="ti tabler-edit icon-base text-primary"></i>
                          </a> ';
            }
        }

        if(!empty($actions['delete'])) {
            $can = $actions['delete']['can'] ?? true;
            if ($can) {
                $html .= '<i class="ti tabler-trash icon-base text-danger delete-record"
                            data-route="' . $actions['delete']['url'] . '"></i>';
            }
        }

        return $html;
    }
}

