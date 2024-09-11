<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureBranding
{

    public function handle(Request $request, Closure $next)
    {
        // Extract the domain
        $host = $request->getHost(); // Gets the full host including subdomains and domain
        $subdomain = $this->getSubdomain($host); // Extracts the subdomain

        // Set the brand based on the subdomain
        $branding = $this->getBranding($subdomain);
        session(['brand' => $subdomain]);
        return $next($request);
    }

    protected function getSubdomain($host)
    {
        // Split the host by dot
        $parts = explode('.', $host);

        // If the host has at least 3 parts, the subdomain is the second part
        // (assuming the format subdomain.domain.tld)
        if (count($parts) >= 3) {
            return $parts[1];
        }

        // Default to null if not enough parts
        return null;
    }

    protected function getBranding($brand)
    {
        if($brand === 'monyfi'){

        }else if($brand === 'wibip'){

        }else{
            abort(503);
        }
    }
}
