@forelse($transactions as $tx)
<tr>
    <td class="px-6 py-4 text-[10px] font-bold">{{ $tx->unique_tx_id }}</td>
    <td class="px-6 py-4 text-[10px]">{{ $tx->assured }}</td>
    <td class="px-6 py-4 text-[10px]">{{ $tx->plate_no }}</td>
    <td class="px-6 py-4 text-[10px]">{{ $tx->coc_no }}</td>
    <td class="px-6 py-4 text-[10px]">{{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y') }}</td>
    <td class="px-6 py-4 text-right">
        <a href="{{ route('ctpl.print', ['id' => $tx->unique_tx_id]) }}" class="text-emerald-500 hover:text-emerald-300 text-[10px] font-bold uppercase">View</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-10 text-center text-[10px] text-zinc-600 uppercase font-bold tracking-widest">No transactions found</td>
</tr>
@endforelse

@if($transactions->hasPages())
<tr>
    <td colspan="6" class="px-6 py-4 bg-zinc-950/40 border-t border-zinc-900/60">
        <div class="custom-pagination">
            {{ $transactions->links() }}
        </div>
    </td>
</tr>
@endif