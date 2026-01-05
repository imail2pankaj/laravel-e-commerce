@php
function renderMenu($items) {
    if (!is_array($items)) return;

    foreach ($items as $item) {

        if (!is_array($item)) continue;

        // 🔐 Permission check
        if (isset($item['permission']) && !auth()->user()?->can($item['permission'])) {
            continue;
        }

        $hasChildren = isset($item['children']) && is_array($item['children']);

        // Remove children without permission
        if ($hasChildren) {
            $item['children'] = array_filter($item['children'], function ($child) {
                if (!is_array($child)) return false;
                if (!isset($child['permission'])) return true;

                return auth('admin')->user()?->can($child['permission']);
            });

            // If parent has no visible children → hide parent
            if (empty($item['children'])) {
                continue;
            }
        }

        $active = isset($item['route']) && request()->routeIs($item['route']);

        $activeChild = $hasChildren && collect($item['children'])->contains(function ($child) {
            return isset($child['route']) && request()->routeIs($child['route']);
        });

        echo '<li class="menu-item '.(($active || $activeChild) ? 'active open' : '').'">';

        $link = $hasChildren
            ? 'javascript:void(0);'
            : (isset($item['route']) ? route($item['route']) : '#');

        echo '<a href="'.$link.'" class="menu-link '.($hasChildren ? 'menu-toggle' : '').'">';

        if (isset($item['icon'])) {
            echo '<i class="'.$item['icon'].'"></i>';
        }

        echo '<div>'.$item['title'].'</div></a>';

        if ($hasChildren) {
            echo '<ul class="menu-sub">';
            renderMenu($item['children']);
            echo '</ul>';
        }

        echo '</li>';
    }
}
@endphp

@php renderMenu(config('menu')); @endphp
