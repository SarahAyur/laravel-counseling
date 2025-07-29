@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            @if(auth()->user()->isKonselor())
            {{-- Search input - only show for konselor --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            @endif
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div>
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')

<script>
// Cek status chat setiap 30 detik
function setupChatStatusChecker() {
    // Dapatkan ID user dari URL
    const urlPath = window.location.pathname;
    const urlSegments = urlPath.split('/');
    const lastSegment = urlSegments[urlSegments.length - 1];
    
    // Hanya lakukan cek jika ada ID user
    if (lastSegment && !isNaN(lastSegment)) {
        // Set interval untuk polling setiap 30 detik
        const intervalId = setInterval(() => {
            // AJAX call ke endpoint checkChatStatus
            $.ajax({
                url: "{{ route('checkChatStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: lastSegment
                },
                success: function(response) {
                    console.log("Chat status check:", response);
                    
                    // Jika chat disabled, reload halaman
                    if (!response.chat_enabled) {
                        console.log("Chat disabled, reloading page...");
                        window.location.href = "{{ route('dashboard') }}";
                    }
                },
                error: function(xhr) {
                    console.error("Error checking chat status:", xhr);
                }
            });
        }, 30000); // 30 detik
        
        // Simpan interval ID agar bisa di-clear jika perlu
        window.chatStatusCheckerId = intervalId;
    }
}

// Jalankan ketika dokumen siap
$(document).ready(function() {
    setupChatStatusChecker();
    
    // Tambahkan listener untuk perubahan URL (jika ada fitur SPA)
    window.addEventListener('popstate', function() {
        // Clear interval yang ada jika ada
        if (window.chatStatusCheckerId) {
            clearInterval(window.chatStatusCheckerId);
        }
        
        // Setup ulang
        setupChatStatusChecker();
    });
});
</script>
