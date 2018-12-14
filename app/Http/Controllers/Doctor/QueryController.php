<?php

namespace App\Http\Controllers\Doctor;

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
        if (auth()->user()->doctor) {
            $title = 'Listado de consultas';

            $queries = Query::where('resolved', 0)->paginate(15);

            return view('/doctor/queries/index')
                ->with('queries', $queries)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function showDetail(Query $query)
    {
        if (auth()->user()->doctor) {
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


            return view('/doctor/queries/detail')
                ->with('query', $query)
                ->with('back_id', $back_id)
                ->with('result', $result)
                ->with('resolved', $resolved)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function update(Query $query)
    {
        if (auth()->user()->doctor) {
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

            return view('/doctor/queries/update')
                ->with('back_id', $back_id)
                ->with('result', $result)
                ->with('resolved', $resolved)
                ->with('query', $query);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function resolve(Query $query)
    {
        if (auth()->user()->doctor) {

            $data['comment'] = request()->comment;
            $data['resolved'] = true;

            $query->update($data);

            return redirect()->route('doctor_queries');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }
}
