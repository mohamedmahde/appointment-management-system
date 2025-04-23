<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = \App\Models\Appointment::with(['requester', 'manager'])->orderBy('scheduled_time','desc')->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = \App\Models\Appointment::with(['requester', 'manager'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        if (auth()->id() !== $appointment->manager_id) {
            abort(403);
        }
        $action = $request->input('action');
        if ($action === 'accept') {
            $appointment->status = 'مقبول';
            $appointment->appointment_time = now();
            $appointment->rejection_reason = null;
        } elseif ($action === 'schedule') {
            $appointment->status = 'مؤجل';
            $appointment->appointment_time = $request->input('appointment_time');
            $appointment->rejection_reason = null;
        } elseif ($action === 'reject') {
            $appointment->status = 'مرفوض';
            $appointment->appointment_time = null;
            $appointment->rejection_reason = $request->input('rejection_reason');
        }
        $appointment->save();
        // تحديث الطلب المرتبط إذا وُجد
        $relatedRequest = \App\Models\Request::where('type', 'مقابلة')
            ->where('title', $appointment->title ?? null)
            ->where('sender_id', $appointment->requester_id)
            ->where('receiver_id', $appointment->manager_id)
            ->first();
        if ($relatedRequest) {
            $relatedRequest->status = $appointment->status;
            $relatedRequest->scheduled_time = $appointment->appointment_time;
            $relatedRequest->rejection_reason = $appointment->rejection_reason;
            $relatedRequest->save();
        }
        // إعادة التوجيه حسب الحالة
        // إعداد إشعار مع صوت مناسب
        $notification = null;
        if ($appointment->status === 'مقبول') {
            $notification = [
                'message' => 'تم قبول الطلب وتحويله إلى قائمة الطلبات المقبولة.',
                'sound' => 'approval.mp3',
            ];
            return redirect()->route('requests.accepted')->with('success', $notification['message'])->with('notification', $notification);
        } elseif ($appointment->status === 'مرفوض') {
            $notification = [
                'message' => 'تم رفض الطلب وتحويله إلى قائمة الطلبات المرفوضة.',
                'sound' => 'reject.mp3',
            ];
            return redirect()->route('requests.rejected')->with('success', $notification['message'])->with('notification', $notification);
        } elseif ($appointment->status === 'مؤجل') {
            $notification = [
                'message' => 'تم تأجيل الطلب وتحويله إلى قائمة الطلبات المؤجلة.',
                'sound' => 'postponed.mp3',
            ];
            return redirect()->route('requests.scheduled')->with('success', $notification['message'])->with('notification', $notification);
        }
        // إشعار افتراضي
        return redirect()->route('appointments.show', $appointment->id)
            ->with('success', 'تم تحديث حالة الموعد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
