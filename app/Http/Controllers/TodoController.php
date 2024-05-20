<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Lists;
use App\Models\Note;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {

        // Laden aller Listen mit den zugehörigen Notizen
        $todos = Todo::with(['tags', 'user', 'images', 'note'])->get();
        // Gibt die Listen als JSON-Antwort zurück
        return response()->json($todos, 200);
    }

    public function findbyId($todoid): JsonResponse
    {
        $todos = Todo::where('id', $todoid)->with(['tags', 'user', 'images', 'note'])->first();
        return $todos != null ? response()->json($todos, 200) : response()->json(null, 200);
    }

    public function checkid($todoid): JsonResponse
    {
        $todos = Todo::where('id', $todoid)->first();
        return $todos != null ? response()->json(true, 200) : response()->json(false, 200);
    }

    public function findbySearchTerm($searchTerm): JsonResponse
    {
        $todos = Todo::with(['tags', 'user', 'images', 'note'])->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('description' , 'LIKE', '%' . $searchTerm. '%')
            ->get();
        return response()->json($todos, 200);

    }

    public function save(Request $request): JsonResponse
    {
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            // Erstellt eine neue Notiz mit den validierten Daten
            $todos = Todo::create($request->all());

            // Bilder hinzufügen zur Notiz
            if (isset($request['images']) && is_array($request['images'])) {
                foreach ($request['images'] as $img) {
                    $image =
                        Image::firstOrNew(['url' => $img['url'], 'title' => $img['title']]);
                    $todos->images()->save($image);
                }
            }
            DB::commit();
            // Valide Rückgabe von http
            return response()->json($todos, 201);
        } catch (\Exception $e) {
            // Rollback aller Queries
            DB::rollBack();
            return response()->json("Das Speichern von Notizen ist fehlgeschlagen: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request) : Request {
        // get date and convert it- its in ISO 8601, e.g. "2018-01-01T23:00:00.000Z"
        $date = new \DateTime($request->duedate);
        $request['due_date'] = $date->format('Y-m-d H:i:s');
        return $request;
    }

    public function update(Request $request, string $todoid): JsonResponse
    {
        DB::beginTransaction();

        try {
            //id suchen von Lists
            $todos = Todo::with('tags', 'user', 'images', 'note')->find($todoid);
            if ($todos != null) {
                $request = $this->parseRequest($request);
                //Liste upadten
                $todos->update($request->all());

                //alte Bilder löschen
                $todos->images()->delete();
                // save images
                if (isset($request['images']) && is_array($request['images'])) {
                    foreach ($request['images'] as $img) {
                        $image =
                            Image::firstOrNew(['url'=>$img['url'],'title'=>$img['title']]);
                        $todos->images()->save($image);
                    }
                }

                //Notizen in die Datenbank laden
                DB::commit();
                return response()->json($todos, 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Todos nicht gefunden.'], 404); // Liste nicht gefunden
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Das Updaten von Todos ist fehlgeschlagen: " . $e->getMessage()], 420);
        }
    }

    public function delete(string $todoid) : JsonResponse {
        $todos = Todo::where('id', $todoid)->first();
        if ($todos!= null) {
            $todos->delete();
            return response()->json('Liste (' . $todoid . ') erfolgreich gelöscht', 200);
        }
        else
            return response()->json('Liste konnte nicht gelöscht werden', 422);
    }




}
