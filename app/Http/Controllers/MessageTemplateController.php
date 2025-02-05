<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(MessageTemplate::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'workflow_id' => 'required|in:Cold,Follow up,Warm,Hot,Won,Lost,No contact',
            'template' => 'required|string',
        ]);

        $messageTemplate = MessageTemplate::create([
            'workflow_id' => $request->workflow_id,
            'template' => $request->template,
            'created_by' => Auth::id(),
        ]);

        return response()->json($messageTemplate, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(MessageTemplate::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'workflow_id' => 'required|in:Cold,Follow up,Warm,Hot,Won,Lost,No contact',
            'template' => 'required|string',
        ]);

        $messageTemplate = MessageTemplate::findOrFail($id);
        $messageTemplate->update([
            'workflow_id' => $request->workflow_id,
            'template' => $request->template,
            'updated_by' => Auth::id(),
        ]);

        return response()->json($messageTemplate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $messageTemplate = MessageTemplate::findOrFail($id);
        $messageTemplate->update(['deleted_by' => Auth::id()]);
        $messageTemplate->delete();

        return response()->json(['message' => 'Message template deleted successfully.']);
    }
}
