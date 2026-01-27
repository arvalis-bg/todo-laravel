@extends('layouts.app')

@section('content')
<h1>Edit Todo</h1>

<form action="{{ route('todos.update', $todo['id']) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Title:</label>
    <input type="text" name="title" value="{{ $todo['title'] }}" required><br><br>

    <label>Category ID:</label>
    <input type="number" name="category_id" value="{{ $todo['category_id'] }}"><br><br>

    <label>Priority:</label>
    <select name="priority">
        <option value="low" {{ $todo['priority'] === 'low' ? 'selected' : '' }}>Low</option>
        <option value="medium" {{ $todo['priority'] === 'medium' ? 'selected' : '' }}>Medium</option>
        <option value="high" {{ $todo['priority'] === 'high' ? 'selected' : '' }}>High</option>
    </select><br><br>

    <label>Completed:</label>
    <input type="checkbox" name="completed" value="1" {{ $todo['completed'] ? 'checked' : '' }}><br><br>

    <button type="submit">Update</button>
</form>

<a href="{{ route('todos.index') }}">Back to list</a>
@endsection