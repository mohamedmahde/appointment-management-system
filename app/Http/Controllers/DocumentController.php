<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Document::with('user');
        
        // تطبيق فلاتر البحث
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $documents = $query->latest()->paginate(10);
        
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:رسمي,داخلي,خارجي'],
            'file' => ['nullable', 'file', 'max:10240'], // 10MB
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'user_id' => auth()->id(),
        ];

        // معالجة الملف المرفق
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        Document::create($data);

        return redirect()->route('documents.index')
            ->with('success', 'تم إضافة المستند بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:رسمي,داخلي,خارجي'],
            'file' => ['nullable', 'file', 'max:10240'], // 10MB
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
        ];

        // معالجة الملف المرفق
        if ($request->hasFile('file')) {
            // حذف الملف القديم إذا وجد
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $path = $request->file('file')->store('documents', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        $document->update($data);

        return redirect()->route('documents.index')
            ->with('success', 'تم تحديث المستند بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // حذف الملف المرفق إذا وجد
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'تم حذف المستند بنجاح');
    }
}
