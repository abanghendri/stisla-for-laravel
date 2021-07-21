<div>
    <section class="section">
        <div class="section-header">
            <h1> {{  $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Permissions</div>
            </div>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills w-100">
                                <li class="nav-item mr-1">
                                    <a class="nav-link active" href="#">All <span
                                            class="badge badge-white">{{ count($users) }}
                                        </span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Trash <span
                                            class="badge badge-primary">{{ count($trash) }}</span></a>
                                </li>
                                <li class="nav-pill ml-auto">
                                    @can('users.create')
                                    <a class="nav-link active" href="#" wire:click="open('add')" data-toggle="tooltip"
                                        title="Add New"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    @endcan
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="float-left">
                                <select class="form-control selectric">
                                    <option value=''>Action For Selected</option>
                                    @can('users.create')
                                    <option value='delete' wire:click="confirm(null, true)">Delete</option>
                                    @endcan
                                </select>
                            </div>
                            <div class="float-right">
                                <form>
                                    <div class="input-group">
                                        <input wire:model="search" type="text" class="form-control"
                                            placeholder="Search">

                                    </div>
                                </form>
                            </div>

                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>

                                        <th class="text-center pt-2">
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    wire:click="multiple('all')" data-checkbox-role="dad"
                                                    class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="text-center pt-2">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        wire:click="multiple" wire:model="selectedItems"
                                                        class="custom-control-input" value="{{ $user->id }}"
                                                        id="checkbox-{{ $user->id }}">
                                                    <label for="checkbox-{{ $user->id }}"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>

                                                <div class="dropdown d-inline mr-2">
                                                    <button class="btn btn-primary " type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="dropdown-menu" x-placement="top-start"
                                                        style="position: absolute; transform: translate3d(0px, -10px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        @can('users.edit')
                                                        <a class="dropdown-item"
                                                            wire:click="open('update', {{ $user->id }})"
                                                            href="#">Edit</a>
                                                        @endcan
                                                        @can('users.delete')
                                                        <a class="dropdown-item" wire:click="confirm({{ $user->id }})"
                                                            href="#">Delete</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $users->links() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }} Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label for="name">Fullname</label>
                            <input type="hidden" value="" wire:model="selectedItem">
                            <input wire:model="name" autofocus='' name="name" type="text" id=""
                                placeholder="user's Name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }} </strong>
                            </span>
                            @enderror
                            <label for="name">Email</label>
                            <input wire:model="email" autofocus='' name="email" type="text" id=""
                                placeholder="User's Email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }} </strong>
                            </span>
                            @enderror
                            <label for="name">Password</label>
                            <input wire:model="password" autofocus='' name="email" type="text" id=""
                                placeholder="User's Password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }} </strong>
                            </span>
                            @enderror

                            <div class="form-group">
                                <label for="role">Role <span class="text-danger">*</span></label>
                                <select name="role" wire:model="role" id=""
                                    class="form-control @error('role') is-invalid @enderror">
                                    <option value=""> -- Choose Role --</option>
                                    @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }} </strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" wire:keydown.enter="save" wire:click="save"
                        class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
