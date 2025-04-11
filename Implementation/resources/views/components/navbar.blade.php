<nav class="bg-gray-900 text-white shadow-md py-3 px-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <a href="/" class="text-3xl font-bold bg-blue-600 rounded-md p-1">
                <span class="px-2">GI.</span>
            </a>
            <!-- Bouton de recherche -->
            <div class="bg-gray-700 p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    
        <!-- Boutons centraux -->
        <div class="flex space-x-4 items-center">
            <a href="/" class="bg-gray-700 p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </a>
    
            <a href="/reseau" class="bg-gray-700 p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
        </div>
    
        <!-- Profil -->
        <div class="flex items-center space-x-4">
            <a href="/notification" class="bg-gray-700 p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </a>
    
            <div class="relative inline-block text-left">
                <!-- Trigger button -->
                <button onclick="toggleDropdown()" class="flex items-center bg-gray-700 rounded-full pl-1 pr-3 py-1 cursor-pointer text-white">
                  <img src="https://via.placeholder.com/30" alt="Profile" class="rounded-full h-8 w-8 border-2 border-yellow-500" />
                  <span class="ml-2">Alex Rodriguez</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
              
                <!-- Dropdown menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border z-50">
                  <a href="/profil_Club" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Logout
                </a>

            </div>
              </div>
        </div>
    </div>
</nav>

<div class="h-1 bg-blue-500"></div>

<script>
    function toggleDropdown() {
      const menu = document.getElementById("dropdownMenu");
      menu.classList.toggle("hidden");
    }
  
    window.addEventListener("click", function (e) {
      const button = document.querySelector("button[onclick='toggleDropdown()']");
      const menu = document.getElementById("dropdownMenu");
      if (!button.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add("hidden");
      }
    });
  </script>