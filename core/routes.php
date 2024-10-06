<?php
$adminRoute = [
    'dashboard'             => 'admin/dashboard/index',

    'country-list'          => 'admin/country/index',
    'country-add'           => 'admin/country/add',
    'country-create'        => 'admin/country/create',
    'country/delete/(\d+)'  =>  'admin/country/delete/$1',

    'gender-list'           => 'admin/gender/index',
    'gender-add'            => 'admin/gender/add',
    'gender-create'         => 'admin/gender/create',

    'admin-add'             => 'admin/admin/add',
    'admin-create'          => 'admin/admin/create',
    'admin/showLogin'       => 'admin/admin/show',
    'admin-login'           => 'admin/admin/login',
    'admin-profile'         => 'admin/admin/profile',
    'admin-update'          => 'admin/admin/update',
    'admin/logout'          => 'admin/admin/logout',

    'cinema/add'            => 'admin/cinema/add',
    'cinema/create'         => 'admin/cinema/create',
    'cinema/delete/(\d+)'   => 'admin/cinema/delete/$1',
    'cinema/update/(\d+)'   => 'admin/cinema/update/$1',
    'cinema/list'           => 'admin/cinema/index',

    
    'room/add'              => 'admin/room/add',
    'room/create'           => 'admin/room/create',
    'room/list'             => 'admin/room/index',
    'room/delete/(\d+)'     => 'admin/room/delete/$1',
    'room/update/(\d+)'     => 'admin/room/update/$1',

    'movie/add'             => 'admin/movie/add',
    'movie/create'          => 'admin/movie/create',
    'movie/list'            => 'admin/movie/index',
    'movie/delete/(\d+)'    => 'admin/movie/delete/$1',
    'movie/update/(\d+)'    => 'admin/movie/update/$1',

    'schedule/add'          => 'admin/schedule/add',
    'schedule/create'       => 'admin/schedule/create',
    'schedule/list'         => 'admin/schedule/index',
    'schedule/update/(\d+)' => 'admin/schedule/update/$1',
    'schedule/delete/(\d+)' => 'admin/schedule/delete/$1',

    'seatType/add'          => 'admin/seat/seatTypeAdd',
    'seatType/create'       => 'admin/seat/seatTypeCreate',
    'seatType/list'         => 'admin/seat/seatTypeList',
    'seatType/delete/(\d+)' => 'admin/seat/seatTypeDelete/$1',

    'seat/add'              => 'admin/seat/add',
    'seat/create'           => 'admin/seat/create',
    'seat/list'             => 'admin/seat/index',
    'seat/update/(\d+)'     => 'admin/seat/update/$1',
    'seat/delete/(\d+)'     => 'admin/seat/delete/$1',

    'price/add'             => 'admin/price/add',
    'price/create'          => 'admin/price/create',
    'price/list'            => 'admin/price/index',
    'price/update/(\d+)'    => 'admin/price/update/$1',
    'price/delete/(\d+)'    => 'admin/price/delete/$1',

    'blog/add'              => 'admin/blog/add',
    'blog/create'           => 'admin/blog/create',
    'blog/list'             => 'admin/blog/index',
    'blog/update/(\d+)'     => 'admin/blog/update/$1',
    'blog/delete/(\d+)'     => 'admin/blog/delete/$1',

    'member/list'           => 'admin/member/index',
    'member/delete/(\d+)'   => 'admin/member/delete/$1'

];

$apiRoute = [
    'api/register'                     => 'api/member/register',
    'api/login'                        => 'api/member/login',
    'api/logout'                       => 'api/member/logout',
    'api/profile/(\d+)'                => 'api/member/update/$1',

    'api/country/list'                 => 'api/member/getcountry',

    'api/blog/list'                    => 'api/blog/index',
    'api/blog/new'                     => 'api/blog/newBlog',
    'api/blog/detail/(\d+)'            => 'api/blog/detail/$1',
    'api/blog/detail-pagination/(\d+)' => 'api/blog/pagination/$1',
    'api/blog/comment/(\d+)'           => 'api/blog/comment/$1',

    'api/movie/list'                   => 'api/movie/index',
    'api/movie/now-playing'            => 'api/movie/playing',
    'api/movie/upcoming'               => 'api/movie/upcoming',
    'api/movie/detail/(\d+)'           => 'api/movie/detail/$1',
    'api/movie/comment/(\d+)'          => 'api/movie/comment/$1',
    'api/movie/rate/(\d+)'             => 'api/movie/rate/$1',
    'api/get/rate-movie/(\d+)'         => 'api/movie/getRate/$1',
    'api/movie/search'                 => 'api/movie/search',
    'api/movie/showtime'               => 'api/movie/showtime',
    'api/movie/showdate'               => 'api/movie/showdate',

    'api/seat/list'                    => 'api/seat/index',
    'api/seat-type'                    => 'api/seat/seatType',
 
    'api/price/list'                   => 'api/seat/pricelist',
    'api/setBookSeat'                  => 'api/seat/setBookSeat',

    'api/pay/create'                   => 'api/pay/createPay',
    'api/pay/vnpayqr'                  => 'api/pay/vnpayqr',
];

$routes = array_merge($adminRoute, $apiRoute);
?>