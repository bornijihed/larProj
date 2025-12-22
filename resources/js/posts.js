
let currentPageUrl = '/api/posts';
let currentFilter = null;
let nextPageUrl = null;
let prevPageUrl = null;

// Helpers to get elements lazily or on demand
const getContainer = () => document.getElementById('posts-container');
const getCountBadge = () => document.getElementById('post-count');
const getPaginationControls = () => document.getElementById('pagination-controls');
const getNextBtn = () => document.getElementById('next-btn');
const getPrevBtn = () => document.getElementById('prev-btn');

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

// Fetch Posts
async function fetchPosts(url = '/api/posts') {
    const container = getContainer();
    if (!container) return;

    container.classList.add('opacity-50');
    try {
        // Update URL with filter if present
        let fetchUrl = url;
        if (currentFilter && !url.includes('type=')) {
            const separator = url.includes('?') ? '&' : '?';
            fetchUrl = `${url}${separator}type=${currentFilter}`;
        }

        const response = await fetch(fetchUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();

        // Handle Laravel Pagination Structure
        renderPosts(data.data);
        updatePagination(data);
    } catch (error) {
        console.error('Error fetching posts:', error);
        container.innerHTML = '<p class="text-red-500 text-center">Échec du chargement des articles. Le backend fonctionne-t-il ?</p>';
    } finally {
        container.classList.remove('opacity-50');
    }
}

// Update Pagination Controls
function updatePagination(data) {
    const countBadge = getCountBadge();
    const paginationControls = getPaginationControls();
    const nextBtn = getNextBtn();
    const prevBtn = getPrevBtn();

    if (!countBadge || !nextPageUrl || !prevPageUrl || !paginationControls) return;

    countBadge.innerText = `Page ${data.current_page} sur ${data.last_page}`;

    // Use relative paths to avoid port mismatches
    nextPageUrl = getRelativeUrl(data.next_page_url);
    prevPageUrl = getRelativeUrl(data.prev_page_url);

    prevBtn.disabled = !prevPageUrl;
    nextBtn.disabled = !nextPageUrl;

    // Bind events
    prevBtn.onclick = () => changePage(prevPageUrl);
    nextBtn.onclick = () => changePage(nextPageUrl);

    paginationControls.classList.remove('hidden');
}

function getRelativeUrl(urlStr) {
    if (!urlStr) return null;
    try {
        const url = new URL(urlStr);
        return url.pathname + url.search;
    } catch (e) {
        return urlStr;
    }
}

// Change Page
function changePage(url) {
    if (url) fetchPosts(url);
}

// Filter Posts
function filterPosts(type) {
    currentFilter = type;

    // Update active state of buttons with modern styling
    const baseClasses = 'px-4 py-2.5 text-sm font-medium transition-all duration-200 focus:z-10 focus:ring-2 focus:ring-indigo-500';
    const activeClasses = 'bg-indigo-600 text-white shadow-md';
    const inactiveClasses = 'text-gray-700 hover:bg-gray-50';

    document.getElementById('filter-all').className = `${baseClasses} rounded-l-lg ${!type ? activeClasses : inactiveClasses}`;
    document.getElementById('filter-lost').className = `${baseClasses} border-x border-gray-200 ${type === 'LOST' ? activeClasses : inactiveClasses}`;
    document.getElementById('filter-found').className = `${baseClasses} rounded-r-lg ${type === 'FOUND' ? activeClasses : inactiveClasses}`;

    // Reset to page 1
    fetchPosts('/api/posts');
}
window.filterPosts = filterPosts;

// Render Posts
function renderPosts(posts) {
    const container = getContainer();
    if (!container) return;
    container.innerHTML = '';

    if (posts.length === 0) {
        container.innerHTML = `
            <div class="text-center py-16 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/50 shadow-sm">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune annonce pour le moment</h3>
                <p class="text-sm text-gray-500">Soyez le premier à signaler un objet perdu ou trouvé.</p>
            </div>
        `;
        return;
    }

    posts.forEach(post => {
        const date = new Date(post.created_at).toLocaleDateString('fr-FR', {
            month: 'short', day: 'numeric', year: 'numeric'
        });

        const isLost = post.type === 'LOST';
        const badgeColor = isLost ? 'bg-red-100 text-red-700 border-red-200' : 'bg-green-100 text-green-700 border-green-200';
        const badgeIcon = isLost ? '🔴' : '🟢';
        const badgeText = isLost ? 'PERDU' : 'TROUVÉ';

        const html = `
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-md border border-gray-200/50 p-6 hover:shadow-xl transition-all duration-300 group relative transform hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border ${badgeColor}">
                                ${badgeIcon} ${badgeText}
                            </span>
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                ${escapeHtml(post.location)}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">${escapeHtml(post.title)}</h3>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">${date}</p>
                    </div>
                    <button onclick="deletePost(${post.id})" class="opacity-0 group-hover:opacity-100 ml-3 p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200" title="Supprimer l'article">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 leading-relaxed text-sm mb-4 line-clamp-3">${escapeHtml(post.content)}</p>
                
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <p class="text-sm text-gray-700 font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-gray-500">Contact:</span> <span class="text-gray-900">${escapeHtml(post.contact_info)}</span>
                    </p>
                </div>
            </div>
        `;
        container.innerHTML += html;
    });
}

// Create Post
async function createPost(event) {
    event.preventDefault();
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const typeInput = document.querySelector('input[name="type"]:checked');
    const locationInput = document.getElementById('location');
    const contactInput = document.getElementById('contact_info');
    const btn = event.target.querySelector('button');
    const originalBtnText = btn.innerText;

    btn.disabled = true;
    btn.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Publication...`;

    try {
        const response = await fetch('/api/posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({
                title: titleInput.value,
                content: contentInput.value,
                type: typeInput.value,
                location: locationInput.value,
                contact_info: contactInput.value
            })
        });

        if (response.ok) {
            titleInput.value = '';
            contentInput.value = '';
            locationInput.value = '';
            contactInput.value = '';
            // Reload the current view (likely page 1)
            fetchPosts();
        } else if (response.status === 401) {
            alert('Vous devez être connecté pour créer un post.');
        } else {
            alert('Échec de la création du post. Veuillez vérifier vos données.');
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        btn.disabled = false;
        btn.innerText = originalBtnText;
    }
}
window.createPost = createPost;

// Delete Post
async function deletePost(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) return;

    try {
        const response = await fetch(`/api/posts/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        if (response.ok) {
            // Refresh to keep pagination consistent
            fetchPosts(currentPageUrl);
        } else if (response.status === 401) {
            alert('Vous devez être connecté pour supprimer ce post.');
        } else {
            alert('Échec de la suppression du post.');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
window.deletePost = deletePost;

// Utility: Escape HTML
function escapeHtml(text) {
    if (!text) return text;
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Initial Load
document.addEventListener('DOMContentLoaded', () => fetchPosts());
window.fetchPosts = fetchPosts;
