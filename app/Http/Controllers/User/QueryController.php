<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Query;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use App\Area;

class QueryController extends Controller
{
    public function index()
    {
        if (! auth()->user()->doctor) {
            $title = 'Listado de consultas';

            $queries = Query::whereRaw('queries.relatedQuery_id = queries.id')->paginate(15);

            return view('/user/queries/index')
                ->with('queries', $queries)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function show(Query $query)
    {
        if (! auth()->user()->doctor) {
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
        if (! auth()->user()->doctor) {
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

            $area_id = request()->area;

            $process = new Process("C:\Users\Victor\Anaconda2\pkgs\python-2.7.15-he216670_0\python V:\Documents\prueba.py argumento1");
            $process->run();
            $result = $process->getOutput();

            $queries_count = Query::count()+1;

            Query::create([
                'relatedQuery_id' => $queries_count,
                'area_id' => $area_id,
                'result' => $result,
                'comment' => 'Comentario de prueba',
            ]);

            return redirect()->route('user_queries');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function add()
    {
        if (! auth()->user()->doctor) {
            $area_id = request()->area;
            $relatedQuery_id = request()->relatedQuery_id;

            $process = new Process("C:\Users\Victor\Anaconda2\pkgs\python-2.7.15-he216670_0\python V:\Documents\prueba.py argumento1");
            $process->run();
            $result = $process->getOutput();

            Query::create([
                'relatedQuery_id' => $relatedQuery_id,
                'area_id' => $area_id,
                'result' => $result,
                'comment' => 'Comentario de prueba',
            ]);

            return redirect()->route('user_queries');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }
}