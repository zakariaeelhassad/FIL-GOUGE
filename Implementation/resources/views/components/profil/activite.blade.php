<div class="bg-white rounded-xl p-5">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold text-gray-900">Activité</h2>
        @if(auth()->check() && auth()->id() === $user->id)
            <button onclick="openModal('activiteModal')" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-full transition shadow-sm flex items-center">
                <i class="fas fa-plus h-4 w-4 mr-1"></i>
                Create Post
            </button>
        @endif
    </div>
    @php
        $authUser = Auth::user();
    @endphp

    @if($posts->count() > 0)
        <div class="space-y-5">
            @foreach($posts as $post)
                <div class="bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition hover-lift">
                    <div class="p-4">
                        <div class="p-5 flex items-start space-x-3">
                            <img
                                src="{{ asset('storage/' . ($post->user->profile_image ?? '../../../images/la-personne.png'))}}"
                                alt="Profile"
                                class="rounded-full w-12 h-12 object-cover border-2 border-brand-100"
                            />
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-brand-600 font-bold text-lg">{{ $post->user ? $post->user->full_name : 'Unknown User' }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $post->user ? $post->user->bio : 'No Bio Available' }}</p>
                                    </div>
                                    @if(auth()->check() && auth()->id() !== $post->user_id)
                                    <div class="text-gray-400 relative group">
                                        <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50"
                                                onclick="toggleDropdown({{ $post->id }})">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                    
                                        <div id="dropdown-{{ $post->id }}" class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-md z-20 hidden">
                                            <button
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                onclick="openReportModal({{ $post->id }}, 'post')"
                                            >
                                                Signaler ce post
                                            </button>
                                        </div>
                                    </div>
                                    @endif 
                                    @if(auth()->check() && auth()->id() === $post->user_id)
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown({{ $post->id }})" class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50 focus:outline-none">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                        
                                            <div id="dropdown-{{ $post->id }}" class="dropdown-menu absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                                                <div class="py-1 text-sm text-gray-700">
                                                    <button class="block w-full text-left px-4 py-2 hover:bg-gray-100" onclick="openModal('editPostModal')">
                                                        Edit
                                                    </button>
                                               
                                                    <form action="{{ route('delete.post', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')" class="block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">Delete</button>
                                                    </form>                                                                                            
                                                </div>
                                            </div>
                                        </div> 
                                    @endif                                  
                                </div>
                                <div class="text-gray-400 text-xs mt-1">
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4 leading-relaxed">
                            {{ $post->content }}
                        </p>

                        @if($post->media->isNotEmpty())
                            <div class="rounded-lg overflow-hidden mb-4 bg-white border border-gray-200">
                                @foreach($post->media as $media)
                                    @if($media->type === 'image')
                                        <img 
                                            src="{{ asset('storage/' . $media->path) }}" 
                                            alt="Post image" 
                                            class="w-full object-cover max-h-80"
                                        >
                                    @elseif($media->type === 'video')
                                        <video controls class="w-full max-h-80">
                                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-100">
                        <div class="flex items-center space-x-1">
                            @php
                                $reactionEmojis = [
                                    'like' => '👍',
                                    'love' => '❤️',
                                    'wow' => '😲',
                                    'haha' => '😂',
                                    'sad' => '😢',
                                    'grr'  => '😡',
                                ];
                                
                                $userReaction = App\Models\Reaction::where('user_id', auth()->id())
                                    ->where('post_id', $post->id)
                                    ->first();
                            @endphp
                            <span class="text-gray-500 text-sm ml-1">{{ $post->reactions->count() }} Réaction</span>
                            <span class="mx-1">•</span> 
                        </div>
                        
                        <div class="text-gray-500 text-sm">
                            @php
                                $totalComments = $post->comments->count(); 
                                $totalReplies = $post->comments->sum(function($comment) {
                                    return $comment->replies->count();
                                });
                                $total = $totalComments + $totalReplies;
                            @endphp
                        
                            <span>{{ $total }} comments</span>
                            <span class="mx-1">•</span> 
                        </div>
                        
                    </div>

                    <div class="px-5 py-3 flex space-x-2">

                        <div id="reaction-container-{{ $post->id }}" class="relative flex-1">
                            <button type="button" class="reaction-button flex items-center justify-center w-full bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition">
                                <span class="mr-2">{{ $userReaction ? ($reactionEmojis[$userReaction->reaction] ?? '👍') : '👍' }}</span>
                                <span class="font-medium">{{ $userReaction ? ucfirst($userReaction->reaction) : 'Like' }}</span>
                            </button>
                            
                            <div class="reaction-container absolute top-full left-0 mt-2 bg-white border rounded-xl shadow-hover flex space-x-1 p-2 hidden z-10 w-full min-h-[48px]">
                                @foreach ($reactionEmojis as $key => $emoji)
                                    <form hx-post="{{ route('posts.react.store', $post->id) }}" 
                                        hx-target="#reaction-container-{{ $post->id }}" 
                                        hx-swap="outerHTML"
                                        class="inline">
                                        @csrf
                                        <button type="submit" name="reaction" value="{{ $key }}" class="text-2xl hover:bg-gray-100 rounded-full p-1.5 transition">
                                            {{ $emoji }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>

                        <button type="button" class="comment-button flex items-center justify-center flex-1 bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition" 
                                data-post-id="{{ $post->id }}">
                            <span class="mr-2">💬</span>
                            <span class="font-medium">Comment</span>
                        </button>
                    </div>

                    @if ($post->userReactions && $post->userReactions->isNotEmpty())
                        <div class="px-5 pb-4">
                            <form action="/posts/{{ $post->id }}/react" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="bg-red-50 text-red-500 border border-red-200 rounded-xl py-2 px-4 text-sm font-medium hover:bg-red-100 transition">
                                    Remove Reaction
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="comment-section hidden border-t border-gray-100" id="comment-section-{{ $post->id }}">
                        <div class="p-5">
                            <form hx-post="/posts/{{ $post->id }}/comment" 
                                hx-target="#comments-container-{{ $post->id }}" 
                                hx-swap="beforeend"
                                class="flex items-center mb-4">
                                @csrf
                                <img 
                                    src="{{ asset('storage/' . $authUser->profile_image ?? 'default-avatar.png') }}" 
                                    class="w-8 h-8 rounded-full object-cover mr-3 border border-brand-100"
                                    alt="Profile"
                                >
                                <input 
                                    type="text" 
                                    name="content" 
                                    class="border border-gray-200 rounded-full px-4 py-2 flex-grow focus:outline-none focus:ring-2 focus:ring-brand-300" 
                                    placeholder="Write a comment..." 
                                    required 
                                    id="comment-input-{{ $post->id }}"
                                >
                                <button type="submit" class="bg-brand-500 text-white rounded-full px-4 py-2 ml-2 hover:bg-brand-600 transition">
                                    Post
                                </button>
                            </form>
                            
                            <div id="comments-container-{{ $post->id }}" class="comments-list space-y-4">
                                @foreach($post->comments ?? [] as $comment)
                                @include('partials.comments', ['comment' => $comment])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <i class="fas fa-microphone h-12 w-12 text-gray-400"></i>
            <p class="mt-4 text-gray-500">No posts yet</p>
            <p class="text-sm text-gray-400 mt-1">Click the "Create Post" button to share your first update</p>
        </div>
    @endif
</div>

@if($profile)
<div id="activiteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Create New Post</h3>
            <button type="button" onclick="closeModal('activiteModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form 
            id="create-post-form" 
            action="{{ route('posts.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            @csrf
            
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-brand-100 border border-brand-200">
                    <img 
                        src="{{ asset('storage/' . Auth::user()->profile_image ?? 'default-avatar.png') }}" 
                        alt="Profile" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</p>
                    <p class="text-xs text-gray-500">Posting publicly</p>
                </div>
            </div>
            
            <textarea 
                name="content" 
                rows="4" 
                class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                placeholder="What's on your mind?"
                required
            ></textarea>
            
            <div>
                <label for="post_media" class="block text-sm font-medium text-gray-700 mb-1">Add Media (Optional)</label>
                <input 
                    type="file" 
                    name="media[]" 
                    id="post_media"
                    accept="image/*,video/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                    multiple
                >
                <p class="text-xs text-gray-500 mt-1">You can upload multiple files (images or videos, max 50MB each)</p>
            </div>

            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('activiteModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Post
                </button>
            </div>
        </form>
    </div>
</div>

@foreach($posts as $post)
<div id="editPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Modifier le Post</h3>
            <button type="button" onclick="closeModal('editPostModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form 
            action="{{ route('update.post', $post->id) }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="space-y-4"
        >
            @csrf
            @method('PUT')

            <textarea 
                name="content" 
                id="edit-post-content"
                rows="4" 
                class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                placeholder="Quoi de neuf ?"
                required
            >{{ old('content', $post->content) }}</textarea>

            <div>
                <label for="edit_post_media" class="block text-sm font-medium text-gray-700 mb-1">Modifier les médias (facultatif)</label>
                <input 
                    type="file" 
                    name="media[]" 
                    id="edit_post_media"
                    accept="image/*,video/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                    multiple
                >
                <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG, MP4 (max 50MB)</p>
                <p class="text-xs text-red-500 mt-1">
                    Ajouter de nouveaux fichiers remplacera tous les anciens médias.
                </p>
            </div>

            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('editPostModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach



<script src="{{ asset('js/home.js') }}"></script>
<script>

    function toggleDropdown(commentId) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });

        const dropdown = document.getElementById('dropdown-' + commentId);
        dropdown.classList.toggle('hidden');
    }


    function openReportModal(id, type) {
        document.getElementById('reported_id').value = id;
        document.getElementById('reported_type').value = type;
        document.getElementById('report-modal').classList.remove('hidden');
        document.getElementById('report-modal').classList.add('flex');
    }

    function closeReportModal() {
        document.getElementById('report-modal').classList.remove('flex');
        document.getElementById('report-modal').classList.add('hidden');
    }

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
    }
    
</script> 
@endif