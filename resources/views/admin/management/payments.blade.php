<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Pagos') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Control de cobros y métodos de pago') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pagos pendientes') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($pendingPaymentsCount) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pagos completados') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($paidPaymentsCount) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm sm:col-span-2"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Monto cobrado') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">${{ number_format($totalPaidAmount, 2) }}</p></div>
            </div>

            <form method="GET" class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 grid grid-cols-1 md:grid-cols-7 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar pago/cliente/pedido" class="md:col-span-2 rounded-xl border-[color:var(--cream-dark)] text-sm">
                <select name="status" class="rounded-xl border-[color:var(--cream-dark)] text-sm"><option value="">{{ __('Estado: Todos') }}</option>@foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
                <select name="payment_method" class="rounded-xl border-[color:var(--cream-dark)] text-sm"><option value="">{{ __('Método: Todos') }}</option>@foreach ($methods as $method)<option value="{{ $method }}" @selected(request('payment_method') === $method)>{{ ucfirst($method) }}</option>@endforeach</select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" step="0.01" name="min_amount" value="{{ request('min_amount') }}" placeholder="Min $" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                    <input type="number" step="0.01" name="max_amount" value="{{ request('max_amount') }}" placeholder="Max $" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                </div>
                <div class="md:col-span-7 flex items-center gap-2">
                    <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Filtrar') }}</button>
                    <a href="{{ route('admin.payments.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                    <a href="{{ route('admin.payments.export', request()->query()) }}" class="rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
                </div>
            </form>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Métodos de pago') }}</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                    @forelse ($methodBreakdown as $method)
                        <div class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3">
                            <p class="text-sm font-semibold text-[color:var(--ink)]">{{ ucfirst((string) $method->payment_method) }}</p>
                            <p class="mt-1 text-xs text-[color:var(--ink-muted)]">{{ __('Transacciones') }}: {{ number_format((int) $method->total) }}</p>
                            <p class="mt-1 text-xs text-[color:var(--ink-muted)]">{{ __('Total') }}: ${{ number_format((float) $method->amount_total, 2) }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-[color:var(--ink-muted)]">{{ __('Sin datos todavía.') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                        <thead class="bg-[color:var(--cream)]">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pago') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedido') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cliente') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Método') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Estado') }}</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Monto') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--cream-dark)]">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-[color:var(--cream)] transition">
                                    <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">#{{ $payment->id }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">#{{ $payment->order_id }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $payment->order?->user?->name ?? __('Sin cliente') }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ ucfirst((string) $payment->payment_method) }}</td>
                                    <td class="px-5 py-4">@if ($payment->status === 'paid')<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--success-bg); color: var(--success-text);">{{ __('Pagado') }}</span>@elseif ($payment->status === 'pending')<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--warning-bg); color: var(--warning-text);">{{ __('Pendiente') }}</span>@else<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--danger-bg); color: var(--danger-text);">{{ ucfirst((string) $payment->status) }}</span>@endif</td>
                                    <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">${{ number_format((float) $payment->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('No hay pagos para mostrar.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">{{ $payments->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
