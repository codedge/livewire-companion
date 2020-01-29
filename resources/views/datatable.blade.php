<div>
    <div class="flex justify-end mb-10">
        <input wire:model="searchTerm" class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
               id="username" type="text" placeholder="Search...">
    </div>
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th class="px-4 py-2">
                <a wire:click.prevent="sortBy('name')" role="button" href="#">Name</a>
                @include('vendor/livewire-companion/_sort-icon', ['field' => 'name'])
            </th>
            <th class="px-4 py-2">
                <a wire:click.prevent="sortBy('cca2')" role="button" href="#">Country Code</a>
                @include('vendor/livewire-companion/_sort-icon', ['field' => 'cca2'])
            </th>
            <th class="px-4 py-2">
                <a wire:click.prevent="sortBy('area')" role="button" href="#">Area</a>
                @include('vendor/livewire-companion/_sort-icon', ['field' => 'area'])
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item['name']['common'] }}</td>
                <td class="border px-4 py-2">{{ $item['cca2'] }}</td>
                <td class="border px-4 py-2">{{ $item['area'] ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="flex justify-end mt-4">
        <div class="w-1/2">
            {{ $items->links() }}
        </div>
        <div class="w-1/2 text-right">
            Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} out of {{ $items->total() }} results
        </div>
    </div>
</div>
