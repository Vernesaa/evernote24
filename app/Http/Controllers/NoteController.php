<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Lists;
use App\Models\Note;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {

        // Laden aller Listen mit den zugehörigen Notizen
        $notes = Note::with(['list','tags', 'user', 'images', 'todos'])->get();
        // Gibt die Listen als JSON-Antwort zurück
        return response()->json($notes, 200);
    }

    public function findbyId($noteid): JsonResponse
    {
        $notes = Note::where('id', $noteid)->with(['list','tags', 'user', 'images', 'todos'])->first();
        return $notes != null ? response()->json($notes, 200) : response()->json(null, 200);
    }

    public function checkid($noteid): JsonResponse
    {
        $notes = Note::where('id', $noteid)->first();
        return $notes != null ? response()->json(true, 200) : response()->json(false, 200);

    }

    public function findbySearchTerm($searchTerm): JsonResponse
    {
        $notes = Note::with(['list','tags', 'user', 'images', 'todos'])->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('description' , 'LIKE', '%' . $searchTerm. '%')
            ->get();
        return response()->json($notes, 200);
    }

    public function save(Request $request): JsonResponse
    {

        DB::beginTransaction();
        try {
            // Erstellt eine neue Notiz mit den validierten Daten
            $notes = Note::create($request->all());

            // Bilder hinzufügen zur Notiz
            if (isset($request['images']) && is_array($request['images'])) {
                foreach ($request['images'] as $img) {
                    $image =
                        Image::firstOrNew(['url' => $img['url'], 'title' => $img['title']]);
                    $notes->images()->save($image);
                }
            }
            DB::commit();
            // Valide Rückgabe von http
            return response()->json($notes, 201);
        } catch (\Exception $e) {
            // Rollback aller Queries
            DB::rollBack();
            return response()->json("Das Speichern von Notizen ist fehlgeschlagen: " . $e->getMessage(), 420);
        }
    }


    public function update(Request $request, string $noteid): JsonResponse
    {
        DB::beginTransaction();

        try {
            //id suchen von Lists
            $notes = Note::with('list','tags', 'user', 'images', 'todos')->find($noteid);
            if ($notes) {
                //Liste upadten
                $notes->update($request->all());

                //alte Bilder löschen
                $notes->images()->delete();
                // save images
                if (isset($request['images']) && is_array($request['images'])) {
                    foreach ($request['images'] as $img) {
                        $image =
                            Image::firstOrNew(['url'=>$img['url'],'title'=>$img['title']]);
                        $notes->images()->save($image);
                    }
                }

                //Notizen in die Datenbank laden
                DB::commit();
                return response()->json($notes, 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Noitzen nicht gefunden.'], 404); // Liste nicht gefunden
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Das Updaten von Notizen ist fehlgeschlagen: " . $e->getMessage()], 420);
        }
    }

    public function delete(string $noteid) : JsonResponse {
        $notes = Note::where('id', $noteid)->first();
        if ($notes!= null) {
            $notes->delete();
            return response()->json('Liste (' . $noteid . ') erfolgreich gelöscht', 200);
        }
        else
            return response()->json('Liste konnte nicht gelöscht werden', 422);
    }

}
