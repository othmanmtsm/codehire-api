<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $user = $client->user;
        $user->update(['avatar' => $request->avatar->store('images','public')]);
        if ($request->has('organisation')) {
            $client->update(['organisation'=>$request->organisation]);
        }
        if ($request->has('nb_emp')) {
            $client->update(['nb_employees'=>$request->nb_emp]);
        }
        return response('created', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->user->delete();
        $client->delete();
        return response('deleted', 204);
    }

    public function getProjects(){
        $projects = auth()->user()->client->projects;
        $response = [];
        $bids = 0;
        foreach ($projects as $p) {
            foreach ($p->freelancers as $f) {
                $bids++;
            }
            $response[] = array(
                'project_id' => $p->id,
                'project_name' => $p->titre,
                'bidders' => $bids,
                'days_left' => date_diff(date_create(date('Y-m-d')),date_create($p->date_limit))->format('%R%a jours restants'),
                'price_min' => $p->payment_min,
                'price_max' => $p->payment_max,
                'payment_type' => $p->paymentType->label,
                'offres' => DB::select('select a.*,b.username,c.avatar from project_freelancer a join freelancers b on a.freelancer_id=b.user_id join users c on b.user_id=c.id where a.project_id=?',[$p->id])
            );
            $bids = 0;
        }
        return response()->json($response);
    }
}
