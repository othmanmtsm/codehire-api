<?php

namespace App\Http\Controllers;

use App\Freelancer;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = [];
        $projects = Project::orderBy('created_at', 'desc')->get();
        foreach ($projects as $p) {
            $response[] = array(
                'id' => $p->id,
                'titre' => $p->titre,
                'date' => date('d/m/Y H:i',strtotime($p->created_at)) ,
                'category' => $p->category->name,
                'description' => 'In PHP associative array is the type of array where the index need not to be strictly sequential like indexed array.',
                'prix_min' => $p->payment_min,
                'prix_max' => $p->payment_max,
                'payment' => $p->paymentType->label,
                'skills' => $p->skills
            );
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
        $project = new Project;
        $project->category_id = $request->category;
        $project->date_limit = $request->date_lim;
        $desc = serialize($request->description);
        $project->description = $desc;
        $project->payment_max = $request->pay_max;
        $project->payment_min = $request->pay_min;
        $project->payment_type = $request->payment;
        $skills = $request->skills;
        $project->client_id = auth()->user()->id;
        $project->titre = $request->titre;
        $project->save();
        $id = $project->id;
        foreach ($skills as $skill) {
            DB::insert('insert into project_skill values(?,?)',[$skill,$id]);
        }
        return response('created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $freelancers = [];
        foreach ($project->freelancers as $frl) {
            $freelancers[] = array(
                'freelancer' => $frl->username,
                'avatar' => $frl->user->avatar,
                'amount' => $frl->pivot->amount,
                'duration' => $frl->pivot->duration,
                'description' => $frl->pivot->description
            );
        }
        $project = array(
            'titre' => $project->titre,
            'description' => unserialize($project->description),
            'payment_type' =>$project->paymentType->label,
            'category' => $project->category->name,
            'skills' => $project->skills,
            'price_min' => $project->payment_min,
            'price_max' => $project->payment_max,
            'employer' => $project->client->user,
            'date_min' => date_format($project->created_at, 'Y-m-d'),
            'date_max' => $project->date_limit,
            'bidders' => $freelancers
        );
        return response()->json($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->update([
            'titre' => $request->titre,
            'description' => serialize($request->description)
        ]);
        return response('updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response('deleted', 204);
    }

    public function getFilteredProjects(Request $request)
    {
        $response = [];
        $cat = $request->category;
        if ($request->category != '') {
            $projects = Project::orderBy('created_at', 'desc')->where('category_id',$cat)->whereRaw('LOWER(titre) like ?',['%'.strtolower($request->keyword).'%'])->get();
        }else {
            $projects = Project::orderBy('created_at', 'desc')->whereRaw('LOWER(titre) like ?',['%'.strtolower($request->keyword).'%'])->get();
        }
        foreach ($projects as $p) {
            if (count($request->skills) > 0) {
                $skills = [];
                foreach ($p->skills as $s) {
                    $skills[] = $s->pivot->skill_id;
                }
                if (count(array_intersect($request->skills, $skills)) > 0) {
                    $response[] = array(
                        'id' => $p->id,
                        'titre' => $p->titre,
                        'date' => date('d/m/Y H:i',strtotime($p->created_at)) ,
                        'category' => $p->category->name,
                        'description' => 'In PHP associative array is the type of array where the index need not to be strictly sequential like indexed array.',
                        'prix_min' => $p->payment_min,
                        'prix_max' => $p->payment_max,
                        'payment' => $p->paymentType->label,
                        'skills' => $p->skills
                    );
                }
            }else {
                $response[] = array(
                    'id' => $p->id,
                    'titre' => $p->titre,
                    'date' => date('d/m/Y H:i',strtotime($p->created_at)) ,
                    'category' => $p->category->name,
                    'description' => 'In PHP associative array is the type of array where the index need not to be strictly sequential like indexed array.',
                    'prix_min' => $p->payment_min,
                    'prix_max' => $p->payment_max,
                    'payment' => $p->paymentType->label,
                    'skills' => $p->skills
                );
            }
        }

        return response()->json($response);
    }

    public function createBid(Project $project, Request $request)
    {
        DB::insert("insert into project_freelancer(project_id,freelancer_id,amount,duration,description) values(?,?,?,?,?)", [$project->id, auth()->user()->id, $request->amount, $request->delay, $request->description]);
        return $project->id;
    }

    public function hireFreelancer(Project $project, Freelancer $freelancer){
        $project->freelancers->find($freelancer->user_id)->pivot->update([
            'isHired' => true
        ]);

        return response('updated', 200);
    }

    public function denyFreelancer(Project $project, Freelancer $freelancer){
        $project->freelancers->find($freelancer->user_id)->pivot->delete();
        // send a notification
        return response('deleted', 204);
    }

    public function getCategories()
    {
        return DB::select('select * from categories');
    }

    public function getContract(Project $project, Freelancer $freelancer)
    {
        $project = $freelancer->projects->where('id',$project->id)->first();

        return response()->json([
            'project_name' => $project->titre,
            'payment_min' => $project->payment_min,
            'payment_max' => $project->payment_max,
            'created_at' => date_format($project->created_at, 'Y-m-d'),
            'freelancer_id' => $project->freelancers->where('user_id', $freelancer->user_id)->first()->user_id,
            'client_id' => $project->client->user_id,
            'freelancer_name' => $project->freelancers->where('user_id', $freelancer->user_id)->first()->user->nom." ".$project->freelancers->where('user_id', $freelancer->user_id)->first()->user->prenom,
            'client_name' => $project->client->user->nom." ".$project->client->user->prenom,
            'pivot' => $project->pivot,
            'payment_type' => $project->paymentType->label
        ]);
    }

    public function setTimer(Project $project, Request $request)
    {
        $project->freelancers->where('user_id',auth()->user()->id)->first()->pivot->update([
            'hours_worked' => $request->hours
        ]);

        return response('updated', 200);
    }

    public function getTimer(Project $project)
    {
        return $project->freelancers->where('user_id',auth()->user()->id)->first()->pivot->hours_worked;
    }

    public function setTask(Project $project, Request $request)
    {
        $tasks = DB::table('tasks')->where('freelancer_id',auth()->user()->id)->where('project_id',$project->id)->get();
        foreach ($request->todo as $todo) {
            if (count($tasks->where('task',$todo['task'])) == 0) {
                DB::insert('insert into tasks(freelancer_id, project_id, task, stage) values(?,?,?,?)',[auth()->user()->id,$project->id,$todo['task'],'todo']);
            }else{
                DB::update('update tasks set stage=? where freelancer_id=? and project_id=? and task=?', ['todo', auth()->user()->id,$project->id,$todo['task']]);
            }
        }
        foreach ($request->doing as $doing) {
            if (count($tasks->where('task',$doing['task'])) == 0) {
                DB::insert('insert into tasks(freelancer_id, project_id, task, stage) values(?,?,?,?)',[auth()->user()->id,$project->id,$doing['task'],'doing']);
            }else{
                DB::update('update tasks set stage=? where freelancer_id=? and project_id=? and task=?', ['doing', auth()->user()->id,$project->id,$doing['task']]);
            }
        }
        foreach ($request->done as $done) {
            if (count($tasks->where('task',$done['task'])) == 0) {
                DB::insert('insert into tasks(freelancer_id, project_id, task, stage) values(?,?,?,?)',[auth()->user()->id,$project->id,$done['task'],'done']);
            }else{
                DB::update('update tasks set stage=? where freelancer_id=? and project_id=? and task=?', ['done', auth()->user()->id,$project->id,$done['task']]);
            }
        }
        return response('updated', 200);
    }

    public function deleteTask(Request $request)
    {
        DB::delete("delete from tasks where freelancer_id=? and project_id=? and task=?",[$request->freelancer_id,$request->project_id,$request->task]);
        return response('deleted', 204);
    }

    public function getTasks(Project $project)
    {
        $response = [];
        $tasks = $project->tasks->where('user_id',auth()->user()->id);
        foreach ($tasks as $task) {
            $response[] = $task->pivot;
        }
        return response()->json($response);
    }

    public function setCategory(Request $request)
    {
        DB::insert("insert into categories(name,icon) values(?,?)",[$request->name, $request->icon]);
        return response('created', 200);
    }

    public function editCategory($id, Request $request)
    {
        DB::update("update categories set name=?, icon=? where id=?",[$request->name, $request->icon, $id]);
        return response('updated', 201);
    }

    public function deleteCategory($id)
    {
        DB::delete("delete from categories where id=?", [$id]);
    }
}
