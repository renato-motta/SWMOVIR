<?php

return [
      [
            'type' => 'header',
         'title'=>'Principal',   
      ],

      [
            'type' => 'link',
         'title'=>'Dashboard',
         'icon'=>'fa-solid fa-gauge',
         'route'=>'admin.dashboard',
         'active'=>'admin.dashboard',
      ],

      [
            'type' => 'group',
         'title'=>'Inventario',
         'icon'=>'fa-solid fa-boxes-stacked',
         'route'=>'admin.dashboard',
         'active'=>[
            'admin.categories.*',
            'admin.products.*',
            'admin.warehouses.*',
         ],
         'items'=>[
            [    
                'type' => 'link',
               'title'=>'Categorias',
               'icon'=>'fa-solid fa-list',
               'route'=>'admin.categories.index',
               'active'=>'admin.categories.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Productos',
               'icon'=>'fa-solid fa-box',
               'route'=>'admin.products.index',
               'active'=>'admin.products.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Almacenes',
               'icon'=>'fa-solid fa-warehouse',
               'route'=>'admin.warehouses.index',
               'active'=>'admin.warehouses.*',
            ],
         ],
      ],

      [
        'type' => 'group',
         'title'=>'compras',
         'icon'=>'fa-solid fa-cart-shopping',
         'active'=>[
            'admin.suppliers.*',
            'admin.purchase-orders.*',
            'admin.purchases.*',
         ],
         'items'=>[
            [ 
                'type' => 'link',
               'title'=>'Proveedores',
               'route'=>'admin.suppliers.index',
               'active'=>'admin.suppliers.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Ordenes de Compra',
               'route'=>'admin.purchase-orders.index',
               'active'=>'admin.purchase-orders.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Compras',
               'route'=>'admin.purchases.index',
               'active'=>'admin.purchases.*',
            ],
         ],
      ],

      [
        'type' => 'group',
         'title'=>'Ventas',
         'icon'=>'fa-solid fa-cash-register',
         'active'=>[
            'admin.customers.*',
            'admin.quotes.*',
            'admin.sales.*',
         ],
         'items'=>[
            [ 
                'type' => 'link',
               'title'=>'Clientes',
               'route'=>'admin.customers.index',
               'active'=>'admin.customers.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Cotizaciones',
               'route'=>'admin.quotes.index',
               'active'=>'admin.quotes.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Ventas',
               'route'=>'admin.sales.index',
               'active'=>'admin.sales.*',
            ],
         ],
      ],

      [ 
        'type' => 'group',
         'title'=>'Moviemientos',
         'icon'=>'fa-solid fa-arrows-rotate',
         'active'=>[
            'admin.movements.*',
            'admin.transfers.*',
         ],
         'items'=>[
            [ 
                'type' => 'link',
               'title'=>'Entradas y salidas',
               'route'=>'admin.movements.index',
               'active'=>'admin.movements.*',
            ],
            [ 
                'type' => 'link',
               'title'=>'Transferencias',
               'route'=>'admin.transfers.index',
               'active'=>'admin.transfers.*',
            ],
         ],
      ],

      [ 
                'type' => 'group',
         'title'=>'Reportes',
         'icon'=>'fa-solid fa-chart-line',
         'active'=>[
            'admin.reports.top-products',
            'admin.reports.top-customers',
            'admin.reports.low-stock',
         ],
         'items'=>[   
            [ 
                'type' => 'link',
               'title'=>'Productos top',
               'route'=>'admin.reports.top-products',
               'active'=>'admin.reports.top-products',
            ],
            [ 
                'type' => 'link',
               'title'=>'Clientes frecuentes',
               'route'=>'admin.reports.top-customers',
               'active'=>'admin.reports.top-customers',
            ],
            [ 
                'type' => 'link',
               'title'=>'stock bajo',
               'route'=>'admin.reports.low-stock',
               'active'=>'admin.reports.low-stock',
            ],
         ],
      ],

      [
            'type' => 'header',
         'title'=>'Configuración',   
      ],

      [
            'type' => 'link',
         'title'=>'Usuarios',
         'icon'=>'fa-solid fa-users',
         'route'=>'admin.users.index',
         'active'=>'admin.users.*',
      ],

      [
            'type' => 'link',
         'title'=>'Roles',
         'icon'=>'fa-solid fa-shield-halved',
         'route'=>'admin.roles.index',
         'active'=>'admin.roles.*',
      ],

      // [
      //       'type' => 'link',
      //    'title'=>'Permisos',
      //    'icon'=>'fa-solid fa-lock',
      //    // 'route'=>'admin.permisos.index',
      //    // 'active'=>'admin.permisos.*',
      // ],

      [
            'type' => 'link',
         'title'=>'Ajustes',
         'icon'=>'fa-solid fa-gear',
         // 'route'=>'admin.ajustes.index',
         // 'active'=>'admin.ajustes.*',
      ],

   ];