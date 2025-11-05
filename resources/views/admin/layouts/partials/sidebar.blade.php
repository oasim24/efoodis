@php
$menus = [
    [
        'name' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'bi bi-speedometer2',
        'submenu' => [],
    ],
    [
        'name' => 'Orders',
        'route' => '#',
        'icon' => 'bi bi-speedometer2',
        'submenu' => [
             [
                'name' => 'All Orders',
                'route' => 'orders.index',
                'icon' => 'bi bi-box-seam',
            ],
            
            
            ],
    ],
    [
        'name' => 'Products',
        'route' => '#',
        'icon' => 'bi bi-box',
        'submenu' => [
            [
                'name' => 'All Products',
                'route' => 'products.index',
                'icon' => 'bi bi-box-seam',
            ],
            [
                'name' => 'Categories',
                'route' => 'categories.index',
                'icon' => 'bi bi-tags',
            ],
            [
                'name' => 'Brands',
                'route' => 'brands.index',
                'icon' => 'bi bi-tags',
            ],
        ],
    ],
    [
        'name' => 'Site Setting',
        'route' => '#',
        'icon' => 'bi bi-box',
        'submenu' => [
            [
                'name' => 'Settings',
                'route' => 'settings.index',
                'icon' => 'bi bi-box-seam',
            ],
            [
                'name' => 'Roles',
                'route' => 'roles.index',
                'icon' => 'bi bi-box-seam',
            ],
            [
                'name' => 'Users',
                'route' => 'users.index',
                'icon' => 'bi bi-box-seam',
            ],
            
            
        ],
    ],
];
$currentRoute = Route::currentRouteName(); 
@endphp

<style>
.sidebar {
    width: 15%;
    background: #ffffffff;
   height: calc(100vh - 60px);
   position: absolute;
   left: 0;
   bottom: 0;
    
}

.menu-link {
    display: block;
    padding: 10px 10px;
    color: #333;
    text-decoration: none;
    border-bottom:1px solid black ;
    
}

.menu-link.active {
    background: #3f049eff;
    color: white;
}

.submenu {
    display: none;
}

.submenu.open {
    display: block;
}

.submenu ul li {
    padding: 10px 15px;
    border-bottom: 1px solid black;
}
.submenu ul li a{
    text-decoration: none;
    color: black;
}
.submenu a.active {
    color: #ffffffff;
    font-weight: 600;
    text-decoration: none;
     
}
.submenu li.active {
   background: #3f049eff;
   
     
}
</style>

<div class="sidebar">
    @foreach($menus as $index => $menu)
        @php
        
            $isSubActive = collect($menu['submenu'])->pluck('route')->contains($currentRoute);
        @endphp

        
        @if(!empty($menu['submenu']))
            <div class="menu menu-has-sub">
                <a href="#" class="menu-link {{ $isSubActive ? 'active' : '' }}" data-target="submenu-{{ $index }}">
                    <i class="{{ $menu['icon'] }}"></i> {{ $menu['name'] }}
                    <i class="bi bi-chevron-down float-end"></i>
                </a>

                <div id="submenu-{{ $index }}" class="submenu {{ $isSubActive ? 'open' : '' }}">
                    <ul class="list-unstyled ms-3">
                        @foreach($menu['submenu'] as $submenu)
                            <li class="{{ $currentRoute === $submenu['route'] ? 'active' : '' }}">
                                <a href="{{ route($submenu['route']) }}"
                                   class="{{ $currentRoute === $submenu['route'] ? 'active' : '' }}">
                                    <i class="{{ $submenu['icon'] }}"></i> {{ $submenu['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
           
            <div class="menu menu-single">
                <a href="{{ route($menu['route']) }}"
                   class="menu-link {{ $currentRoute === $menu['route'] ? 'active' : '' }}">
                    <i class="{{ $menu['icon'] }}"></i> {{ $menu['name'] }}
                </a>
            </div>
        @endif
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.menu-has-sub .menu-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const submenu = document.getElementById(targetId);
            submenu.classList.toggle('open');
            document.querySelectorAll('.submenu').forEach(s => { if (s !== submenu) s.classList.remove('open'); });
        });
    });
});
</script>
