<!-- resources/views/layouts/footer.blade.php -->
<footer class="bg-stone-900 text-stone-300 mt-16 rounded-t-[40px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <!-- Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                    🍴 Tafello • reserveren
                </a>
            </div>

            <!-- Footer Links -->
            <div class="flex flex-wrap justify-center gap-x-8 gap-y-4">
                <a href="#" class="text-stone-400 hover:text-orange-500 transition-colors duration-200">
                    Over ons
                </a>
                <a href="#" class="text-stone-400 hover:text-orange-500 transition-colors duration-200">
                    Contact
                </a>
                <a href="#" class="text-stone-400 hover:text-orange-500 transition-colors duration-200">
                    Veelgestelde vragen
                </a>
                <a href="#" class="text-stone-400 hover:text-orange-500 transition-colors duration-200">
                    Privacy
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-10 pt-8 border-t border-stone-800 text-center">
            <p class="text-sm text-stone-500">
                © {{ date('Y') }} Tafello – Maak moeiteloos een tafelreservering. Alle rechten voorbehouden.
            </p>
        </div>
    </div>
</footer>