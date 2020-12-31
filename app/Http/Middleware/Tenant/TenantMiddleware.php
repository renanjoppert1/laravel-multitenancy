<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
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
        // Pega o domínio que está acessando a aplicação
        $company = $this->getCompany($request->getHost());

        // se não achar um tenant com o domínio que está acessando e o domínio não for o master
        // retornará erro 404
        if (!$company && $request->getHost() != env('MAIN_DOMAIN')) {
            http_response_code(404);
            header('Content-type: application/json');
            echo '{"error": "Não foi possível acessar a aplicação para este domínio"}';
            die();
        }

        // se não for o domínio master, ele trocará a conexão
        if ($request->getHost() != env('MAIN_DOMAIN')) {
            app(ManagerTenant::class)->setConnection($company);
        }

        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }
}
