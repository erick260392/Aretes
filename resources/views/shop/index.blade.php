<x-layouts::shop :title="__('Tienda')">
    @php
        $heroProduct = $products->first();
    @endphp

    <div class="mx-[-1rem] space-y-0 sm:mx-[-1.5rem] lg:mx-[-2rem]">
        <section class="grid min-h-[88vh] overflow-hidden bg-[color:var(--cream)] lg:grid-cols-[1.05fr_0.95fr]">
            <div class="relative flex items-center px-6 py-16 sm:px-10 lg:px-16 xl:px-20">
                <span class="shop-spin-soft absolute left-6 top-8 text-xl text-[color:rgba(201,168,76,0.38)] sm:left-10 lg:left-14">✦</span>

                <div class="max-w-2xl">
                    <p class="text-[11px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">
                        {{ __('Coleccion primavera atelier') }}
                    </p>

                    <h1 class="mt-6 shop-page-title sm:!text-6xl xl:!text-7xl">
                        {{ __('Joyeria que') }}<br>
                        <span class="italic text-[color:var(--gold)]">{{ __('cuenta') }}</span><br>
                        {{ __('tu historia') }}
                    </h1>

                    <p class="shop-copy mt-6 max-w-lg text-base">
                        {{ __('Aretes artesanales pensados para mujeres que quieren llevar delicadeza, carácter y calidez en una sola pieza. Una tienda editorial, femenina y comprable, más cercana al mockup que imaginaste.') }}
                    </p>

                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="#productos"
                            class="inline-flex items-center justify-center rounded-full border border-[color:var(--espresso)] bg-[color:var(--espresso)] px-8 py-3.5 text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--cream)] transition hover:border-[color:var(--gold)] hover:bg-[color:var(--gold)]">
                            {{ __('Explorar coleccion') }}
                        </a>
                        <a href="#historia"
                            class="inline-flex items-center gap-2 rounded-full border border-[color:rgba(201,168,76,0.18)] bg-[color:rgba(255,253,249,0.76)] px-6 py-3.5 text-[11px] font-medium uppercase tracking-[0.22em] text-[color:var(--ink-muted)] transition hover:border-[color:var(--gold)] hover:text-[color:var(--gold)]">
                            {{ __('Conocer a Mich') }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <div class="mt-12 grid max-w-2xl gap-5 border-t border-[color:rgba(201,168,76,0.22)] pt-6 sm:grid-cols-3">
                        <div>
                            <p class="font-editorial text-4xl font-semibold text-[color:var(--gold)]">{{ $shopStats['products'] }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[color:var(--ink-faint)]">{{ __('Disenos activos') }}</p>
                        </div>
                        <div>
                            <p class="font-editorial text-4xl font-semibold text-[color:var(--gold)]">{{ $shopStats['categories'] }}</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[color:var(--ink-faint)]">{{ __('Colecciones') }}</p>
                        </div>
                        <div>
                            <p class="font-editorial text-4xl font-semibold text-[color:var(--gold)]">100%</p>
                            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[color:var(--ink-faint)]">{{ __('Hecho con detalle') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative isolate flex min-h-[520px] items-center justify-center overflow-hidden bg-[linear-gradient(135deg,#e8d5b0_0%,#d4a5a0_48%,#c9a96e_100%)] px-6 py-14 sm:px-10 lg:px-12">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_72%_24%,rgba(255,255,255,0.34),transparent_18%),radial-gradient(circle_at_24%_76%,rgba(255,255,255,0.24),transparent_20%)]"></div>
                <div class="absolute inset-0 bg-[url('/images/logo_aretes_mich_1.svg')] bg-center bg-no-repeat opacity-[0.06]"></div>

                <div class="shop-float relative z-10 w-full max-w-[330px] border border-[color:rgba(255,255,255,0.42)] bg-[color:rgba(255,255,255,0.18)] p-6 text-center shadow-[0_30px_70px_rgba(44,24,16,0.18)] backdrop-blur-xl sm:p-8">
                    <div class="flex min-h-[360px] flex-col items-center justify-center rounded-[1.5rem] border border-[color:rgba(255,255,255,0.28)] bg-[color:rgba(255,255,255,0.16)] px-6 py-10">
                        @if ($heroProduct && $heroProduct->images->isNotEmpty())
                            @php
                                $heroImage = $heroProduct->images->first();
                                $heroImageUrl = \Illuminate\Support\Str::startsWith($heroImage->url, ['http://', 'https://', '/'])
                                    ? $heroImage->url
                                    : asset($heroImage->url);
                            @endphp
                            <img src="{{ $heroImageUrl }}" alt="{{ $heroProduct->name }}" class="max-h-56 w-auto object-contain drop-shadow-[0_12px_30px_rgba(44,24,16,0.2)]">
                        @else
                            <span class="text-7xl drop-shadow-[0_14px_30px_rgba(44,24,16,0.22)]">💎</span>
                        @endif

                        <p class="mt-6 font-editorial text-3xl font-light text-[color:var(--espresso)]">
                            {{ $heroProduct?->name ?? __('Aretes Perla Rosa') }}
                        </p>
                        <p class="mt-2 text-[11px] uppercase tracking-[0.24em] text-[color:rgba(44,24,16,0.72)]">
                            {{ $heroProduct?->category?->name ?? __('Edicion artesanal') }}
                        </p>
                        <span class="mt-5 inline-flex items-center bg-[color:var(--espresso)] px-4 py-2 text-xs uppercase tracking-[0.18em] text-[color:var(--gold-light)]">
                            {{ $heroProduct ? '$'.number_format((float) $heroProduct->price, 2).' MXN' : __('Desde $299 MXN') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden bg-[color:var(--espresso)] py-3 text-[color:var(--gold-light)]">
            <div class="shop-marquee-track whitespace-nowrap text-[10px] font-medium uppercase tracking-[0.35em]">
                <span class="mr-12 inline-block">{{ __('Envio gratis arriba de $500') }}</span>
                <span class="mr-12 inline-block">{{ __('Aretes artesanales') }}</span>
                <span class="mr-12 inline-block">{{ __('Materiales de calidad') }}</span>
                <span class="mr-12 inline-block">{{ __('Nuevas colecciones cada mes') }}</span>
                <span class="mr-12 inline-block">{{ __('Piezas ligeras y delicadas') }}</span>
                <span class="mr-12 inline-block">{{ __('Envio gratis arriba de $500') }}</span>
                <span class="mr-12 inline-block">{{ __('Aretes artesanales') }}</span>
                <span class="mr-12 inline-block">{{ __('Materiales de calidad') }}</span>
                <span class="mr-12 inline-block">{{ __('Nuevas colecciones cada mes') }}</span>
                <span class="mr-12 inline-block">{{ __('Piezas ligeras y delicadas') }}</span>
            </div>
        </section>

        <section id="categorias" class="bg-[color:var(--cream)] px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">{{ __('Explora') }}</p>
                        <h2 class="mt-3 shop-section-title sm:!text-5xl">
                            {{ __('Nuestras colecciones') }}
                        </h2>
                    </div>
                    <p class="max-w-lg text-sm leading-7 text-[color:var(--ink-muted)]">
                        {{ __('Más contraste, mejor respiración y tarjetas con presencia. Cada categoría funciona ahora como un bloque visual, no como una caja vacía.') }}
                    </p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    @forelse ($categories as $index => $category)
                        @php
                            $categoryBackgrounds = [
                                'bg-[linear-gradient(135deg,#E8D5B0,#D4A5A0)]',
                                'bg-[linear-gradient(135deg,#C9A96E,#9A7A4A)]',
                                'bg-[linear-gradient(135deg,#F7E0DE,#D4A5A0)]',
                                'bg-[linear-gradient(135deg,#2C1810,#4A2C1A)]',
                            ];
                            $categoryIcons = ['💛', '🤍', '💗', '✨'];
                        @endphp
                        <article class="group relative overflow-hidden rounded-[1.9rem]">
                            <div class="{{ $categoryBackgrounds[$index % count($categoryBackgrounds)] }} flex h-[340px] items-end justify-start p-6 transition duration-500 group-hover:scale-[1.03]">
                                <span class="absolute inset-0 flex items-center justify-center text-7xl opacity-70">{{ $categoryIcons[$index % count($categoryIcons)] }}</span>
                                <div class="absolute inset-0 bg-[linear-gradient(180deg,transparent,rgba(44,24,16,0.74))]"></div>
                                <div class="relative z-10">
                                    <p class="font-editorial text-3xl font-light text-white">{{ $category->name }}</p>
                                    <p class="mt-2 text-[11px] uppercase tracking-[0.24em] text-[color:rgba(255,255,255,0.8)]">
                                        {{ trans_choice('{0} Sin productos|{1} :count diseño|[2,*] :count diseños', $category->products_count, ['count' => $category->products_count]) }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-[1.75rem] border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-8 py-12 text-center text-sm text-[color:var(--ink-muted)]">
                            {{ __('Aun no hay categorias disponibles.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="productos" class="bg-white px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">{{ __('Lo mas nuevo') }}</p>
                        <h2 class="mt-3 shop-section-title sm:!text-5xl">
                            {{ __('Destacados') }}
                        </h2>
                    </div>
                    <a href="{{ route('shop') }}" class="text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--gold-dark)] transition hover:text-[color:var(--gold)]">
                        {{ __('Ver catalogo completo') }}
                    </a>
                </div>

                <div class="mt-12 grid gap-10 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($products as $index => $product)
                        @php
                            $productPhotoBackgrounds = [
                                'bg-[linear-gradient(135deg,#FAF6F0,#E8D5B0)]',
                                'bg-[linear-gradient(135deg,#F5F0EA,#D4C4A8)]',
                                'bg-[linear-gradient(135deg,#FDF0EE,#E8C4C0)]',
                            ];
                            $productImage = $product->images->first();
                            $productImageUrl = $productImage
                                ? (\Illuminate\Support\Str::startsWith($productImage->url, ['http://', 'https://', '/']) ? $productImage->url : asset($productImage->url))
                                : null;
                        @endphp
                        <article class="shop-card-product group p-4">
                            <div class="relative overflow-hidden rounded-[1.65rem]">
                                <a href="{{ route('shop.products.show', $product) }}" class="block">
                                    <div class="{{ $productPhotoBackgrounds[$index % count($productPhotoBackgrounds)] }} relative flex h-[390px] items-center justify-center overflow-hidden transition duration-500 group-hover:scale-[1.02]">
                                        <div class="absolute inset-0 bg-[url('/images/logo_aretes_mich_1.svg')] bg-center bg-no-repeat opacity-[0.05]"></div>
                                        @if ($productImageUrl)
                                            <img src="{{ $productImageUrl }}" alt="{{ $product->name }}" class="relative z-10 max-h-72 w-auto object-contain drop-shadow-[0_18px_34px_rgba(44,24,16,0.16)]">
                                        @else
                                            <div class="relative z-10 flex h-44 w-44 items-center justify-center rounded-full border border-[color:rgba(44,24,16,0.08)] bg-[color:rgba(255,255,255,0.42)] shadow-[0_18px_40px_rgba(44,24,16,0.12)]">
                                                <span class="text-7xl">{{ ['💎', '🌸', '⭐'][$index % 3] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <span class="absolute left-4 top-4 inline-flex items-center rounded-full px-3 py-1.5 text-[10px] font-medium uppercase tracking-[0.18em] text-white {{ $index % 3 === 2 ? 'bg-[color:var(--rose)]' : 'bg-[color:var(--gold)]' }}">
                                    {{ $index % 3 === 0 ? __('Nuevo') : ($index % 3 === 2 ? __('Popular') : __('Boutique')) }}
                                </span>

                                <div class="pointer-events-none absolute inset-x-0 bottom-5 flex translate-y-4 justify-center gap-2 opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <form method="POST" action="{{ route('cart.items.store') }}" class="pointer-events-auto">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-full border border-[color:var(--espresso)] bg-[color:var(--espresso)] px-5 py-3 text-[10px] font-medium uppercase tracking-[0.22em] text-[color:var(--cream)] transition hover:border-[color:var(--gold)] hover:bg-[color:var(--gold)]"
                                            @disabled(!(bool) $product->stock)>
                                            {{ (bool) $product->stock ? __('Agregar al carrito') : __('Agotado') }}
                                        </button>
                                    </form>

                                    <a href="{{ route('shop.products.show', $product) }}"
                                        class="pointer-events-auto inline-flex items-center justify-center rounded-full border border-[color:var(--espresso)] bg-white px-4 py-3 text-sm text-[color:var(--espresso)] transition hover:border-[color:var(--gold)] hover:text-[color:var(--gold)]">
                                        ♡
                                    </a>
                                </div>
                            </div>

                            <div class="px-2 pb-3 pt-6">
                                <p class="text-[10px] font-medium uppercase tracking-[0.28em] text-[color:var(--gold)]">
                                    {{ $product->category?->name ?? __('Coleccion principal') }}
                                </p>
                                <h3 class="mt-2 font-editorial text-[1.9rem] font-normal leading-none text-[color:var(--espresso)]">
                                    {{ $product->name }}
                                </h3>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="text-lg font-medium text-[color:var(--gold-dark)]">${{ number_format((float) $product->price, 2) }} MXN</span>
                                    @if ($index % 3 === 0)
                                        <span class="text-sm text-[color:var(--ink-faint)] line-through">${{ number_format((float) $product->price * 1.2, 2) }} MXN</span>
                                    @endif
                                </div>
                                <p class="mt-4 text-sm leading-7 text-[color:var(--ink-muted)]">
                                    {{ \Illuminate\Support\Str::limit($product->description ?: __('Pieza ligera, femenina y pensada para elevar looks cotidianos con un gesto artesanal.'), 125) }}
                                </p>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-[1.75rem] border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-8 py-12 text-center text-sm text-[color:var(--ink-muted)]">
                            {{ __('No hay productos todavia.') }}
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </div>
        </section>

        <section class="bg-[color:var(--espresso)] px-4 py-0 sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-7xl overflow-hidden lg:grid-cols-2">
                <div class="px-6 py-16 sm:px-10 lg:px-14">
                    <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">{{ __('Oferta especial') }}</p>
                    <h2 class="mt-4 font-editorial text-5xl font-light leading-[0.96] text-[color:var(--cream)]">
                        {{ __('20% off en') }}<br>
                        {{ __('tu primera') }}<br>
                        <span class="italic text-[color:var(--gold)]">{{ __('compra') }}</span>
                    </h2>
                    <p class="mt-6 max-w-md text-sm leading-8 text-[color:rgba(250,246,240,0.62)]">
                        {{ __('Regístrate hoy y recibe una bienvenida con el tono íntimo y elegante del mockup: una experiencia de marca, no solo un listado de productos.') }}
                    </p>
                    <a href="{{ route('checkout.create') }}"
                        class="mt-8 inline-flex items-center justify-center rounded-full border border-[color:var(--gold)] bg-[color:var(--gold)] px-8 py-3.5 text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--espresso)] transition hover:bg-[color:var(--cream)]">
                        {{ __('Comprar con descuento') }}
                    </a>
                </div>

                <div class="relative flex min-h-[420px] items-center justify-center overflow-hidden bg-[linear-gradient(135deg,#4A2C1A,#6A3C2A)]">
                    <div class="absolute h-[300px] w-[300px] rounded-full border border-[color:rgba(201,169,110,0.2)]"></div>
                    <div class="absolute h-[460px] w-[460px] rounded-full border border-[color:rgba(201,169,110,0.1)]"></div>
                    <span class="relative z-10 text-8xl">💍</span>
                </div>
            </div>
        </section>

        <section id="historia" class="bg-[color:#f7f1e7] px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[0.95fr_1.05fr]">
                <div class="rounded-[2rem] bg-[linear-gradient(135deg,rgba(212,165,160,0.35),rgba(232,213,176,0.7))] p-6 shadow-[0_24px_60px_rgba(44,24,16,0.08)] sm:p-8">
                    <div class="flex h-full min-h-[420px] flex-col justify-between rounded-[1.6rem] border border-[color:rgba(255,255,255,0.5)] bg-[color:rgba(255,255,255,0.42)] p-8 backdrop-blur">
                        <img src="{{ asset('images/logo_aretes_mich_1.svg') }}" alt="Aretes Mich" class="h-14 w-auto opacity-80">
                        <div class="space-y-5">
                            <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold-dark)]">{{ __('Sobre Mich') }}</p>
                            <p class="font-editorial text-4xl font-light leading-tight text-[color:var(--espresso)]">
                                {{ __('Una marca nacida de la sensibilidad por los detalles.') }}
                            </p>
                            <p class="text-sm leading-8 text-[color:var(--ink-muted)]">
                                {{ __('Cada pieza busca sentirse cercana, femenina y especial. El objetivo no es solo vender aretes, sino acompañar momentos cotidianos con objetos que se sientan propios.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">{{ __('Historia de marca') }}</p>
                    <h2 class="mt-4 shop-section-title sm:!text-5xl">
                        {{ __('La historia detras de Mich') }}
                    </h2>
                    <div class="mt-8 space-y-6 text-sm leading-8 text-[color:var(--ink-muted)]">
                        <p>
                            {{ __('Mich nace del gusto por crear piezas con una elegancia suave: materiales luminosos, tonos cálidos y una composición delicada que eleva cualquier look sin sentirse exagerada.') }}
                        </p>
                        <p>
                            {{ __('La inspiración viene de lo artesanal y de lo íntimo. Por eso la tienda ahora incorpora una narrativa editorial, mejor respiración visual, bloques con contraste y una atmósfera más viva, como en tu mockup.') }}
                        </p>
                        <p>
                            {{ __('Queríamos que la web contara quién es Mich, qué emociones provoca la marca y cómo se conecta cada producto con esa identidad.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contacto" class="bg-white px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[10px] font-medium uppercase tracking-[0.35em] text-[color:var(--gold)]">{{ __('Contacto') }}</p>
                        <h2 class="mt-3 shop-section-title sm:!text-5xl">
                            {{ __('Hablemos de tu siguiente pieza') }}
                        </h2>
                    </div>
                    <p class="max-w-lg text-sm leading-7 text-[color:var(--ink-muted)]">
                        {{ __('Sumé el área de contacto que faltaba para que la tienda se sienta completa y más cercana a una marca real.') }}
                    </p>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        <div class="rounded-[1.75rem] border border-[color:var(--cream-dark)] bg-[color:var(--cream)] p-7">
                            <p class="text-[10px] font-medium uppercase tracking-[0.28em] text-[color:var(--gold)]">{{ __('Email') }}</p>
                            <p class="mt-4 font-editorial text-3xl font-light text-[color:var(--espresso)]">hola@aretesmich.mx</p>
                            <p class="mt-3 text-sm leading-7 text-[color:var(--ink-muted)]">{{ __('Escríbenos para pedidos especiales, mayoreo o colaboraciones.') }}</p>
                        </div>
                        <div class="rounded-[1.75rem] border border-[color:var(--cream-dark)] bg-[color:var(--cream)] p-7">
                            <p class="text-[10px] font-medium uppercase tracking-[0.28em] text-[color:var(--gold)]">{{ __('Instagram') }}</p>
                            <p class="mt-4 font-editorial text-3xl font-light text-[color:var(--espresso)]">@aretesmich</p>
                            <p class="mt-3 text-sm leading-7 text-[color:var(--ink-muted)]">{{ __('Contenido, lanzamientos y estilo visual de la marca en un solo lugar.') }}</p>
                        </div>
                        <div class="rounded-[1.75rem] border border-[color:var(--cream-dark)] bg-[color:var(--cream)] p-7 sm:col-span-2 xl:col-span-1">
                            <p class="text-[10px] font-medium uppercase tracking-[0.28em] text-[color:var(--gold)]">{{ __('WhatsApp') }}</p>
                            <p class="mt-4 font-editorial text-3xl font-light text-[color:var(--espresso)]">+52 222 000 0000</p>
                            <p class="mt-3 text-sm leading-7 text-[color:var(--ink-muted)]">{{ __('Atención directa para dudas de envío, stock y pedidos personalizados.') }}</p>
                        </div>
                    </div>

                    <div class="rounded-[2rem] bg-[linear-gradient(135deg,rgba(232,213,176,0.96),rgba(212,165,160,0.78))] p-8 shadow-[0_24px_60px_rgba(44,24,16,0.08)]">
                        <div class="rounded-[1.6rem] border border-[color:rgba(255,255,255,0.44)] bg-[color:rgba(255,255,255,0.32)] p-8 backdrop-blur">
                            <p class="text-[10px] font-medium uppercase tracking-[0.3em] text-[color:var(--gold-dark)]">{{ __('Atelier Mich') }}</p>
                            <h3 class="mt-4 font-editorial text-4xl font-light leading-tight text-[color:var(--espresso)]">
                                {{ __('Hecho a mano, con una sensibilidad suave y moderna.') }}
                            </h3>
                            <p class="mt-5 text-sm leading-8 text-[color:rgba(44,24,16,0.74)]">
                                {{ __('Aquí cerramos la experiencia con un bloque más emocional y con mejor contraste. La idea fue que la página ya no se sienta incompleta ni plana, sino editorial, femenina y más cercana al mockup original.') }}
                            </p>
                            <a href="{{ route('cart.index') }}"
                                class="mt-8 inline-flex items-center justify-center rounded-full border border-[color:var(--espresso)] bg-[color:var(--espresso)] px-7 py-3 text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--cream)] transition hover:border-[color:var(--gold)] hover:bg-[color:var(--gold)]">
                                {{ __('Ir al carrito') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts::shop>
