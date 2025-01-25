@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Task Management</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">Create New Task</a>

    <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
        <label for="project" class="form-label">Filter by Project:</label>
        <select name="project_id" id="project" class="form-select" onchange="this.form.submit()">
            <option value="">All Projects</option>
            @foreach ($projects as $project)
            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
            @endforeach
        </select>
    </form>

    <div class="row">
        <!-- To Do Column -->
        <div class="col-md-4">
            <h3 class="text-center">To Do</h3>
            <div class="card shadow-sm">
                <div class="card-body" id="todo-list">
                    @foreach ($tasks->where('status', 'todo') as $task)
                    <div class="task-card mb-2 p-3 border rounded" data-task-id="{{ $task->id }}" data-status="todo" style="cursor: grab;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="priority-circle"
                                style="background-color: {{ $task->priority == 1 ? 'red' : ($task->priority == 2 ? 'yellow' : 'green') }};
                                    width: 12px; height: 12px; border-radius: 50%;">
                            </span>

                            <strong>{{ $task->name }}</strong>
                            <div>
                                <!-- Edit Icon -->
                                <a href="#" class="text-primary mr-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                    onclick="editTask({{ $task }})">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Icon (with SweetAlert confirmation) -->
                                <a href="#" class="text-danger" title="Delete" onclick="confirmDelete({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <small>Project: {{ $task->project->name ?? 'None' }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="col-md-4">
            <h3 class="text-center">In Progress</h3>
            <div class="card shadow-sm">
                <div class="card-body" id="in-progress-list">
                    @foreach ($tasks->where('status', 'in_progress') as $task)
                    <div class="task-card mb-2 p-3 border rounded" data-task-id="{{ $task->id }}" data-status="in_progress" style="cursor: grab;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="priority-circle"
                                style="background-color: {{ $task->priority == 1 ? 'red' : ($task->priority == 2 ? 'yellow' : 'green') }};
                                    width: 12px; height: 12px; border-radius: 50%;">
                            </span>
                            <strong>{{ $task->name }}</strong>
                            <div>
                                <!-- Edit Icon -->
                                <a href="#" class="text-primary mr-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                    onclick="editTask({{ $task }})">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Icon (with SweetAlert confirmation) -->
                                <a href="#" class="text-danger" title="Delete" onclick="confirmDelete({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <small>Project: {{ $task->project->name ?? 'None' }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Done Column -->
        <div class="col-md-4">
            <h3 class="text-center">Done</h3>
            <div class="card shadow-sm">
                <div class="card-body" id="done-list">
                    @foreach ($tasks->where('status', 'done') as $task)
                    <div class="task-card mb-2 p-3 border rounded" data-task-id="{{ $task->id }}" data-status="done" style="cursor: grab;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="priority-circle"
                                style="background-color: {{ $task->priority == 1 ? 'red' : ($task->priority == 2 ? 'yellow' : 'green') }};
                                    width: 12px; height: 12px; border-radius: 50%;">
                            </span>
                            <strong>{{ $task->name }}</strong>
                            <div>
                                <!-- Edit Icon -->
                                <a href="#" class="text-primary mr-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                    onclick="editTask({{ $task }})">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Icon (with SweetAlert confirmation) -->
                                <a href="#" class="text-danger" title="Delete" onclick="confirmDelete({{ $task->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <small>Project: {{ $task->project->name ?? 'None' }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTaskForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="taskName" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="taskName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskPriority" class="form-label">Priority</label>
                        <select class="form-select" id="taskPriority" name="priority" required>
                            <option value="1">High</option>
                            <option value="2">Medium</option>
                            <option value="3">Low</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taskProject" class="form-label">Project</label>
                        <select class="form-select" id="taskProject" name="project_id" required>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize sortable lists for tasks (drag and drop)
    const todoList = document.getElementById('todo-list');
    const inProgressList = document.getElementById('in-progress-list');
    const doneList = document.getElementById('done-list');

    const initializeSortable = (list) => {
        new Sortable(list, {
            group: 'shared',
            animation: 150,
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.id.replace('-list', '');
                updateTaskStatus(taskId, newStatus);
            }
        });
    };

    initializeSortable(todoList);
    initializeSortable(inProgressList);
    initializeSortable(doneList);

    function updateTaskStatus(taskId, newStatus) {
        fetch('{{ route("tasks.updateStatus") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                task_id: taskId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Status updated successfully:', data);
        })
        .catch(error => {
            console.error('Error updating status:', error);
        });
    }
    function editTask(task) {
        const form = document.getElementById('editTaskForm');
        form.action = `/tasks/${task.id}`;

        document.getElementById('taskName').value = task.name;
        document.getElementById('taskPriority').value = task.priority;
        document.getElementById('taskProject').value = task.project_id;
    }


    function confirmDelete(taskId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send a DELETE request
            const form = document.createElement('form');
            form.action = `/tasks/${taskId}`;
            form.method = 'POST';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = "{{ csrf_token() }}";

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            form.appendChild(csrfInput);
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

</script>
@endsection
