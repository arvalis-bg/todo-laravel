@extends('layouts.app')

@section('content')
<h1>Create Todo</h1>

<form action="{{ route('todos.store') }}" method="POST">
    @csrf
    <label>Title:</label>
    <input type="text" name="title" required><br><br>

    <label>Category ID:</label>
    <input type="number" name="category_id"><br><br>

    <label>Priority:</label>
    <select name="priority">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select><br><br>

    <button type="submit">Create</button>
</form>

<a href="{{ route('todos.index') }}">Back to list</a>
@endsection
