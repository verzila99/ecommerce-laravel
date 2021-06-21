@extends('admin.layouts.default')
@section('content')
  <div class="admin-modal " id="create-product" >
    @if (session('status'))
      <div class="message is-dark" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >

    @endif
    <form action="{{ route('storeProduct')}}" method="post" enctype="multipart/form-data" >
      @csrf

      <div class="field" >
        <label class="label" >{{__('Choose a category')}}</label >
        <div class="control" >
          <div class="select is-fullwidth" >

            <select id="category" name="category" >
              @foreach($categories as $category)
                <option data-category="{{$category->category_name}}" value="{{ $category->category_name
              }}" >{{$category->category_name}}</option >
              @endforeach
            </select >

          </div >
        </div >
      </div >

      <div class="field" >
        <label class="label" >{{__('Title')}}</label >
        <div class="control" >
          <input class="input" type="text" placeholder="{{__('Title')}}" name="title" >
        </div >
      </div >
      <div class="field" >
        <label class="label" >{{__('Manufacturer')}}</label >
        <div class="control" >
          <input class="input" type="text" placeholder="{{__('Manufacturer')}}" name="manufacturer" >
        </div >
      </div >
      <div class="field" >
        <label class="label" >{{__('Price')}}</label >
        <div class="control" >
          <input class="input" type="text" placeholder="{{__('Price')}}" name="price" >
        </div >
      </div >
      <div class="field" >
        <label class="label" >{{__('Vendorcode')}}</label >
        <div class="control" >
          <input class="input" type="text" placeholder="{{__('Vendorcode')}}" name="vendorcode" >
        </div >
      </div >

      <div class="category-props" >
        @foreach($propsOfCategory as $prop)
          <div class="field" >
            <label class="label" >{{$prop->name}}</label >
            <div class="control" >
              <input class="input" type="text" placeholder="{{$prop->name}}" name="{{$prop->name}}" >
            </div >
          </div >

        @endforeach
      </div >
      <div class="file-inputs is-flex is-flex-wrap-wrap py-2" >

        <div class="file has-name  is-flex is-flex-direction-column is-align-items-center is-justify-content-flex-end
    my-3 mr-3" >
          <img class="file-image " src="" alt="" >
          <label class="file-label my-3" >
            <input class="file-input" type="file" accept="image/gif, image/jpeg, image/png" name="image[]" >
            <span class="file-cta" >
        <span class="file-icon" >
          <i class="fas fa-upload" ></i >
        </span >
        <span class="file-label" >
          {{__('Choose a file')}}
        </span >
        </span >
            <span class="file-name" >
        </span >
          </label >

              <span class="file-delete delete-image" >
                  <i class="fas fa-times-circle icon-delete" ></i >
              </span >

          <a id="add-file-input" class="button is-dark field" >
            {{__('Add')}}
          </a >

        </div >
      </div >

      <div class="field is-grouped" >
        <div class="control" >
          <button type="submit" class="button is-success" >{{__('Save')}}</button >
        </div >
      </div >

    </form >

  </div >
@endsection
