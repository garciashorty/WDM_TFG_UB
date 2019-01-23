<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Query;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use App\Area;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class QueryController extends Controller
{
    public function index()
    {
        if (! auth()->user()->doctor) {
            $title = 'Listado de consultas';

            // $process = new Process("C:\Users\Victor\Anaconda2\python V:\Documents\python\image.py");
            // $process->run();
            // $result = $process->getOutput();
            // dd($result);

            $queries = Query::where('user_id', auth()->user()->id)->whereRaw('queries.relatedQuery_id = queries.id')->paginate(15);

            return view('/user/queries/index')
                ->with('queries', $queries)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function show(Query $query)
    {
        if (! auth()->user()->doctor && auth()->user()->id == $query->user_id) {
            $title = 'Consultas relacionadas';

            $queries = Query::where('relatedQuery_id', $query->id)->paginate(15);

            return view('/user/queries/show')
                ->with('queries', $queries)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function showDetail(Query $query)
    {
        if (! auth()->user()->doctor && auth()->user()->id == $query->user_id) {
            $title = 'Viendo detalle de la consulta';

            $back_id = $query->relatedQuery_id;

            switch ($query->result) {
                case 1:
                    $result = 'Sin problemas';
                    break;
                case 2:
                    $result = 'Podrían haber problemas';
                    break;
                case 3:
                    $result = 'Se han detectado problemas';
                    break;
                default:
                    # code...
                    break;
            }

            if ($query->resolved == 0) {
                $resolved = 'Pendiente';
            } else {
                $resolved = 'Resuelto';
            }


            return view('/user/queries/detail')
                ->with('query', $query)
                ->with('back_id', $back_id)
                ->with('result', $result)
                ->with('resolved', $resolved)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function create()
    {
        if (! auth()->user()->doctor) {
            $areas = Area::all();

            return view('/user/queries/create')
                ->with('areas', $areas);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function update(Query $query)
    {
        if (! auth()->user()->doctor) {
            $areas = Area::all();

            return view('/user/queries/update')
                ->with('areas', $areas)
                ->with('query', $query);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function store()
    {
        if (! auth()->user()->doctor) {

            $data = request()->validate([
                'imagen' => 'required|mimes:jpg,jpeg,png',
            ], [
                'imagen.required' => 'Debe introducir una imagen',
            ]);

            $area_id = request()->area;

            $idCount = Query::first()->value('idCount')+1;

            //$queries_count = Query::count()+1;

            $image = request()->imagen->store('queries/images');

            $filename = explode("/", $image);
            $filename = $filename[2];

            $inverse_image = request()->imagen->move(public_path('images/queries'), $filename);

            $process = new Process("python scripts\image.py ".$filename);
            //$process = new Process("C:\Users\Victor\Anaconda2\python scripts\image.py ".$filename);
            $process->run();
            $result = $process->getOutput();

            Query::create([
                'user_id' => auth()->user()->id,
                'relatedQuery_id' => $idCount,
                'area_id' => $area_id,
                'result' => $result,
                'image' => $image,
                'idCount' => 16,
            ]);

            Query::where('idCount', $idCount-1)->orWhere('idCount', null)->update(['idCount' => $idCount]);

            return redirect()->route('user_queries');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function add()
    {
        if (! auth()->user()->doctor) {

            $data = request()->validate([
                'imagen' => 'required|mimes:jpg,jpeg,png',
            ], [
                'imagen.required' => 'Debe introducir una imagen',
            ]);

            $area_id = request()->area_id;
            $relatedQuery_id = request()->relatedQuery_id;

            $idCount = Query::first()->value('idCount')+1;

            $image = request()->imagen->store('queries/images');

            $filename = explode("/", $image);
            $filename = $filename[2];

            $inverse_image = request()->imagen->move(public_path('images/queries'), $filename);

            $process = new Process("python scripts\image.py ".$filename);
            //$process = new Process("C:\Users\Victor\Anaconda2\python scripts\image.py ".$filename);
            $process->run();
            $result = $process->getOutput();

            Query::create([
                'user_id' => auth()->user()->id,
                'relatedQuery_id' => $relatedQuery_id,
                'area_id' => $area_id,
                'result' => $result,
                'image' => $image,
                'idCount' => 16,
            ]);

            Query::where('idCount', $idCount-1)->orWhere('idCount', null)->update(['idCount' => $idCount]);

            return redirect()->route('user_queries');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function image(Query $query)
    {
        if (! auth()->user()->doctor && auth()->user()->id == $query->user_id) {
            $headers = [];

            return response()->download(
                storage_path("app/{$query->image}"),
                null,
                $headers,
                ResponseHeaderBag::DISPOSITION_INLINE
            );
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }
}
