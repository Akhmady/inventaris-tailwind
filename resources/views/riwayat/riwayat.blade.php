@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Riwayat</h1>
            <div class="flex flex-row justify-between">


            </div>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg shadow overflow-hidden mt-4">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-start text-xs font-semibold text-gray-700 dark:text-gray-200">Admin
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Aksi
                                yang Dilakukan
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Keterangan Aksi
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Kode
                                Waktu Aksi
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Aksi
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr
                            class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                LoREM
                            </td>
                        </tr>
                        <tr
                            class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                LoREM
                            </td>
                        </tr>
                        <tr
                            class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                Lorem Lorem
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                LoREM
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">

            </div>
        </div>
    @endsection
