<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(): JsonResponse
    {

        // Laden aller Listen mit den zugehörigen Notizen
        $tags = Tag::with(['notes', 'todos'])->get();
        // Gibt die Listen als JSON-Antwort zurück
        return response()->json($tags, 200);
    }

    public function save(Request $request): JsonResponse
    {
        // Validierung der Eingabe
        $validated = $request->validate([
            'name' => 'required|string',  // 'name' ist erforderlich und muss ein String sein
        ]);

        DB::beginTransaction();
        try {
            // Erstellt eine neue Tags mit den validierten Daten
            $tags = Tag::create($validated);
            DB::commit();
            // Valide Rückgabe von http
            return response()->json($tags, 201);
        } catch (\Exception $e) {
            // Rollback aller Queries
            DB::rollBack();
            return response()->json("Das Speichern von Listen ist fehlgeschlagen: " . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $tagsid): JsonResponse
    {
        // Validierung der Eingabedaten
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            //id suchen von Tags
            $tags = Tag::with('notes', 'todos')->find($tagsid);
            if ($tags) {
                //Liste upadten
                $tags->update($validated);
                //Liste in die Datenbank laden
                DB::commit();
                return response()->json($tags, 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Tag nicht gefunden.'], 404); // Liste nicht gefunden
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Das Updaten von Tags ist fehlgeschlagen: " . $e->getMessage()], 420);
        }
    }

    public function delete(string $tagsid) : JsonResponse {
        $tags = Tag::where('id', $tagsid)->first();
        if ($tags != null) {
            $tags->delete();
            return response()->json('Liste (' . $tagsid . ') erfolgreich gelöscht', 200);
        }
        else
            return response()->json('Liste konnte nicht gelöscht werden', 422);
    }

}
