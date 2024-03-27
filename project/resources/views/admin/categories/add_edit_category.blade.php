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
                          <h1>Advanced Form</h1>
                      </div>
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active">Advanced Form</li>
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
                          <h3 class="card-name">{{ $title }}</h3>

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

                                  @if (Session::has('error_message'))
                                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                          <strong>Error:</strong> {{ Session::get('error_message') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                  @endif
                                  {{-- Show message --}}

                                  <form name="categoryForm" id="categoryForm"
                                      @if (empty($categorydata['id'])) action="{{ url('admin/add-edit-category') }}" 
                                  @else
                                  action="{{ url('admin/add-edit-category/' . $categorydata['id']) }}" @endif
                                      method="POST" enctype="multipart/form-data">
                                      @csrf
                                      <div class="card-body">
                                          <div class="form-group col-md-6">
                                              <label for="category_name">Category Name*</label>
                                              <input type="text" class="form-control" id="category_name"
                                                  name="category_name" placeholder="Enter Category Name"
                                                  value="{{ old('category_name') }}">
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="category_name">Category Level*</label>
                                              <select name="parent_id" id="" class="form-control">
                                                  <option value="">Select</option>
                                                  <option value="0">Main Category</option>
                                                  @foreach ($getCategories as $cat)
                                                      <option value="{{ $cat['id'] }}">{{ $cat['category_name'] }}
                                                      </option>

                                                      @if (!empty($cat['sub_categories']))
                                                          @foreach ($cat['sub_categories'] as $subcat)
                                                              <option value="{{ $subcat['id'] }}">
                                                                  &nbsp;&nbsp;&raquo; {{ $subcat['category_name'] }}
                                                              </option>
                                                              @if (!empty($subcat['sub_categories']))
                                                                  @foreach ($subcat['sub_categories'] as $subsubcat)
                                                                      <option value="{{ $subsubcat['id'] }}">
                                                                          &nbsp;&nbsp; &nbsp;&nbsp;&raquo;&raquo;
                                                                          {{ $subsubcat['category_name'] }}</option>
                                                                      @if (!empty($subsubcat['sub_categories']))
                                                                          @foreach ($subsubcat['sub_categories'] as $subsubsubcat)
                                                                              <option value="{{ $subsubsubcat['id'] }}">
                                                                                  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&raquo;&raquo;&raquo;
                                                                                  {{ $subsubsubcat['category_name'] }}
                                                                              </option>
                                                                          @endforeach
                                                                      @endif
                                                                  @endforeach
                                                              @endif
                                                          @endforeach
                                                      @endif
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="category_image">Category Image</label>
                                              <input type="file" class="form-control" id="category_image"
                                                  name="category_image">

                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="category_discount">Category Discount</label>
                                              <input type="text" class="form-control" id="category_discount"
                                                  name="category_discount" placeholder="Enter Category Discount"
                                                  value="{{ old('category_discount') }}">
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="url">Category URL*</label>
                                              <input type="text" class="form-control" id="url" name="url"
                                                  placeholder="Enter Category URL" value="{{ old('url') }}">
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="description">Description</label>
                                              <textarea class="form-control" id="description" name="description"rows="3" placeholder="Enter Description">
                                                 {{ old('description') }}
                                            </textarea>
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="meta_title">Meta Title</label>
                                              <input type="text" class="form-control" id="meta_title" name="meta_title"
                                                  placeholder="Enter Category meta_title" value="{{ old('meta_title') }}">
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="meta_description">Meta Description</label>
                                              <input type="text" class="form-control" id="meta_description"
                                                  name="meta_description" placeholder="Enter Category meta_description"
                                                  value="{{ old('meta_description') }}">
                                          </div>
                                          <div class="form-group col-md-6">
                                              <label for="meta_keywords">Meta Description</label>
                                              <input type="text" class="form-control" id="meta_keywords"
                                                  name="meta_keywords" placeholder="Enter Category meta_keywords"
                                                  value="{{ old('meta_keywords') }}">
                                          </div>
                                      </div>
                                      <!-- /.card-body -->
                                      {{-- <input type="hidden" name="status" value="{{ $categorydata['status'] }}"> --}}
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
