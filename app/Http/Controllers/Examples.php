<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Illuminate\View\View;
use Pheature\Community\Laravel\Toggle;
use Pheature\Model\Toggle\Identity;
use Pheature\Sdk\OnDisabledFeature;
use Pheature\Sdk\OnEnabledFeature;

final class Examples extends Controller
{
    public function releaseToggle(Request $request): View
    {
        $result = Toggle::inFeature(
            'release_toggle_example_1',
            null,
            OnEnabledFeature::make(function(Request $request): View {
                // Get data from $request
                return view('already_un_existent_view');
            }, [$request]),
            OnDisabledFeature::make(function(): View {
                return view('welcome');
            }),
        );

        return $result->getData();
    }

    public function opsToggle(Request $request): View
    {
        Toggle::inFeature(
            'ops_toggle_example_1',
            null,
            OnEnabledFeature::make(function (Request $request) {
                Queue::push($request->json());
            }, [$request]),
            OnDisabledFeature::make(function (Request $request) {
                foreach ($request->json() as $productData) {
                    $product = Product::fromArray($productData);
                    $product->save();
                }
            }, [$request])
        );

        return view('welcome');
    }

    public function experimentToggle(): View
    {
        $user = Auth::user();
        $result = Toggle::inFeature(
            'experiment_toggle_example_1',
            new Identity($user ? $user->id : 'anon', [
                'location' => $user ? $user->location : null
            ]),
            OnEnabledFeature::make(function(User $user): View {
                return view('experimental_campaign_view', ['user' => $user]);
            }, [$user]),
            OnDisabledFeature::make(function(): View {
                return view('welcome');
            }),
        );

        return $result->getData();
    }

    public function permissionToggle(): View
    {
        $user = Auth::user();
        $result = Toggle::inFeature(
            'permission_toggle_example_1',
            new Identity($user ? $user->id : 'anon', [
                'location' => $user ? $user->accountType : null
            ]),
            OnEnabledFeature::make(function(User $user): View {
                // Get user customizations.
                return view('premium_view', ['user' => $user]);
            }, [$user]),
            OnDisabledFeature::make(function(): View {
                return view('welcome');
            }),
        );

        return $result->getData();
    }
}
