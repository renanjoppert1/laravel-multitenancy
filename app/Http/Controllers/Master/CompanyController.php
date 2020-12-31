<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $domain = md5(date('Y-m-d H:i:s')) . '.' . env('APP_URL_BASE');
        $database_name = env('DB_TENANT_PREFIX') . md5(date('Y-m-d H:i:s'));

        $company = $this->company->create([
            "name" => 'Empresa X',
            "domain" => $domain,
            "db_database" => $database_name,
            "db_username" => 'root',
            "db_password" => '',
            "db_hostname" => 'localhost'

        ]);

        DB::statement("
            CREATE DATABASE {$database_name} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");

        Artisan::call('tenants:migration', [
            'id' => $company->id
        ]);

        return response()->json([
            'data' => $company
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
