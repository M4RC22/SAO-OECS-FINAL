<!-- Card Holder -->
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-14 p-8 sm:pt-0 bg-gray-100">

    <!-- Card Body -->
    <div class="w-full max-w-sm mt-6 bg-white shadow-md overflow-hidden sm:rounded-sm">

        <!-- Top -->
        <div class="flex flex-col space-y-6 justify-center items-center py-6 bg-primary-yellow">
            <div class="w-28 h-28">
                {{ $logo }}
            </div>
            <h1 class="text-lg text-center text-slate-700 font-bold">Student Activities Office's
                <br> Online Events Creation System </h1>
        </div>

        <!-- Bottom -->
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

    </div>

</div>
