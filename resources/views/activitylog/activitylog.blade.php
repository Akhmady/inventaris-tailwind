@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-100 mb-6">Activity Log</h1>

        <div class="bg-gray-800 shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700 text-gray-300 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Waktu</th>
                        <th class="px-6 py-3 text-left">Admin</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                        <th class="px-6 py-3 text-left">Entitas</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-gray-200">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4 text-sm">
                                {{ $log->created_at->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $log->user?->name ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4 text-sm capitalize">
                                {{ $log->action }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $log->entity }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $log->description }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-6">
                                Tidak ada aktivitas tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
