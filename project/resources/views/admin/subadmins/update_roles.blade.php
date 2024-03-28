  {{-- tạo phần nội dung --}}
  @extends('admin.layout.layout')
  @section('content')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1>Subadmins</h1>
                      </div>
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Subadmins</li>
                          </ol>
                      </div>
                  </div>
              </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                  <div class="card card-default">
                      <div class="card-header">
                          <h5 class="card-name">{{ $title }}</h5>

                          <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                  <i class="fas fa-times"></i>
                              </button>
                          </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                          <div class="row">
                              <div class="col-12">
                                  {{-- Show message --}}
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

                                  @if (Session::has('success_message'))
                                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <strong>Success:</strong> {{ Session::get('success_message') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                  @endif
                                  {{-- Show message --}}

                                  <form name="subadminForm" id="subadminForm" action="{{ url('admin/update-role/' . $id) }}"
                                      method="POST">
                                      @csrf
                                      <input type="hidden" name="subadmin_id" value="{{ $id }}">
                                      {{-- ! kiểm tra roles có rỗng không --}}
                                      @if (!empty($subadminRoles))
                                          {{-- ! duyệt mảng để lấy các roles đã được thiết lập --}}
                                          @foreach ($subadminRoles as $role)
                                              {{-- ! kiểm tra loại module --}}
                                              @if ($role['module'] == 'cms_pages')
                                                  {{-- ! kiểm tra có chọn role view hay không --}}
                                                  @if ($role['view_access'] == 1)
                                                      {{-- ! có thì thêm attribute 'checked' --}}
                                                      @php
                                                          $viewCMSPages = 'checked';
                                                      @endphp
                                                  @else
                                                      {{-- ! không có để '' --}}
                                                      @php
                                                          $viewCMSPages = '';
                                                      @endphp
                                                  @endif
                                                  @if ($role['edit_access'] == 1)
                                                      @php
                                                          $editCMSPages = 'checked';
                                                      @endphp
                                                  @else
                                                      @php
                                                          $editCMSPages = '';
                                                      @endphp
                                                  @endif
                                                  @if ($role['full_access'] == 1)
                                                      @php
                                                          $fullCMSPages = 'checked';
                                                      @endphp
                                                  @else
                                                      @php
                                                          $fullCMSPages = '';
                                                      @endphp
                                                  @endif
                                              @endif
                                              @if ($role['module'] == 'categories')
                                                  {{-- ! kiểm tra có chọn role view hay không --}}
                                                  @if ($role['view_access'] == 1)
                                                      {{-- ! có thì thêm attribute 'checked' --}}
                                                      @php
                                                          $viewCategories = 'checked';
                                                      @endphp
                                                  @else
                                                      {{-- ! không có để '' --}}
                                                      @php
                                                          $viewCategories = '';
                                                      @endphp
                                                  @endif
                                                  @if ($role['edit_access'] == 1)
                                                      @php
                                                          $editCategories = 'checked';
                                                      @endphp
                                                  @else
                                                      @php
                                                          $editCategories = '';
                                                      @endphp
                                                  @endif
                                                  @if ($role['full_access'] == 1)
                                                      @php
                                                          $fullCategories = 'checked';
                                                      @endphp
                                                  @else
                                                      @php
                                                          $fullCategories = '';
                                                      @endphp
                                                  @endif
                                              @endif
                                          @endforeach
                                      @endif
                                      <div class="card-body">
                                          <div class="form-group col-md-6">
                                              <label for="cms_pages">CMS Pages:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                              <input type="checkbox" value="1" {{-- ! kiểm tra view có được thiết lập không --}}
                                                  @if (isset($viewCMSPages)) {{ $viewCMSPages }} @endif
                                                  name="cms_pages[view]">View Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;
                                              <input type="checkbox" value="1" name="cms_pages[edit]"
                                                  @if (isset($editCMSPages)) {{ $editCMSPages }} @endif>View/Edit
                                              Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;
                                              <input type="checkbox" value="1" name="cms_pages[full]"
                                                  @if (isset($fullCMSPages)) {{ $fullCMSPages }} @endif>Full Access
                                              &nbsp;&nbsp;&nbsp;&nbsp;

                                          </div>

                                          <div class="form-group col-md-6">
                                            <label for="categories">Categories:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input type="checkbox" value="1" {{-- ! kiểm tra view có được thiết lập không --}}
                                                @if (isset($viewCategories)) {{ $viewCategories }} @endif
                                                name="categories[view]">View Access
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" value="1" name="categories[edit]"
                                                @if (isset($editCategories)) {{ $editCategories }} @endif>View/Edit
                                            Access
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" value="1" name="categories[full]"
                                                @if (isset($fullCategories)) {{ $fullCategories }} @endif>Full Access
                                            &nbsp;&nbsp;&nbsp;&nbsp;

                                        </div>
                                      </div>
                                      <!-- /.card-body -->
                                      {{-- <input type="hidden" name="status" value="{{ $subadmindata['status'] }}"> --}}
                                      <div>
                                          <button type="submit" class="btn btn-primary">Submit</button>
                                      </div>
                                  </form>
                                  <!-- /.form-group col-md-6 -->
                              </div>
                              <!-- /.col -->
                          </div>
                          <!-- /.row -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">

                      </div>
                  </div>
                  <!-- /.card -->

                  <!-- /.row -->
              </div>
              <!-- /.container-fluid -->
          </section>
          <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
  @endsection
