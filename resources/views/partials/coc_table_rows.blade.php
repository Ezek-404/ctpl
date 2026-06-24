@forelse($cocs as $coc)
    <tr class="hover:bg-zinc-900/20 transition-colors">
        <td class="px-6 py-2 text-xs font-medium text-zinc-500">{{ $coc->coc_id }}</td>
        <td class="px-6 py-2 text-xs font-medium font-bold text-zinc-200 tracking-wide">{{ $coc->coc_no }}</td>
        <td class="px-6 py-2 text-xs font-medium font-semibold text-zinc-400">{{ $coc->coc_type }}</td>
        <td class="px-6 py-2 text-xs font-medium">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold tracking-wider uppercase {{ $coc->coc_status === 'Used' ? 'bg-emerald-950/40 text-emerald-400 border border-emerald-500/20' : 'bg-zinc-900 text-zinc-400 border border-zinc-700/30' }}">
                {{ $coc->coc_status }}
            </span>
        </td>
        <td class="px-6 py-2 text-xs font-medium text-zinc-400">{{ $coc->created_at }}</td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-8 text-center text-xs text-zinc-500 uppercase tracking-widest">
            No Certificate Logs Found in Database Registry
        </td>
    </tr>
@endforelse