@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="d-flex my-3 align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
        </ol>
    </nav>
</div>

<table >
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Logo</th>
            <th>Favicon</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($settings as $index => $setting)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $setting->name }}</td>
                <td>{{ $setting->phone }}</td>
                <td>{{ $setting->email }}</td>
                <td>{{ $setting->address }}</td>
                <td>
                    @if($setting->logo)
                        <img src="{{ asset($setting->logo) }}" alt="{{ $setting->name }}" width="70" height="70"
                            class="rounded border me-2">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>
                    @if($setting->favicon)
                        <img src="{{ asset($setting->favicon) }}" alt="{{ $setting->name }}" width="70" height="70"
                            class="rounded border me-2">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>

                    <a href="{{ route('settings.edit', $setting->id) }}"
                        class="btn btn-sm btn-primary">
                        Edit
                    </a>



                </td>

            </tr>
        @endforeach

    </tbody>
</table>

<hr>

<table id="commonTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>value</th>
           
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($osinfo as $index => $info)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $info->type }}</td>
                <td>{{ $info->value }}</td>
               
               
                
                <td>

                    <a href="{{ route('settings.edit', $setting->id) }}"
                        class="btn btn-sm btn-primary">
                        Edit
                    </a>



                </td>

            </tr>
        @endforeach

    </tbody>
</table>



@endsection
