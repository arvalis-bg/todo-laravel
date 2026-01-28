@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Create Todo</h2>

    <form method="POST" action="{{ route('todos.store') }}">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input
                type="text"
                name="title"
                class="form-control"
                required
            >
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $category->name === 'Other' ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Priority --}}
        <div class="mb-3">
            <label class="form-label">Priority</label>
            <select name="priority_id" class="form-select">
                @foreach($priorities as $priority)
                    <option value="{{ $priority->id }}"
                        {{ $priority->name === 'Medium' ? 'selected' : '' }}>
                        {{ $priority->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">
                Back
            </a>

            <button type="submit" class="btn btn-success">
                Create Todo
            </button>
        </div>

    </form>

</div>
@endsection
