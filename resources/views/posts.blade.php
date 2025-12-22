<x-layout>
    <x-slot:headerActions>
        <button onclick="fetchPosts()" class="text-gray-500 hover:text-gray-700 p-2 rounded-md hover:bg-gray-100 transition" title="Refresh Feed">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        
        <!-- Feed Section -->
        <div class="flex-1 order-2 md:order-1">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-900">Objets Perdus et Trouvés</h2>
                <div class="flex items-center gap-3">
                    <div class="inline-flex rounded-lg shadow-sm bg-white border border-gray-200" role="group">
                        <button type="button" onclick="filterPosts(null)" id="filter-all" class="px-4 py-2.5 text-sm font-medium rounded-l-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                            Tous
                        </button>
                        <button type="button" onclick="filterPosts('LOST')" id="filter-lost" class="px-4 py-2.5 text-sm font-medium border-x border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                            🔴 Perdus
                        </button>
                        <button type="button" onclick="filterPosts('FOUND')" id="filter-found" class="px-4 py-2.5 text-sm font-medium rounded-r-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                            🟢 Trouvés
                        </button>
                    </div>
                    <span id="post-count" class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm">Page 1</span>
                </div>
            </div>
            
            <div id="posts-container" class="space-y-6">
                <!-- Posts will be injected here -->
                <div class="animate-pulse space-y-4">
                    <div class="h-40 bg-gray-200 rounded-xl"></div>
                    <div class="h-40 bg-gray-200 rounded-xl"></div>
                </div>
            </div>

            <!-- Pagination Controls -->
            <div id="pagination-controls" class="hidden mt-8 flex justify-center gap-3">
                <button id="prev-btn" disabled
                    class="px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                    ← Précédent
                </button>
                <button id="next-btn" disabled
                    class="px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                    Suivant →
                </button>
            </div>
        </div>

        <!-- Create Post Sidebar -->
        <div class="w-full md:w-96 order-1 md:order-2">
            <div class="sticky top-20">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Signaler un Objet</h3>
                    </div>
                    <form id="create-post-form" onsubmit="createPost(event)">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Type d'annonce</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="relative flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all duration-200 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                        <input type="radio" name="type" value="LOST" checked class="sr-only">
                                        <span class="text-sm font-medium">🔴 Perdu</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-300 hover:bg-green-50 transition-all duration-200 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                        <input type="radio" name="type" value="FOUND" class="sr-only">
                                        <span class="text-sm font-medium">🟢 Trouvé</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Titre de l'objet</label>
                                <input type="text" id="title" name="title" required
                                    class="block w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm p-3 placeholder-gray-400 transition-all duration-200"
                                    placeholder="Ex: Clés de voiture...">
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Lieu</label>
                                <input type="text" id="location" name="location" required
                                    class="block w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm p-3 placeholder-gray-400 transition-all duration-200"
                                    placeholder="Ex: Parc Central...">
                            </div>
                            <div>
                                <label for="contact_info" class="block text-sm font-semibold text-gray-700 mb-2">Contact</label>
                                <input type="text" id="contact_info" name="contact_info" required
                                    class="block w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm p-3 placeholder-gray-400 transition-all duration-200"
                                    placeholder="06 12 34 56 78">
                            </div>
                            <div>
                                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="content" name="content" rows="3" required
                                    class="block w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:text-sm p-3 placeholder-gray-400 transition-all duration-200 resize-none"
                                    placeholder="Détails supplémentaires..."></textarea>
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-[1.02]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Publier l'annonce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <x-slot:scripts>
    @vite('resources/js/posts.js')
</x-slot>
</x-layout>
