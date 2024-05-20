<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Lists;
use App\Models\User;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class ListsController extends Controller
{
    public function index(): JsonResponse
    {

        // Laden aller Listen mit den zugehörigen Notizen
        $lists = Lists::with(['notes'])->get();
        // Gibt die Listen als JSON-Antwort zurück
        return response()->json($lists, 200);
    }

    public function findbyId($listsid): JsonResponse
    {
        $lists = Lists::where('id', $listsid)->with(['notes'])->first();
        return $lists != null ? response()->json($lists, 200) : response()->json(null, 200);
    }

    public function checkid($listsid): JsonResponse
    {
        $lists = Lists::where('id', $listsid)->first();
        return $lists != null ? response()->json(true, 200) : response()->json(false, 200);

    }

    public function findbySearchTerm($searchTerm): JsonResponse
    {
        $lists = Lists::with(['notes'])->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->get();
        return response()->json($lists, 200);
    }

    //neue Liste hinzufügen
    public function save(Request $request): JsonResponse
    {
        // Validierung der Eingabe
        $validated = $request->validate([
            'name' => 'required|string',  // 'name' ist erforderlich und muss ein String sein
        ]);

        DB::beginTransaction();
        try {
            // Erstellt eine neue Liste mit den validierten Daten
            $lists = Lists::create($validated);
            DB::commit();
            // Valide Rückgabe von http
            return response()->json($lists, 201);
        } catch (\Exception $e) {
            // Rollback aller Queries
            DB::rollBack();
            return response()->json("Das Speichern von Listen ist fehlgeschlagen: " . $e->getMessage(), 420);
        }
    }


    //Liste updaten
    public function update(Request $request, string $listsid): JsonResponse
    {
        // Validierung der Eingabedaten
        $validated = $request->validate([
            'name' => 'required|string', // Beispielvalidierung für das 'name' Feld
        ]);

        DB::beginTransaction();
        try {
            //id suchen von Lists
            $lists = Lists::with('notes')->find($listsid);
            if ($lists) {
                //Liste upadten
                $lists->update($validated);
                //Liste in die Datenbank laden
                DB::commit();
                return response()->json($lists, 200);
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Liste nicht gefunden.'], 404); // Liste nicht gefunden
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Das Updaten von Listen ist fehlgeschlagen: " . $e->getMessage()], 420);
        }
    }

    public function delete(string $listsid) : JsonResponse {
        $lists = Lists::where('id', $listsid)->first();
        if ($lists != null) {
            $lists->delete();
            return response()->json('Liste (' . $listsid . ') erfolgreich gelöscht', 200);
        }
        else
        return response()->json('Liste konnte nicht gelöscht werden', 422);
    }

}
