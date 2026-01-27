@extends('layouts.app')

@section('content')
<h1>Todo Stats</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Category</th>
            <th>Total Todos</th>
            <th>Completed</th>
            <th>Incomplete</th>
        </tr>
    </thead>
    <tbody>
    @foreach($stats as $stat)
        <tr>
            <td>{{ $stat['category'] }}</td>
            <td>{{ $stat['total'] }}</td>
            <td>{{ $stat['completed'] }}</td>
            <td>{{ $stat['incomplete'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<a href="{{ route('todos.index') }}">Back to list</a>
@endsection