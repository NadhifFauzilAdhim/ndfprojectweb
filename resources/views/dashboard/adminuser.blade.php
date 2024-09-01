<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="row">
         
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User Verif</h5>
              <div class="table-responsive">
                <table class="table text-nowrap align-middle mb-0">
                  <thead>
                    <tr class="border-2 border-bottom border-primary border-0"> 
                      <th scope="col" class="ps-0">Name</th>
                      <th scope="col" >Username</th>
                      <th scope="col" >Joined</th>
                      <th scope="col" class="text-center">Admin</th>
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
                      <td class="text-center fw-medium">@if($user->is_admin) <i class="bi bi-check-circle-fill text-success"></i> @else <i class="bi bi-x-circle-fill text-danger"></i> @endif</td>
                      <td class="text-center fw-medium"><button type="button" class="btn btn-primary">Make Admin</button></td>
                    
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