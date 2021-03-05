@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::system.create') . ' ' . __('avored::system.admin-user') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    <div class="text-gray-800 flex items-center">
        <div class="text-xl text-red-700 font-semibold">
            {{ __('avored::system.create') . ' ' . __('avored::system.admin-user') }}
        </div>
    </div>
@endsection

@section('content')
<div class="flex items-center">
    <admin-user-save base-url="{{ asset(config('avored.admin_url')) }}" inline-template>
        <div class="w-full block">
            <form 
                method="post"
                action="{{ route('admin.admin-user.store') }}">
                @csrf

                <avored-tabs>
                    @foreach ($tabs as $tab)
                        <avored-tab identifier="{{ $tab->key() }}" name="{{ $tab->label() }}">
                            @php
                                $path = $tab->view();
                            @endphp
                            @include($path)
                        </avored-tab>
                    @endforeach
                </avored-tabs>
                
                <div class="mt-3 py-3">
                    @include('avored::partials.forms.action-buttons', ['url' => route('admin.admin-user.index')])
                </div>
            </form>
        </div>
    </language-save>
</div>
@endsection
