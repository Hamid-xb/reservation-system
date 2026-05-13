<x-restaurant-layout
    :restaurant="$restaurant"
    active="gallery"
    header="Foto's"
    subheader="Beheer de galerij van {{ $restaurant->name }}"
>
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 px-5 py-4 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-8 rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Nieuwe galerijfoto toevoegen
        </h2>

        <form
            method="POST"
            action="{{ route('restaurant.gallery.store', $restaurant) }}"
            enctype="multipart/form-data"
            class="grid gap-5 md:grid-cols-[1fr_auto]"
        >
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-[#3e2c23]">
                    Foto
                </label>

                <input
                    type="file"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-full border border-[#f0e2d4] bg-[#fefaf5] px-5 py-3 focus:border-[#c53a1f] focus:ring-[#c53a1f]"
                    required
                >
            </div>

            <div class="flex items-end">
                <button
                    type="submit"
                    class="w-full rounded-full bg-[#c53a1f] px-5 py-3 font-semibold text-white transition hover:bg-[#9f2f17] md:w-auto"
                >
                    + Foto toevoegen
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-[28px] border border-[#f0e2d8] bg-white p-7 shadow-sm">
        <h2 class="mb-6 text-2xl font-bold text-[#2c1a12]">
            Galerij
        </h2>

        @if($images->isEmpty())
            <div class="py-12 text-center text-[#a48e7c]">
                Nog geen galerijfoto's toegevoegd.
            </div>
        @else
            <div
                id="gallery-grid"
                class="grid gap-6 md:grid-cols-2 xl:grid-cols-3"
                data-order-url="{{ route('restaurant.gallery.order', $restaurant) }}"
            >
                @foreach($images as $image)
                    <div
                        draggable="true"
                        data-image-id="{{ $image->id }}"
                        class="gallery-card cursor-move overflow-hidden rounded-[24px] border border-[#f0e2d8] bg-[#fffaf5] shadow-sm transition"
                    >
                        <img
                            src="{{ asset($image->image_url) }}"
                            alt="Galerijfoto {{ $loop->iteration }}"
                            class="h-56 w-full object-cover"
                        >

                        <div class="space-y-4 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-[#2c1a12]">
                                        Foto <span class="photo-number">{{ $loop->iteration }}</span>
                                    </p>

                                    <p class="text-sm text-[#a48e7c]">
                                        Sleep om volgorde te wijzigen
                                    </p>
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('restaurant.gallery.destroy', [$restaurant, $image]) }}"
                                    onsubmit="return confirm('Weet je zeker dat je deze foto wilt verwijderen?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-full bg-[#c53a1f] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#9f2f17]"
                                    >
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        const galleryGrid = document.getElementById('gallery-grid');
        let draggedCard = null;

        galleryGrid?.addEventListener('dragstart', (event) => {
            draggedCard = event.target.closest('.gallery-card');

            if (!draggedCard) {
                return;
            }

            draggedCard.classList.add('opacity-50');
        });

        galleryGrid?.addEventListener('dragend', () => {
            if (!draggedCard) {
                return;
            }

            draggedCard.classList.remove('opacity-50');
            draggedCard = null;

            updatePhotoNumbers();
            saveGalleryOrder();
        });

        galleryGrid?.addEventListener('dragover', (event) => {
            event.preventDefault();

            const targetCard = event.target.closest('.gallery-card');

            if (!targetCard || targetCard === draggedCard || !draggedCard) {
                return;
            }

            const cards = [...galleryGrid.querySelectorAll('.gallery-card')];
            const draggedIndex = cards.indexOf(draggedCard);
            const targetIndex = cards.indexOf(targetCard);

            if (draggedIndex < targetIndex) {
                galleryGrid.insertBefore(draggedCard, targetCard.nextSibling);
            } else {
                galleryGrid.insertBefore(draggedCard, targetCard);
            }
        });

        function updatePhotoNumbers() {
            galleryGrid?.querySelectorAll('.gallery-card').forEach((card, index) => {
                card.querySelector('.photo-number').textContent = index + 1;
            });
        }

        function saveGalleryOrder() {
            const images = [...galleryGrid.querySelectorAll('.gallery-card')]
                .map((card) => card.dataset.imageId);

            fetch(galleryGrid.dataset.orderUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ images }),
            });
        }
    </script>
</x-restaurant-layout>
