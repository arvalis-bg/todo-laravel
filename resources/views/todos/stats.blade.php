@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Todo Stats</h2>

    <table class="table table-bordered">
        <thead class="table-light">
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

    <a href="{{ route('todos.index') }}" class="btn btn-secondary mt-3">Back to Todos</a>

</div>
@endsection
