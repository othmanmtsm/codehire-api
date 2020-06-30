<?php

namespace App\Http\Controllers;

use App\Client;
use App\Freelancer;
use Illuminate\Http\Request;

class adminDashboardController extends Controller
{
    public function getFreelancers()
    {
        $response = [];
        $freelancers = Freelancer::all();
        foreach ($freelancers as $f) {
            $response[] = [
                'name' => $f->user->prenom.' '.$f->user->nom,
                'username' => $f->username,
                'hourly_rate' => $f->hourly_rate,
                'title' => $f->title,
                'email' => $f->user->email,
                'id' => $f->user_id
            ];
        }
        return response()->json($response);
    }

    public function editFreelancers(Freelancer $freelancer, Request $request)
    {
        $freelancer->update([
            'username' => $request->username,
            'hourly_rate' => $request->hourly_rate,
            'title' => $request->title
        ]);
        $name = explode(" ",$request->name);
        $freelancer->user->update([
            'email' => $request->email,
            'nom' => $name[1],
            'prenom' => $name[0]
        ]);
        return response('updated', 200);
    }

    public function deleteFreelancers(Freelancer $freelancer)
    {
        $freelancer->user->delete();
        $freelancer->delete();
        return response('deleted', 204);
    }

    public function getClients()
    {
        $response = [];
        $clients = Client::all();
        foreach ($clients as $c) {
            $response[] = [
                'name' => $c->user->prenom." ".$c->user->nom,
                'organisation' => $c->organisation,
                'nbemployees' => $c->nb_employees,
                'nbprojects' => count($c->projects),
                'email' => $c->user->email,
                'id' => $c->user_id
            ];
        }
        return response()->json($response);
    }

    public function editClients(Client $client, Request $request)
    {
        $name = explode(" ", $request->name);
        $client->user->update([
            'nom' => $name[1],
            'prenom' => $name[0],
            'email' => $request->email
        ]);
        $client->update([
            'organisation' => $request->organisation,
            'nb_employees' => $request->nbemployees
        ]);
        return response('updated', 201);
    }
}
