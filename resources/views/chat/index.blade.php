@extends('layouts.dashboard')
@php use Carbon\Carbon; @endphp
@section('content')
<style>
    .chat-bg {
        background-image: url('/assets/images/bg-chat.png');
        background-size: cover;
        background-position: center;
    }
    .chat-scrollbar::-webkit-scrollbar {
        width: 6px;
        background: #23273a;
    }
    .chat-scrollbar::-webkit-scrollbar-thumb {
        background: #393f56;
        border-radius: 6px;
    }
</style>
<div class="flex flex-col h-[calc(100vh-120px)] bg-gray-50 rounded-lg shadow" dir="rtl">
    <div class="flex flex-1 overflow-hidden rounded-lg">
        <!-- Sidebar: Users List -->
        <div class="w-80 bg-white flex flex-col border-l border-gray-200 shadow-sm">
            <div class="flex items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
                <input type="text" placeholder="بحث عن مستخدم..." class="w-full rounded-lg bg-gray-200 text-gray-700 px-4 py-2 focus:outline-none" />
                <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/></svg>
            </div>
            <div class="flex-1 overflow-y-auto chat-scrollbar">
    @foreach($users as $i => $user)
    <div class="flex items-center px-4 py-3 user-row {{ $i === 0 ? 'bg-indigo-100' : 'hover:bg-gray-100' }} cursor-pointer border-b border-gray-100" data-user-id="{{ $user->id }}">
        <img src="/assets/images/user.png" class="w-10 h-10 rounded-full border-2 border-white ml-3" />
        <div class="flex-1">
            <div class="font-bold {{ $i === 0 ? 'text-indigo-700' : 'text-gray-700' }}">{{ $user->name }} <span class="text-xs text-gray-400">({{ $user->user_type }})</span></div>
            <div class="text-xs text-gray-500 flex items-center gap-2">
                @php
                    $isOnline = $user->last_seen && $user->last_seen->gt(\Carbon\Carbon::now()->subMinutes(2));
                @endphp
                <span class="inline-block w-2 h-2 {{ $isOnline ? 'bg-green-500' : 'bg-red-400' }} rounded-full"></span>
                {{ $isOnline ? 'متصل الآن' : 'غير متصل' }}
            </div>
        </div>
    </div>
@endforeach
<!-- Debug: قائمة المستخدمين -->
<ul class="p-2 text-xs text-gray-700">
@foreach($users as $user)
    <li>ID: {{ $user->id }} | Name: {{ $user->name }} | النوع: {{ $user->user_type }}</li>
@endforeach
</ul>
</div>
        </div>
        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col bg-white rounded-lg">
            <!-- Header -->
            <div class="flex items-center px-8 py-4 border-b border-gray-200 bg-gray-50">
                <img src="/assets/images/user.png" class="w-10 h-10 rounded-full border-2 border-white ml-3" />
                <div class="flex-1">
                    <div class="font-bold text-indigo-700" id="chatHeaderName">
                         <!-- سيتم تعبئته ديناميكياً -->
                     </div>
                    <div class="text-xs text-gray-500 flex items-center gap-2"><span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>متصل الآن</div>
                </div>
            </div>
            <!-- Chat Messages -->
            <div id="chatMessages" class="flex-1 chat-bg overflow-y-auto px-8 py-6 chat-scrollbar flex flex-col justify-end">
                @foreach($messages as $message)
                    @php $outgoing = $message->sender_id == auth()->id(); @endphp
                    <div class="flex flex-col {{ $outgoing ? 'items-end' : 'items-start' }} mb-4">
                        <div class="{{ $outgoing ? 'bg-indigo-600 text-white rounded-t-lg rounded-br-lg' : 'bg-indigo-100 text-indigo-900 rounded-t-lg rounded-bl-lg' }} px-4 py-2 shadow max-w-xs">
                            {{ $message->text ?? $message->message }}
                            <div class="flex items-center gap-1 mt-1 text-xs {{ $outgoing ? 'text-gray-200 justify-end' : 'text-gray-500' }}">
                                <svg class="w-4 h-4 inline-block {{ $outgoing ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $message->created_at ? $message->created_at->format('H:i') : '' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Message Input -->
            <div class="px-8 py-4 border-t border-gray-200 bg-gray-50 flex items-center rounded-b-lg">
                <input type="text" placeholder="اكتب رسالة..." class="flex-1 rounded-lg bg-white text-gray-700 px-4 py-3 border border-gray-200 focus:outline-none" />
                <button id="sendMessageBtn" class="ml-3 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">إرسال</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script>
$(function() {
    let selectedUserId = $('.user-row').first().data('user-id');
    $('.user-row').removeClass('bg-indigo-100');
    $('.user-row').first().addClass('bg-indigo-100');

    function renderMessages(messages) {
        const myId = {{ auth()->id() }};
        let html = '';
        messages.forEach(function(message) {
            const outgoing = message.sender_id == myId;
            html += `<div class='flex flex-col ${outgoing ? 'items-end' : 'items-start'} mb-4'>
                <div class='${outgoing ? 'bg-indigo-600 text-white rounded-t-lg rounded-br-lg' : 'bg-indigo-100 text-indigo-900 rounded-t-lg rounded-bl-lg'} px-4 py-2 shadow max-w-xs'>
                    ${message.message || message.text}
                    <div class='flex items-center gap-1 mt-1 text-xs ${outgoing ? 'text-gray-200 justify-end' : 'text-gray-500'}'>
                        <svg class='w-4 h-4 inline-block ${outgoing ? 'text-white' : 'text-indigo-400'}' fill='none' stroke='currentColor' stroke-width='2' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/></svg>
                        ${message.created_at ? new Date(message.created_at).toLocaleTimeString('ar-EG', {hour: '2-digit', minute:'2-digit'}) : ''}
                    </div>
                </div>
            </div>`;
        });
        $('#chatMessages').html(html);
        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
    }

    function loadMessages() {
        if (!selectedUserId) return;
        $.get('/chat/messages/' + selectedUserId, function(res) {
            renderMessages(res.messages);
        }).fail(function(xhr, status, error) {
            let msg = '';
            if(xhr.status === 404) {
                msg = 'لا يمكن العثور على المحادثة أو المستخدم غير موجود.';
            } else if(xhr.status === 401) {
                msg = 'يجب تسجيل الدخول لعرض الرسائل.';
            } else {
                msg = 'حدث خطأ أثناء تحميل الرسائل.';
            }
            $('#chatMessages').html('<div class="text-center text-red-600 py-8">'+msg+'</div>');
            alert(msg);
            console.error('Load messages error:', xhr, status, error);
        });
    }

    // Poll for new messages every 5 seconds
    setInterval(loadMessages, 5000);

    function updateChatHeaderName() {
        const selectedRow = $('.user-row.bg-indigo-100');
        let name = '';
        if(selectedRow.length) {
            name = selectedRow.find('.font-bold').clone().children().remove().end().text().trim();
        }
        $('#chatHeaderName').text(name);
    }

    $('.user-row').on('click', function() {
        $('.user-row').removeClass('bg-indigo-100');
        $(this).addClass('bg-indigo-100');
        selectedUserId = $(this).data('user-id');
        updateChatHeaderName();
        loadMessages();
    });

    // عند تحميل الصفحة لأول مرة
    updateChatHeaderName();

    function sendMessage() {
        const input = $("input[placeholder='اكتب رسالة...']");
        const btn = $('#sendMessageBtn');
        const message = input.val().trim();
        if (!message || !selectedUserId) return;
        btn.prop('disabled', true);
        $.ajax({
            url: '/chat/send',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message,
                receiver_id: selectedUserId
            },
            success: function(res) {
                console.log('Message sent', res);
                loadMessages();
                input.val('');
                btn.prop('disabled', false);
            },
            error: function(xhr, status, error) {
                alert('فشل إرسال الرسالة!');
                console.error('AJAX error:', xhr, status, error);
                btn.prop('disabled', false);
            }
        });
    }

    $('#sendMessageBtn').on('click', function(e){
        e.preventDefault();
        sendMessage();
    });
    $("input[placeholder='اكتب رسالة...']").on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            sendMessage();
            return false;
        }
    });
});
</script>
@endsection

                    <div class="flex-1">
                        <div class="font-bold text-white">admin</div>
                        <div class="text-sm text-gray-300 flex items-center gap-2"><span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>غير متصل</div>
                    </div>
                </div>
                <!-- Add more users here -->
            </div>
        </div>
        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="flex items-center px-8 py-4 bg-[#23273a] border-b border-[#393f56]">
                <img src="/assets/images/user.png" class="w-10 h-10 rounded-full border-2 border-white ml-3" />
                <div class="flex-1">
                    <div class="font-bold text-white">admin</div>
                </div>
            </div>
            <!-- Chat Messages -->
            <div class="flex-1 chat-bg overflow-y-auto px-8 py-6 chat-scrollbar flex flex-col justify-end">
                <div class="flex flex-col items-start mb-4">
                    <div class="bg-[#6366f1] text-white px-4 py-2 rounded-t-lg rounded-bl-lg shadow max-w-xs">
                        السلام عليكم
                        <div class="flex items-center gap-1 mt-1 text-xs text-gray-200">
                            <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            17:05
                        </div>
                    </div>
                </div>
                <!-- More messages can be added here -->
            </div>
            <!-- Message Input -->
            <div class="px-8 py-4 bg-[#23273a] border-t border-[#393f56] flex items-center">
                <input type="text" placeholder="رسالة" class="flex-1 rounded-lg bg-[#393f56] text-white px-4 py-3 focus:outline-none" />
                <button class="ml-3 bg-[#6366f1] text-white px-6 py-2 rounded-lg hover:bg-[#4f46e5] transition">إرسال</button>
            </div>
        </div>
    </div>
</div>
@endsection