@extends('frontend.layout.layout')

@section('meta-content')
    <title>Index Page </title>
    <meta name="description" content="Index description" />
@endsection

@section('css-section')
{{-- //css section --}}
@endsection

@section('content')


  <!-- Hero Section -->
  <section class="relative pt-10 pb-20 lg:pt-20 lg:pb-48 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        <!-- Left Content -->
        <div class="space-y-6 z-10">
          <h1 class="text-5xl lg:text-7xl font-bold leading-tight text-dark">
            World's Biggest <br />
            <span class="text-accent">Antique Collection</span>
          </h1>
          <p class="text-light text-lg max-w-lg leading-relaxed">
            From they fine john he give of rich he. They age and draw mrs like. Improving end distrusts may instantly
            was household applauded incommode.
          </p>
          <div class="flex gap-4 pt-4">
            <button
              class="bg-primary hover:bg-green-600 text-white font-semibold py-4 px-8 rounded-btn shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
              Shop Now
            </button>
            <button
              class="flex items-center gap-3 bg-transparent hover:bg-white/50 text-dark font-medium py-4 px-8 rounded-btn border border-transparent hover:border-gray-200 transition-all duration-300">
              <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                <svg class="w-4 h-4 ml-1 text-dark" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
              Watch Video
            </button>
          </div>
        </div>




        <!-- Right Image (Floating) -->
        <div class="relative lg:h-[600px] flex items-center justify-center animate-float">
          <div class="relative w-full max-w-lg">
            <!-- Background Decoration Blob -->
            <div
              class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl -z-10">
            </div>

            <!-- Main Image -->
            <div class="relative">
              <img src="{{ asset('assets/frontend/image/digitalcamera 1.png')}}" alt="Antique Camera Collection"
                class="drop-shadow-2xl object-contain mx-auto">
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  

  <!-- Top Categories (with Overlapping Features) -->
  <section class="relative pt-48 pb-20 bg-white">

    <!-- Overlapping Features Grid -->
    <div class="absolute top-0 left-0 w-full -translate-y-1/2 z-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

          <!-- Feature 1: Green -->
          <div
            class="relative bg-[#dcfce7] p-8 pt-16 hover:shadow-lg transition-all duration-300 group text-center h-64 flex flex-col items-center justify-center rounded-[20px]">
            <div
              class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-[#EAF6F5] rounded-full flex items-center justify-center">
              <div class="w-10 h-10 flex items-center justify-center">
                <svg class="w-8 h-8 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
              </div>
            </div>
            <h3 class="font-bold text-lg mb-2 uppercase tracking-wide mt-4">Free Sheeping</h3>
            <p class="text-xs text-dark/70 leading-relaxed px-2">On the other hand, we denounce with righteous
              indignation and dislike men.</p>
          </div>

          <!-- Feature 2: Blue -->
          <div
            class="relative bg-[#dbeafe] p-8 pt-16 hover:shadow-lg transition-all duration-300 group text-center h-64 flex flex-col items-center justify-center rounded-[20px]">
            <div
              class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-[#EAF6F5] rounded-full flex items-center justify-center">
              <div class="w-10 h-10 flex items-center justify-center">
                <svg class="w-8 h-8 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <h3 class="font-bold text-lg mb-2 uppercase tracking-wide mt-4">100% Original Product</h3>
            <p class="text-xs text-dark/70 leading-relaxed px-2">On the other hand, we denounce with righteous
              indignation and dislike men.</p>
          </div>

          <!-- Feature 3: Yellow -->
          <div
            class="relative bg-[#fef9c3] p-8 pt-16 hover:shadow-lg transition-all duration-300 group text-center h-64 flex flex-col items-center justify-center rounded-[20px]">
            <div
              class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-[#EAF6F5] rounded-full flex items-center justify-center">
              <div class="w-10 h-10 flex items-center justify-center">
                <svg class="w-8 h-8 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                  </path>
                </svg>
              </div>
            </div>
            <h3 class="font-bold text-lg mb-2 uppercase tracking-wide mt-4">Gift Cards</h3>
            <p class="text-xs text-dark/70 leading-relaxed px-2">On the other hand, we denounce with righteous
              indignation and dislike men.</p>
          </div>

          <!-- Feature 4: Pink -->
          <div
            class="relative bg-[#fce7f3] p-8 pt-16 hover:shadow-lg transition-all duration-300 group text-center h-64 flex flex-col items-center justify-center rounded-[20px]">
            <div
              class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-[#EAF6F5] rounded-full flex items-center justify-center">
              <div class="w-10 h-10 flex items-center justify-center">
                <svg class="w-8 h-8 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
            </div>
            <h3 class="font-bold text-lg mb-2 uppercase tracking-wide mt-4">Tracking & Delivery</h3>
            <p class="text-xs text-dark/70 leading-relaxed px-2">On the other hand, we denounce with righteous
              indignation and dislike men.</p>
          </div>

        </div>
      </div>
    </div>
    
    <!-- Actual Top Categories Content -->
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-12">
        <h2 class="text-3xl font-bold text-dark mb-4">Top Categories</h2>
        <p class="text-light">Party we years to order allow asked of. We so opinion friends me message as delight.</p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 grid-flow-row-dense">

        <!-- Category Item: Small (Col 1, Row 1) -->
        <div
          class="group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-64 flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/speaker.png')}}" alt="Google Speaker"
            class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
          <div class="absolute bottom-4 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-md">Google speaker</h3>
          </div>
        </div>

        <!-- Category Item: Tall (Col 2, Row 1-2) -->
        <div
          class="md:col-span-1 md:row-span-2 group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-full min-h-[500px] flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/speaker2.png')}}" alt="Bluetooth Speaker"
            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute bottom-8 left-8">
            <h3 class="text-white font-bold text-3xl drop-shadow-lg">Bluetooth speaker</h3>
          </div>
        </div>

        <!-- Category Item: Wide (Col 3-4, Row 1) -->
        <div
          class="md:col-span-2 group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-64 flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/s-watch.png')}}" alt="Smart Watch"
            class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
          <div class="absolute bottom-4 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-md">Smart watch</h3>
          </div>
        </div>

        <!-- Row 2 Items -->
        <!-- Wireless Headset (Col 1, Row 2) -->
        <div
          class="group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-64 flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/headset.png')}}" alt="Wireless Headset"
            class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
          <div class="absolute bottom-4 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-md">Wireless headset</h3>
          </div>
        </div>

        <!-- Spy Cam (Col 3, Row 2) -->
        <div
          class="group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-64 flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/s-cam.png')}}" alt="Spy Cam"
            class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
          <div class="absolute bottom-4 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-md">Spy Cam</h3>
          </div>
        </div>

        <!-- Drone (Col 4, Row 2) -->
        <div
          class="group relative rounded-card overflow-hidden bg-gradient-to-b from-white to-gray-300 h-64 flex items-center justify-center cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300">
          <img src="{{ asset('assets/frontend/image/drone.png')}}" alt="Drone"
            class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
          <div class="absolute bottom-4 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-md">Drone</h3>
          </div>
        </div>

      </div>
    </div> --}}

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-dark mb-4">Top Categories</h2>
        <p class="text-light">
            Party we years to order allow asked of. We so opinion friends me message as delight.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 grid-flow-row-dense">

        @forelse($homeCategories as $index => $category)

            <a
                href=""
                class="
                    group relative rounded-card overflow-hidden
                    bg-gradient-to-b from-white to-gray-300
                    flex items-center justify-center cursor-pointer
                    shadow-sm hover:shadow-xl transition-all duration-300
                    {{ $index === 1 ? 'md:row-span-2 min-h-[500px]' : 'h-64' }}
                    {{ $index === 2 ? 'md:col-span-2' : '' }}
                "
            >
                <img
                    src="{{ $category->image
                        ? asset('storage/' . $category->image)
                        : asset('assets/frontend/image/placeholder.png') }}"
                    alt="{{ $category->name }}"
                    class="
                        {{ $index === 1 ? 'h-full w-full object-cover' : 'h-40 object-contain' }}
                        group-hover:scale-110 transition-transform duration-500
                    "
                >

                <div class="absolute bottom-4 left-4">
                    <h3 class="text-white font-bold drop-shadow-md
                        {{ $index === 1 ? 'text-3xl' : 'text-lg' }}">
                        {{ $category->name }}
                    </h3>
                </div>
            </a>

        @empty
            <p class="col-span-full text-center text-light">
                No categories available
            </p>
        @endforelse

    </div>
</div>



  </section>

  <!-- Recently Added -->
  <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-end mb-12">
        <div>
          <h2 class="text-3xl font-bold text-dark mb-4">Recently Added</h2>
          <p class="text-light text-sm max-w-xl">Not thoughts all exercise blessing. Indulgence way everything joy
            alteration boisterous the attachment.</p>
        </div>
        <div class="flex gap-4">
          <button
            class="w-12 h-12 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7" />
            </svg>
          </button>
          <button
            class="w-12 h-12 rounded-full bg-[#8BC34A] text-white shadow-lg flex items-center justify-center hover:bg-[#7cb342] transition-colors focus:ring-4 focus:ring-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($recentProducts as $product)
            <!-- Product Card 1 -->
            <div
              class="bg-white rounded-[20px] p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 group">
              <div class="h-56 flex items-center justify-center mb-8 relative overflow-hidden">
                <img src="{{ asset('storage/' . $product->main_image)}}" alt="{{ $product->name }}"
                  class="h-40 object-contain group-hover:scale-110 transition-transform duration-300">
              </div>
              <h3 class="font-bold text-lg text-dark mb-2 group-hover:text-[#8BC34A] transition-colors leading-tight">{{ $product->name }}</h3>
              <p class="font-bold text-dark text-xl mb-6">₹{{ number_format($product->selling_price, 2) }}</p>
              <div class="flex gap-4">
                <button
                  class="flex-1 bg-[#8BC34A] text-white font-bold text-[11px] py-3.5 px-4 rounded-[4px] uppercase tracking-wide hover:bg-[#7cb342] transition-colors shadow-sm">Add
                  to Cart</button>
                <button
                  class="flex-1 bg-[#F4B400] text-white font-bold text-[11px] py-3.5 px-4 rounded-[4px] uppercase tracking-wide hover:bg-[#f57f17] transition-colors shadow-sm">Buy
                  Now</button>
              </div>
            </div>

          @empty
            <p class="col-span-full text-center text-light">
                No products available
            </p>
        @endforelse

      </div>
    </div>

  </section>



  <!-- Newsletter -->
  <section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div
        class="bg-[#E0E0E0]/50 rounded-[30px] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12 relative overflow-hidden">

        <div class="md:w-1/2 z-10">
          <h2 class="text-3xl font-bold text-dark mb-4">Subscribe our newsletter</h2>
          <p class="text-light mb-8 max-w-md">Reciev latest news, update, and many other things every week.</p>
          <form class="relative max-w-md">
            <input type="email" placeholder="Enter Your email address"
              class="w-full bg-white text-dark py-4 pl-6 pr-16 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-[#8BC34A] shadow-sm text-sm" />
            <button type="button"
              class="absolute right-2 top-2 bg-[#8BC34A] hover:bg-[#7cb342] text-white w-10 h-10 rounded-[10px] flex items-center justify-center transition-colors shadow-md">
              <svg class="w-4 h-4 transform -rotate-45 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
              </svg>
            </button>
          </form>
        </div>

        <!-- Decorative Image Collage -->
        <div class="md:w-1/2 relative">
          <img src="{{ asset('assets/frontend/image/subscripation-img.png')}}" class="" alt="Gadgets">
        </div>

      </div>
    </div>
  </section>

@endsection  

@section('js-section')
{{-- //js section --}}
@endsection
