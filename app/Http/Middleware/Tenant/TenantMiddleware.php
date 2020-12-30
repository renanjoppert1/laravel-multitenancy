<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use Closure;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if( !$company = $this->getCompany($request->getHost()) ){
            echo 'Não foi possível acessar a aplicação para este domínio';
            http_response_code(404);
            die();
        }



        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }
}
