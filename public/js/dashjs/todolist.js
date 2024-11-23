$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#addTodoForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.post('/dashboard/todolist', formData, function (response) {
        if (response.success) {
            const todo = response.todo;
            const card = `
                <div class="card mb-3 draggable text-white shadow-lg" 
                    draggable="true" 
                    ondragstart="drag(event)" 
                    id="todo${todo.id}" 
                    style="background: linear-gradient(135deg, ${todo.color}, #000); border-radius: 12px;">
                    
                    <!-- Header -->
                    <div class="card-header text-center py-3" 
                        style="background: rgba(0, 0, 0, 0.7); border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="fw-bold text-white">
                            <i class="bi bi-card-text me-2"></i>${todo.title}
                        </h5>
                    </div>
                    
                    <!-- Body -->
                    <div class="card-body d-flex flex-column justify-content-between" style="min-height: 150px;">
                        <!-- Description -->
                        <p class="card-text mb-2">
                            <i class="bi bi-pencil-square me-2"></i>${todo.description}
                        </p>
                        
                        <!-- Due Date -->
                        <p class="card-text">
                            <i class="bi bi-calendar2-event me-2"></i>${todo.due_date}
                        </p>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-sm btn-outline-warning px-3" onclick="editTask(${todo.id})">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger px-3" onclick="deleteTask(${todo.id})">
                                <i class="bi bi-trash3 me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#pending').append(card);
            $('#addTodoForm')[0].reset();
        }
    });
});
function allowDrop(event) {
    event.preventDefault();
}
function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}
function drop(event) {
    event.preventDefault();
    const data = event.dataTransfer.getData("text");
    const card = document.getElementById(data);
    const newStatus = event.target.id;
    event.target.appendChild(card);
    const todoId = data.replace('todo', '');
    $.ajax({
        url: `/dashboard/todolist/${todoId}`,
        type: 'PUT',
        data: { status: newStatus },
        success: function (response) {
            const toastElement = document.getElementById('statusToast');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
}
let todoIdToDelete = null;
function deleteTask(todoId) {
    todoIdToDelete = todoId;
    $('#deleteModal').modal('show');
}
$('#confirmDeleteBtn').on('click', function () {
    if (todoIdToDelete) {
        $.ajax({
            url: `/dashboard/todolist/${todoIdToDelete}`,
            type: 'DELETE',
            success: function (response) {
                if (response.success) {
                    $(`#todo${todoIdToDelete}`).remove();
                    $('#deleteModal').modal('hide');
                }
            },
            error: function (xhr, status, error) {
                console.error('Gagal menghapus task:', error);
            }
        });
    }
});
