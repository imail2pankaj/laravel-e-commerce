  <nav class="sticky top-0 z-50 bg-transparent transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
          <img src="{{ asset('assets/frontend/image/logo.png')}}" alt="Electra" class="h-8">
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 items-center">
          <a href="#" class="text-dark font-medium border-b-2 border-primary pb-1">Home</a>
<div class="relative group">
    <button
        class="flex items-center gap-1 text-light hover:text-dark transition-colors font-medium"
        type="button"
    >
        Category
        <svg
            class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown -->
        <div
            class="absolute left-0 top-full mt-3 w-56 bg-card rounded-lg shadow-lg
                  opacity-0 invisible group-hover:opacity-100 group-hover:visible
                  transition-all duration-200 z-50"
        >
            <ul class="py-2">
                @forelse($categories  as $category)
                    <li>
                        <a
                            href=""
                            class="block px-4 py-2 text-light hover:bg-background hover:text-dark transition"
                        >
                            {{ $category->name }}
                        </a>
                    </li>
                @empty
                    <li class="px-4 py-2 text-light text-sm">
                        No categories found
                    </li>
                @endforelse
            </ul>
        </div>
    </div>


          <div class="relative group">
            <button class="flex items-center gap-1 text-light hover:text-dark transition-colors font-medium">
              Shop
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
          </div>
          <a href="#" class="text-light hover:text-dark transition-colors font-medium">Contact</a>
          <a href="#" class="text-light hover:text-dark transition-colors font-medium">Blog</a>
        </div>

        <!-- Icons -->
        <div class="flex items-center space-x-4">
          <button
            class="w-10 h-10 border border-dark/20 rounded-md flex items-center justify-center text-dark hover:border-primary hover:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </button>
          <button
            class="w-10 h-10 border border-accent text-accent rounded-md flex items-center justify-center hover:bg-accent hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </button>
          <div class="relative cursor-pointer">
            <button
              class="w-10 h-10 border border-primary text-primary rounded-md flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
              </svg>
            </button>
            <!-- Badge is technically internal to the cart button usually, but keeping outside is fine or inside. 
                 The image doesn't show a badge count explicitly, but it's good practice. I will remove it to be EXACT. -->
          </div>
          <button id="mobile-menu-btn"
            class="md:hidden text-dark hover:text-primary transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
      <div class="px-4 pt-2 pb-4 space-y-1">
        <a href="#"
          class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50">Home</a>
        <a href="#"
          class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50">Category</a>
        <a href="#"
          class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50">Shop</a>
        <a href="#"
          class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50">Contact</a>
        <a href="#"
          class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50">Blog</a>
      </div>
    </div>
  </nav>