<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Modal Konfirmasi Hapus -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="statusToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i> Status berhasil diperbarui!
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus task ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="card shadow mb-4">
                    <div class="card-header  text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add New Task</h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="collapse" data-bs-target="#addTodoCollapse" aria-expanded="false" aria-controls="addTodoCollapse">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div id="addTodoCollapse" class="collapse">
                        <div class="card-body">
                            <form id="addTodoForm">
                                @csrf
                                <div class="row g-4">
                                    <!-- Title -->
                                    <div class="col-md-6">
                                        <label for="title" class="form-label fw-bold">Title</label>
                                        <input type="text" id="title" name="title" class="form-control border-primary" 
                                               placeholder="Enter task title" required>
                                    </div>
                    
                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <input type="text" id="description" name="description" 
                                               class="form-control border-primary" placeholder="Enter task description">
                                    </div>
                    
                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label fw-bold">Status</label>
                                        <select id="status" name="status" class="form-select border-primary" required>
                                            <option value="pending" selected>Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                    
                                    <!-- Priority -->
                                    <div class="col-md-4">
                                        <label for="priority" class="form-label fw-bold">Priority</label>
                                        <select id="priority" name="priority" class="form-select border-primary">
                                            <option value="low" selected>Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                    
                                    <!-- Due Date -->
                                    <div class="col-md-4">
                                        <label for="due_date" class="form-label fw-bold">Due Date</label>
                                        <input type="datetime-local" id="due_date" name="due_date" 
                                               class="form-control border-primary">
                                    </div>
                    
                                    <!-- Color -->
                                    <div class="col-md-4">
                                        <label for="color" class="form-label fw-bold">Color</label>
                                        <input type="color" id="color" name="color" 
                                               class="form-control form-control-color p-1" value="#fc9228">
                                    </div>
                    
                                    <!-- Submit Button -->
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary px-5 py-2 mt-3">
                                            <i class="bi bi-check-circle me-2"></i>Add Task
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- To-Do Zones -->
                <div class="row ">
                    <!-- Pending -->
                    <div class="col-md-4 pt-5">
                        <h6 class="text-center fw-bold mb-3 text-warning">Pending</h6>
                        <div class="card border-warning shadow p-9" id="pending" ondrop="drop(event)" ondragover="allowDrop(event)">
                            @foreach ($todos->where('status', 'pending') as $todo)
                            <div class="card mb-3 draggable text-white shadow-lg" 
                                 draggable="true" 
                                 ondragstart="drag(event)" 
                                 id="todo{{ $todo->id }}" 
                                 style="background: linear-gradient(135deg, {{ $todo->color }}, #000); border-radius: 12px;">
                                 <div class="card-hover">
                                    <div class="card-header text-center py-3" style="background: rgba(0, 0, 0, 0.7); border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                        <h5 class="fw-bold text-white">
                                            <i class="bi bi-card-text me-2"></i>{{ $todo->title }}
                                        </h5>
                                    </div>
                                    <div class="card-body  d-flex flex-column justify-content-between" style="min-height: 150px;">
                                        <p class="card-text mb-2">
                                            <i class="bi bi-pencil-square me-2"></i>{{ $todo->description }}
                                        </p>
                                        <p class="card-text">
                                            <i class="bi bi-calendar2-event me-2"></i>{{ \Carbon\Carbon::parse($todo->due_date)->diffForHumans() }}
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-warning px-3" onclick="editTask({{ $todo->id }})">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger px-3" onclick="deleteTask({{ $todo->id }})">
                                                <i class="bi bi-trash3 me-1"></i>Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted fst-italic">
                                <i class="bi bi-arrow-down-up"></i> Tarik dan pindahkan di sini
                            </small>
                        </div>
                    </div>
                    <!-- In Progress -->
                    <div class="col-md-4 pt-5">
                        <h6 class="text-center fw-bold mb-3 text-primary">In Progress</h6>
                        <div class="card border-primary shadow p-9" id="in_progress" ondrop="drop(event)" ondragover="allowDrop(event)">
                            @foreach ($todos->where('status', 'in_progress') as $todo)
                            <div class="card mb-3 draggable text-white shadow-lg" 
                            draggable="true" 
                            ondragstart="drag(event)" 
                            id="todo{{ $todo->id }}" 
                            style="background: linear-gradient(135deg, {{ $todo->color }}, #000); border-radius: 12px;">
                            <div class="card-hover">
                                <div class="card-header text-center py-3" style="background: rgba(0, 0, 0, 0.7); border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                    <h5 class="fw-bold text-white">
                                        <i class="bi bi-card-text me-2"></i>{{ $todo->title }}
                                    </h5>
                                </div>
                                <div class="card-body  d-flex flex-column justify-content-between" style="min-height: 150px;">
                                    <p class="card-text mb-2">
                                        <i class="bi bi-pencil-square me-2"></i>{{ $todo->description }}
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-calendar2-event me-2"></i>{{ \Carbon\Carbon::parse($todo->due_date)->diffForHumans() }}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-warning px-3" onclick="editTask({{ $todo->id }})">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger px-3" onclick="deleteTask({{ $todo->id }})">
                                            <i class="bi bi-trash3 me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                       </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted fst-italic">
                                <i class="bi bi-arrow-down-up"></i> Tarik dan pindahkan di sini
                            </small>
                        </div>
                    </div>
                
                    <!-- Completed -->
                    <div class="col-md-4 pt-5">
                        <h6 class="text-center fw-bold mb-3 text-success">Completed</h6>
                        <div class="card border-success shadow p-9" id="completed" ondrop="drop(event)" ondragover="allowDrop(event)">
                            @foreach ($todos->where('status', 'completed') as $todo)
                            <div class="card  mb-3 draggable text-white shadow-lg" 
                            draggable="true" 
                            ondragstart="drag(event)" 
                            id="todo{{ $todo->id }}" 
                            style="background: linear-gradient(135deg, {{ $todo->color }}, #000); border-radius: 12px;">
                            <div class="card-hover">
                                <div class="card-header text-center py-3" style="background: rgba(0, 0, 0, 0.7); border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                    <h5 class="fw-bold text-white">
                                        <i class="bi bi-card-text me-2"></i>{{ $todo->title }}
                                    </h5>
                                </div>
                                <div class="card-body  d-flex flex-column justify-content-between" style="min-height: 150px;">
                                    <p class="card-text mb-2">
                                        <i class="bi bi-pencil-square me-2"></i>{{ $todo->description }}
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-calendar2-event me-2"></i>{{ \Carbon\Carbon::parse($todo->due_date)->diffForHumans() }}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-warning px-3" onclick="editTask({{ $todo->id }})">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger px-3" onclick="deleteTask({{ $todo->id }})">
                                            <i class="bi bi-trash3 me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                       </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted fst-italic">
                                <i class="bi bi-arrow-down-up"></i> Tarik dan pindahkan di sini
                            </small>
                        </div>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/dashjs/todolist.js') }}"></script>
</x-dashlayout>
