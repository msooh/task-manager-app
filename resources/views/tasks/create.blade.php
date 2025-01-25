@extends('layouts.app')

@section('content')
    <h1>{{ isset($task) ? 'Edit' : 'Create' }} Task</h1>

    <form action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}" method="POST">
        @csrf
        @if (isset($task))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Task Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $task->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select id="priority" name="priority" class="form-select" value="{{ old('priority', $task->priority ?? '') }}" required>                
                <option value="1"> High</option>
                <option value="2"> Medium</option>
                <option value="3"> Low</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="project_id" class="form-label">Select Project</label>
            <select name="project_id" id="project_id" class="form-select" required>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($task) ? 'Update' : 'Create' }} Task</button>
    </form>
@endsection
