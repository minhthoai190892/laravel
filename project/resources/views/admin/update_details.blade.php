  {{-- tạo phần nội dung --}}
  @extends('admin.layout.layout')
  @section('content')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1 class="m-0">Settings</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Update Admin Details</li>
                          </ol>
                      </div><!-- /.col -->
                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="row">
                      <!-- left column -->
                      <div class="col-md-6">
                          <!-- general form elements -->
                          <div class="card card-primary">
                              <div class="card-header">
                                  <h3 class="card-title">Update Admin Details</h3>
                              </div>
                              {{--  --}}
                              {{-- Show message --}}

                              @if (Session::has('error_message'))
                                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      <strong>Error:</strong> {{ Session::get('error_message') }}
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                              @endif
                              @if (Session::has('success_message'))
                                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      <strong>Success:</strong> {{ Session::get('success_message') }}
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                              @endif


                              @if ($errors->any())
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endif
                              {{-- Show message --}}
                              <!-- form start -->
                              <form method="POST" action="{{ url('admin/update-details') }}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="card-body">
                                      <div class="form-group">
                                          <label for="addmin_email">Email address</label>
                                          {{-- lấy user từ database --}}
                                          <input type="email" class="form-control" id="addmin_email"
                                              value="{{ Auth::guard('admin')->user()->email }}" readonly
                                              style="background-color: #666 ">
                                      </div>

                                      <div class="form-group">
                                          <label for="admin_name">Name</label>
                                          <input type="text" class="form-control" id="admin_name" placeholder="Name"
                                              name="admin_name" value="{{ Auth::guard('admin')->user()->name }}">

                                      </div>
                                      <div class="form-group">
                                          <label for="admin_mobile">Mobile</label>
                                          <input type="text" class="form-control" id="admin_mobile" placeholder="Mobile"
                                              name="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}">
                                      </div>
                                      <div class="form-group">
                                          <label for="admin_image">Photo</label>
                                          <input type="file" class="form-control" id="admin_image" name="admin_image">
                                          @if (!empty(Auth::guard('admin')->user()->image))
                                              <a href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"
                                                  target="_blank" rel="noopener noreferrer">view</a>
                                                  <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">
                                          @endif
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                                  <div class="card-footer">
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
      </div>
  @endsection
