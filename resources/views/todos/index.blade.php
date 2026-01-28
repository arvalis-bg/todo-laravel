@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Todos</h2>

    <div class="mb-3">
        <a href="{{ route('todos.create') }}" class="btn btn-primary">Create New Todo</a>
        <a href="{{ route('todos.stats') }}" class="btn btn-secondary">View Stats</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Completed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($todos as $todo)
            <tr>
                <td>{{ $todo['title'] }}</td>
                <td>{{ $todo['category']['name'] ?? 'Other' }}</td>
                <td>{{ $todo['priority']['name'] ?? 'Medium' }}</td>
                <td>{{ $todo['completed'] ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('todos.edit', $todo['id']) }}" class="btn btn-sm btn-primary">Edit</a>

                    <form action="{{ route('todos.toggle', $todo['id']) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-secondary">
                            {{ $todo['completed'] ? 'Mark Incomplete' : 'Mark Complete' }}
                        </button>
                    </form>

                    <form action="{{ route('todos.destroy', $todo['id']) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this todo?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
