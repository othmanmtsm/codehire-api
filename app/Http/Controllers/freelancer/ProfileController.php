<?php

namespace App\Http\Controllers\freelancer;

use App\Freelancer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Freelancer $freelancer)
    {
        $reviews = [];
        $pecours = 0;
        $nprev = 0;
        foreach ($freelancer->reviews as $rev) {
            $reviews[] = [
                'id' => $rev->pivot->id,
                'client_nom' => User::find($rev->user_id)->nom,
                'client_prenom' => User::find($rev->user_id)->prenom,
                'avatar' => User::find($rev->user_id)->avatar,
                'review' => $rev->pivot->review
            ];
            $nprev++;
        }
        foreach ($freelancer->projects as $p) {
            if ($p->pivot->isHired == true) {
                $pecours++;
            }
        }
        return response()->json([
            'nom' => $freelancer->user->nom,
            'prenom' => $freelancer->user->prenom,
            'mail' => $freelancer->user->email,
            'username' => $freelancer->username,
            'title' => $freelancer->title,
            'bio' => $freelancer->bio,
            'hourlyrate' => $freelancer->hourly_rate,
            'avatar' => $freelancer->user->avatar,
            'member_since' => $freelancer->user->created_at->format('M d Y'),
            'skills' => $freelancer->skills,
            'categories' => $freelancer->categories,
            'experience' => $freelancer->experience,
            'certifications' => $freelancer->certifications,
            'projets_en_cours' => $pecours,
            'nb_reviews' => $nprev,
            'reviews' => $reviews
        ]);
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
    public function store(Freelancer $freelancer,Request $request)
    {
        $user = $freelancer->user;
        $freelancer->update(['hourly_rate'=>$request->hourlyrate]);
        $freelancer->update(['username'=>$request->username]);
        $freelancer->update(['title'=>$request->title]);
        if ($request->has('avatar')) {
            $user->update(['avatar' => $request->avatar->store('images','public')]);
        }
        if ($request->has('skills')) {
            $skills = explode(',',$request->skills);
            foreach ($skills as $skill) {
                DB::insert('insert into skill_user values(?,?)',[$skill,$freelancer->user_id]);
            }
        }
        if ($request->has('categories')) {
            $categories = explode(',',$request->categories);
            foreach ($categories as $category) {
                DB::insert("insert into category_freelancer(category_id,freelancer_id) values(?,?)",[$category,$freelancer->user_id]);
            }
        }
        return $request;
    }

    public function addReview(Freelancer $freelancer,Request $request)
    {
        return DB::insert('insert into freelancer_reviews(freelancer_id, client_id, review) values(?,?,?)', [$freelancer->user_id,auth()->user()->id,$request->text]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Freelancer $freelancer)
    {
        $this->validate($request,[
            'title' => 'required',
            'bio' => 'required',
        ]);

        foreach ($freelancer->skills as $skill) {
            $skill->pivot->delete();
        }

        foreach ($request->skills as $skill) {
            DB::insert('insert into skill_user values(?,?)',[$skill,$freelancer->user_id]);
        }

        $freelancer->update([
            'title' => $request->title,
            'bio' => $request->bio
        ]);

        return response('updated',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addExp(Request $request)
    {
        DB::insert("insert into experiences(titre,date_from,date_to,description,freelancer_id) values(?,?,?,?,?)",[$request->titre, $request->date_from, $request->date_to, $request->description,auth()->user()->id]);
        return response('created', 200);
    }

    public function delExp(Request $request)
    {
        DB::delete("delete from experiences where id=?",[$request->id]);
        return response('deleted', 204);
    }

    public function editExp(Request $request)
    {
        DB::update("update experiences set titre=?, date_from=?, date_to=?, description=? where id=?",[$request->titre,$request->date_from,$request->date_to,$request->description,$request->id]);
        return response('updated', 200);
    }

    public function addCert(Request $request)
    {
        DB::insert("insert into certifications(nom,provider,description,date,freelancer_id) values(?,?,?,?,?)",[$request->title, $request->provider ,$request->description ,$request->date ,auth()->user()->id]);
        return DB::select("select * from certifications where freelancer_id=? order by id DESC LIMIT 1",[auth()->user()->id]);
    }

    public function delCert(Request $request)
    {
        DB::delete("delete from certifications where id=?",[$request->id]);
        return response('deleted', 204);
    }

    public function editCert(Request $request)
    {
        DB::update("update certifications set nom=?, provider=?, description=?, date=? where id=?",[$request->title, $request->provider, $request->description, $request->date, $request->id]);
        return response('updated', 200);
    }
}
