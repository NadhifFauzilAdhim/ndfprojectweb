<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="row">
         
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                    @if(session()->has('success'))
                        Swal.fire({
                            text: "{{ session('success') }}",
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    @elseif(session()->has('error'))
                        Swal.fire({
                            text: "{{ session('error') }}",
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    @endif
                });
            </script>
              <h5 class="card-title">User Verif</h5>
              <div class="table-responsive">
                <table class="table text-nowrap align-middle mb-0">
                  <thead>
                    <tr class="border-2 border-bottom border-primary border-0"> 
                      <th scope="col" class="ps-0">Name</th>
                      <th scope="col" >Username</th>
                      <th scope="col" >Joined</th>
                      <th scope="col" class="text-center">Email</th>
                      <th scope="col" class="text-center">Verified</th>
                      <th scope="col" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody class="table-group-divider">
                    @forelse ($users as $user)
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">
                        <span class="table-link1 text-truncate d-block">{{ $user->name }}</span>
                      </th>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">{{ $user->username }}</a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">{{ $user->created_at }}</a>
                      </td>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">{{ $user->email }}</a>
                      </td>
                      <td class="text-center fw-medium">@if($user->email_verified_at) <i class="bi bi-check-circle-fill text-success"></i> @else <i class="bi bi-x-circle-fill text-danger"></i> @endif</td>
                      <td class="text-center fw-medium">
                        <form action="{{ route('usersetting.toggleVerification', $user->username) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if($user->email_verified_at)
                                <button type="submit" class="btn btn-danger">Unverify</button>
                            @else
                                <button type="submit" class="btn btn-primary">Verify</button>
                            @endif
                        </form>
                    </td>
                    </tr>
                    @empty

                    @endforelse
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      
        
      </div>
</x-dashlayout>