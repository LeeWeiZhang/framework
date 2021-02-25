@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::system.edit') }} {{ __('avored::system.menu-group') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
            {{ __('avored::system.edit') }} {{ __('avored::system.menu-group') }}
        </div>
    </div>
@endsection

@section('content')
<div class="flex items-center">
    <div class="w-full menu-save-page block">
        <form method="post" action="{{ route('admin.menu-group.update', $menuGroup->id) }}">
            @csrf
            @method('put')
            @include('avored::cms.menu-group._fields')

            <div class="mt-3 py-3">
                <button type="submit"
                    class="px-6 py-3 font-semibold leading-7  text-white hover:text-white bg-red-600 rounded hover:bg-red-700"
                >   
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline-flex w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/>
                    </svg>
                    <span class="ml-3">{{ __('avored::system.save') }}</span>
                </button>
                
                <a href="{{ route('admin.menu-group.index') }}"
                    class="px-6 py-3 font-semibold inline-block text-white leading-7 hover:text-white bg-gray-500 rounded hover:bg-gray-600">
                    <span class="leading-7">
                        {{ __('avored::system.cancel') }}
                    </span>
                </a>
            </div>
        </form>
    </div>
   
</div>
@endsection

@push('bottom-scripts')

<script>
    function avoredTable(filterText = '') {
        return {
            columns: {
                id: true,
                name: true,
                type: true,
                sort_order: true,
                
            },
            filterText: filterText,
            filterBtnClicked: false,
            toggleHiddenColumn(name) {
                this.columns[name] = !this.columns[name]
            },
            filterData(url, e) {
                this.filterText = e.target.value
                const params = new URLSearchParams({
                    filter: e.target.value
                })
                
                location.href = url + '?' + params.toString()
            }
        }
    }
</script>
@endpush
