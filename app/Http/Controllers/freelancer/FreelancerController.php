<?php

namespace App\Http\Controllers;

use App\Freelancer;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [];
        $freelancers = Freelancer::all();
        foreach ($freelancers as $freelancer) {
            $response[] = [
                'id' => $freelancer->user_id,
                'username' => $freelancer->username,
                'title' => $freelancer->title,
                'avatar' => $freelancer->user->avatar,
                'skills' => $freelancer->skills
            ];
        }
        return response()->json($response);
    }

    public function filter(Request $request)
    {
        $response = [];
        $freelancers = Freelancer::whereRaw('LOWER(username) like ?',['%'.strtolower($request->search).'%'])->get();
        foreach ($freelancers as $freelancer) {
            $response[] = [
                'id' => $freelancer->user_id,
                'username' => $freelancer->username,
                'title' => $freelancer->title,
                'avatar' => $freelancer->user->avatar,
                'skills' => $freelancer->skills
            ];
        }
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Freelancer  $freelancer
     * @return \Illuminate\Http\Response
     */
    public function show(Freelancer $freelancer)
    {
        return $freelancer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Freelancer  $freelancer
     * @return \Illuminate\Http\Response
     */
    public function edit(Freelancer $freelancer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Freelancer  $freelancer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Freelancer $freelancer)
    {
        $this->validate($request,[
            'nom' => 'required',
            'prenom' => 'required',
            'username' => 'required',
            'hourlyrate' => 'required',
            'email' => 'email'
        ]);

        $freelancer->update([
            'username' => $request->username,
            'hourly_rate' => $request->hourlyrate
        ]);
        $freelancer->user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email
        ]);
        return response('updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Freelancer  $freelancer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Freelancer $freelancer)
    {
        //
    }

    public function getProjects()
    {
        $response = [];
        $freelancer = auth()->user()->freelancer;
        foreach ($freelancer->projects as $p) {
            $response[] = [
                'name' => $p->titre,
                'date' => $p->date_limit,
                'paymin' => $p->payment_min,
                'paymax' => $p->payment_max,
                'amount' => $p->pivot->amount,
                'duration' => $p->pivot->duration." Days",
                'status' => ($p->pivot->isHired)?'Hired':'Waiting',
                'id' => $p->id
            ];
        }
        return response()->json($response);
    }
}
