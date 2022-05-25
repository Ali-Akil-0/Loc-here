<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaints;

class AdminController extends Controller
{
    public function Complaints(Request $request)
    {
        $request->validate([
            "email" => 'nullable',
        ]);
        // echo "testihg";
        $reclamations = Complaints::where('ReponseReclam', NULL)
            ->Where('VueReclamationAdmin', 'non')
            ->get()->all();
        return view('admin.complaints', ['reclamations' => $reclamations, 'email' => $request->email]);
    }

    public function ComplaintsVu(Request $req)
    {
        $req->validate([
            "email" => 'nullable',
            'reclamation' => 'nullable',

        ]);
        $reclamation = Complaints::findorfail($req->reclamation);
        return view('admin.complaints_vu', ["email" => $req->email, 'reclamations' => $req->reclamation])->with('reclamation', $reclamation, 'email', $req->email);
    }

    public function ComplaintsRepondre(Request $req)
    {
        $req->validate([
            "email" => 'nullable',
            'reclamation' => 'nullable',
        ]);
        $reclamation = Complaints::findorfail($req->reclamation);
        return view('admin.complaints_repondre', ['reclamations' => $reclamation, "email" => $req->email]);
    }

    public function storeReponse(Request $req)
    {
        $req->validate([
            "email" => 'nullable',
            'idReclam' => 'nullable',
            'reponseReclam' => 'nullable',
        ]);
        $repReclamation = \App\Models\Complaints::find($req->idReclam);
        $repReclamation->ReponseReclam = $req->reponseReclam;
        $repReclamation->save();
        $reclamations = Complaints::where('ReponseReclam', NULL)
            ->Where('VueReclamationAdmin', 'non')
            ->get()->all();
        return view('admin.complaints', ['reclamations' => $reclamations, 'email' => $req->email]);
    }
    public function storeVu(Request $req)
    {
        $req->validate([
            "email" => 'nullable',
            'idReclam' => 'nullable',
            'reclamation' => 'nullable',
        ]);
        $repReclamation = \App\Models\Complaints::find($req->idReclam);
        $repReclamation->VueReclamationAdmin = 'oui';
        $repReclamation->save();
        $reclamations = Complaints::where('ReponseReclam', NULL)
            ->Where('VueReclamationAdmin', 'non')
            ->get()->all();
        return view('admin.complaints', ['reclamations' => $reclamations, 'email' => $req->email]);
    }
}