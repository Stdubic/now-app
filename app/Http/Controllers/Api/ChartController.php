<?php

namespace App\Http\Controllers\Api;

use App\AppClient;
use App\AppUser;
use App\Claim;
use App\Instance;
use App\Http\Requests\ChartData;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

/**
 * Class ChartController
 * @package App\Http\Controllers\Api
 */
class ChartController extends Controller
{
    /**
     * @param ChartData $request
     * @return array
     */
    public function customers(ChartData $request)
    {
        $records = AppUser::whereBetween('created_at', [$request->min_date, $request->max_date])
                           ->orderBy('created_at')
                           ->get()
                           ->groupBy(function($date) use ($request) {
                               return Carbon::parse($date->created_at)->format($request->date_format);
                           });

        $customers = [];
        foreach($records as $key => $value) $customers[] = ['date' => $key, 'value' => count($value)];

        return $customers;
    }

    /**
     * @param ChartData $request
     * @return array
     */
    public function clients(ChartData $request)
    {
        $records = AppClient::whereBetween('created_at', [$request->min_date, $request->max_date])
                          ->orderBy('created_at')
                          ->get()
                          ->groupBy(function($date) use ($request) {
                              return Carbon::parse($date->created_at)->format($request->date_format);
                          });

        $customers = [];
        foreach($records as $key => $value) $customers[] = ['date' => $key, 'value' => count($value)];

        return $customers;
    }

    /**
     * @param ChartData $request
     * @return array
     */
    public function instances(ChartData $request)
    {
        $records = Instance::whereBetween('created_at', [$request->min_date, $request->max_date])
                            ->orderBy('created_at')
                            ->get()
                            ->groupBy(function($date) use ($request) {
                                return Carbon::parse($date->created_at)->format($request->date_format);
                            });

        $customers = [];
        foreach($records as $key => $value) $customers[] = ['date' => $key, 'value' => count($value)];

        return $customers;
    }

    /**
     * @param ChartData $request
     * @return array
     */
    public function claims(ChartData $request)
    {
        $records = Claim::whereBetween('created_at', [$request->min_date, $request->max_date])
                           ->orderBy('created_at')
                           ->get()
                           ->groupBy(function($date) use ($request) {
                               return Carbon::parse($date->created_at)->format($request->date_format);
                           });

        $customers = [];
        foreach($records as $key => $value) $customers[] = ['date' => $key, 'value' => count($value)];

        return $customers;
    }


}
