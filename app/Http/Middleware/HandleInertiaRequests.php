<?php

namespace App\Http\Middleware;

use App\Models\Headline;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Menu;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'mainmenu' => Menu::where('aktif', 'Y')
                ->orderBy('urutan')
                ->with([
                    'submenu' => function ($query) {
                        $query->where('aktif', 'Y')->orderBy('urutan');
                    },
                ])
                ->get(),
            'headline' => Headline::first(),
        ]);
    }
}
