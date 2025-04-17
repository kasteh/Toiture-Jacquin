<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitor;

class VisitorController extends Controller
{
    public function store(Request $request)
    {
        $visitor = Visitor::create([
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
            'os' => $this->getOS($request->header('User-Agent')),
            'device' => $this->getDevice($request->header('User-Agent')),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Données enregistrées avec succès', 'visitor' => $visitor]);
    }

    private function getOS($userAgent)
    {
        if (preg_match('/Windows/i', $userAgent)) return 'Windows';
        if (preg_match('/Mac/i', $userAgent)) return 'MacOS';
        if (preg_match('/Linux/i', $userAgent)) return 'Linux';
        if (preg_match('/Android/i', $userAgent)) return 'Android';
        if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) return 'iOS';
        return 'Inconnu';
    }

    private function getDevice($userAgent)
    {
        if (preg_match('/Mobile/i', $userAgent)) return 'Mobile';
        if (preg_match('/Tablet/i', $userAgent)) return 'Tablette';
        return 'Ordinateur';
    }
}

