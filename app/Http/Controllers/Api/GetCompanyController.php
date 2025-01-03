<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetCompanyController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['index', 'getCompanyTaxCode', 'show']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function getCompanyTaxCode(Request $request)
    {
        $taxCode = $request->query('taxCode');

        if (!$taxCode) {
            return response()->json(['error' => 'The taxCode query parameter is required'], 400);
        }

        $url = 'https://actapp.misa.vn/g1/api/graph/v1/company/get_company_tax_code';
        $response = Http::get($url, [
            'taxCode' => $taxCode,
            'isLatests' => 'false'
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'API request failed'], 500);
        }
    }
}
