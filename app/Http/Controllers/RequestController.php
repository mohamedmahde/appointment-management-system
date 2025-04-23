<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * عرض الطلبات المقبولة
     */
    public function accepted()
    {
        $requests = \App\Models\Request::where('status', 'مقبول')->latest()->paginate(10);
        $notification = session('notification');
        return view('requests.accepted', compact('requests', 'notification'));
    }

    /**
     * عرض الطلبات المرفوضة
     */
    public function rejected()
    {
        $requests = \App\Models\Request::where('status', 'مرفوض')->latest()->paginate(10);
        $notification = session('notification');
        return view('requests.rejected', compact('requests', 'notification'));
    }

    /**
     * عرض الطلبات المؤجلة
     */
    public function scheduled()
    {
        $requests = \App\Models\Request::where('status', 'مؤجل')->whereNotNull('scheduled_time')->latest()->paginate(10);
        $notification = session('notification');
        return view('requests.scheduled', compact('requests', 'notification'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = \App\Models\Request::with(['sender', 'receiver'])->latest()->paginate(10);
        $notification = session('notification');
        return view('requests.index', compact('requests', 'notification'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // نموذج إرسال طلب مقابلة
        return view('requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10 MB max
        ]);
        // السماح لأي مستخدم بإرسال الطلب، وتعيين المستلم إلى أول مدير فقط
        // البحث عن أول مستخدم نوعه 'مدير' في عمود user_type
        $manager = \App\Models\User::where('user_type', 'مدير')->first();
        if (!$manager) {
            return back()->withErrors(['لا يوجد مدير في النظام. يرجى إضافة مدير أولاً.']);
        }
        $req = new \App\Models\Request();
        $req->title = $request->title;
        $req->interviewee_name = $request->interviewee_name;
        $req->description = $request->description;
        $req->type = $request->type ?? 'مقابلة';
        $req->sender_id = auth()->id();
        $req->receiver_id = $manager->id;
        $req->status = 'قيد المراجعة';
        // معالجة الملف المرفق
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('request_attachments', 'public');
            $req->file_path = $path;
            $req->file_name = $file->getClientOriginalName();
        }
        $req->save();
        // إشعار صوتي للمدير (يتم عبر JS عند فتح صفحة المدير)
        return redirect()->route('requests.index')->with('success', 'تم إرسال الطلب بنجاح! يمكنك متابعة حالة الطلب من قائمة كل الطلبات.');
    }

    /**
     * Download the attached file for a request.
     */
    public function download($id)
    {
        $request = \App\Models\Request::findOrFail($id);
        if (!$request->file_path) {
            abort(404);
        }
        $file = storage_path('app/public/' . $request->file_path);
        return response()->download($file, $request->file_name ?? basename($file));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = \App\Models\Request::with(['sender', 'receiver'])->findOrFail($id);
        return view('requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $request = \App\Models\Request::findOrFail($id);
        if (!(auth()->id() === $request->sender_id || (auth()->user() && (auth()->user()->user_type === 'مدير' || auth()->user()->user_type === 'سكرتير')))) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب.');
        }
        return view('requests.edit', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $req = \App\Models\Request::findOrFail($id);
        // السماح بالتعديل لصاحب الطلب أو المدير أو السكرتير
        if (!(auth()->id() === $req->sender_id || (auth()->user() && (auth()->user()->user_type === 'مدير' || auth()->user()->user_type === 'سكرتير')))) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب.');
        }

        // إذا كان هناك action فهذا تحديث حالة من المدير
        if ($request->has('action')) {
            $action = $request->input('action');
            if ($action === 'accept') {
                $req->status = 'مقبول';
                $req->scheduled_time = now();
                $req->rejection_reason = null;
                $req->save();
                $notification = [
    'message' => 'تم قبول الطلب وتحويله إلى قائمة الطلبات المقبولة.',
    'sound' => 'approval.mp3',
];
return redirect()->route('requests.accepted')
    ->with('success', $notification['message'])
    ->with('notification', $notification);
            } elseif ($action === 'schedule') {
                $request->validate([
                    'scheduled_time' => 'required|date',
                ], [
                    'scheduled_time.required' => 'يرجى تحديد تاريخ ووقت التأجيل.'
                ]);
                $req->status = 'مؤجل';
                $req->scheduled_time = $request->input('scheduled_time');
                $req->rejection_reason = null;
                $req->save();
                $notification = [
    'message' => 'تم تأجيل الطلب وتحويله إلى قائمة الطلبات المؤجلة.',
    'sound' => 'postponed.mp3',
];
return redirect()->route('requests.scheduled')
    ->with('success', $notification['message'])
    ->with('notification', $notification);
            } elseif ($action === 'reject') {
                $req->status = 'مرفوض';
                $req->rejection_reason = $request->input('rejection_reason');
                $req->scheduled_time = null;
                $req->save();
                $notification = [
    'message' => 'تم رفض الطلب وتحويله إلى قائمة الطلبات المرفوضة.',
    'sound' => 'reject.mp3',
];
return redirect()->route('requests.rejected')
    ->with('success', $notification['message'])
    ->with('notification', $notification);
            }
        }

        // التحديث العادي (قديم)
        $request->validate([
            'title' => 'required|string|max:255',
            'interviewee_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $req->title = $request->title;
        $req->interviewee_name = $request->interviewee_name;
        $req->description = $request->description;
        $req->save();
        return redirect()->route('requests.show', $req->id)->with('success', 'تم تعديل الطلب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $req = \App\Models\Request::findOrFail($id);
        // السماح بالحذف لصاحب الطلب أو المدير أو السكرتير
        if (!(auth()->id() === $req->sender_id || (auth()->user() && (auth()->user()->user_type === 'مدير' || auth()->user()->user_type === 'سكرتير')))) {
            abort(403, 'غير مصرح لك بحذف هذا الطلب.');
        }
        $req->delete();
        return redirect()->route('requests.index')->with('success', 'تم حذف الطلب بنجاح');
    }
}
