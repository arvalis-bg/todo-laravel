@extends('layouts.app')

@section('content')
<h1>Todos</h1>

<a href="{{ route('todos.create') }}">Create New Todo</a>
<a href="{{ route('todos.stats') }}">View Stats</a>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
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
            <td>{{ $todo['category']['name'] ?? '-' }}</td>
            <td>{{ $todo['priority'] }}</td>
            <td>{{ $todo['completed'] ? 'Yes' : 'No' }}</td>
            <td>
                <a href="{{ route('todos.edit', $todo['id']) }}">Edit</a>
                <form action="{{ route('todos.toggle', $todo['id']) }}" method="POST" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit">{{ $todo['completed'] ? 'Mark Incomplete' : 'Mark Complete' }}</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
