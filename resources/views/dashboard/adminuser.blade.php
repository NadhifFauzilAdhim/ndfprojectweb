<x-dashlayout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
              <div class="card border-0 shadow-sm">
                  <div class="card-header bg-white border-0 py-3">
                      <h5 class="card-title mb-0 fw-semibold text-primary">User Verification Management</h5>
                      <a href="{{ route('admin.users.export') }}" class="btn btn-primary btn-sm float-end">Export Email</a>
                  </div>
                  <div class="card-body p-4">
                      <div class="table-responsive rounded-3">
                          <table class="table table-hover mb-0">
                              <thead class="bg-light">
                                  <tr>
                                      <th scope="col" class="ps-4 text-uppercase font-xs text-muted">User</th>
                                      <th scope="col" class="text-uppercase font-xs text-muted">Username</th>
                                      <th scope="col" class="text-uppercase font-xs text-muted">Joined Date</th>
                                      <th scope="col" class="text-uppercase font-xs text-muted">Email</th>
                                      <th scope="col" class="text-center text-uppercase font-xs text-muted">Status</th>
                                      <th scope="col" class="text-center text-uppercase font-xs text-muted">Actions</th>
                                  </tr>
                              </thead>
                              <tbody class="border-top-0">
                                  @forelse ($users as $user)
                                  <tr class="align-middle">
                                      <td class="ps-4">
                                          <div class="d-flex align-items-center">
                                              <div class="avatar-sm me-3">
                                                  <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                                  </div>
                                              </div>
                                              <div>
                                                  <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                              </div>
                                          </div>
                                      </td>
                                      <td>
                                          <span class="text-muted">@</span>{{ $user->username }}
                                      </td>
                                      <td>
                                          {{ $user->created_at->format('M d, Y') }}
                                      </td>
                                      <td>
                                          <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                              {{ $user->email }}
                                          </span>
                                      </td>
                                      <td class="text-center">
                                          @if($user->email_verified_at)
                                          <span class="badge bg-success-subtle text-success">
                                              <i class="bi bi-check-circle me-1"></i>Verified
                                          </span>
                                          @else
                                          <span class="badge bg-danger-subtle text-danger">
                                              <i class="bi bi-x-circle me-1"></i>Pending
                                          </span>
                                          @endif
                                      </td>
                                      <td class="text-center">
                                          @if($user->id != Auth::user()->id)
                                          <form action="{{ route('usersetting.toggleVerification', $user->username) }}" method="POST">
                                              @csrf
                                              @method('PATCH')
                                              <button type="submit" class="btn btn-sm btn-icon">
                                                  @if($user->email_verified_at)
                                                  <span class="text-danger" data-bs-toggle="tooltip" title="Unverify">
                                                      <i class="bi bi-x-circle-fill fs-5"></i>
                                                  </span>
                                                  @else
                                                  <span class="text-success" data-bs-toggle="tooltip" title="Verify">
                                                      <i class="bi bi-check-circle-fill fs-5"></i>
                                                  </span>
                                                  @endif
                                              </button>
                                          </form>
                                          @endif
                                      </td>
                                  </tr>
                                  @empty
                                  <tr>
                                      <td colspan="6" class="text-center py-4">No users found</td>
                                  </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <style>
      .avatar-sm {
          width: 36px;
          height: 36px;
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .table-hover tbody tr:hover {
          background-color: #f8f9fa;
      }
      .card {
          border-radius: 12px;
      }
      .table th {
          font-weight: 600;
      }
      .badge {
          padding: 0.5em 0.75em;
          border-radius: 8px;
      }
  </style>
</x-dashlayout>