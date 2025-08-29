<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $menuItems = [
                [
                    'label' => 'Dashboard',
                    'icon' => 'bi bi-house',
                    'route' => 'dashboard',
                ],
                [
                    'label' => 'Books',
                    'icon' => 'bi bi-book-half',
                    'route' => 'books.index',
                ],
                [
                    'label' => 'Patrons',
                    'icon' => 'bi bi-people-fill',
                    'route' => 'patrons.index',
                ],
                [
                    'label' => 'Librarians',
                    'icon' => 'bi bi-person-lines-fill',
                    'route' => 'librarians.index',
                ],
                [
                    'label' => 'Borrowings',
                    'icon' => 'bi bi-bag-plus-fill',
                    'route' => 'borrowings.index',
                ],
            ];

            $view->with('menuItems', $menuItems);
        });
    }
}