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
    <form action="{{ route('updateProduct')}}" method="post" enctype="multipart/form-data" >
      @csrf
      @method('put')
      <div class="field" >
        <label class="label" >Выберите категорию</label >
        <div class="control" >
          <div class="select is-fullwidth" >

            <select id="category" name="category_id" >
              @foreach($categories as $category)
                <option data-category="{{$category->category_name}}" value="{{ $category->category_id}}"

                        @if( $category->category_name === $product->category)
                        selected
                  @endif
                >{{$category->category_name_ru}}</option >
              @endforeach
            </select >

          </div >
        </div >
      </div >

      <div class="field" >
        <label class="label" >Наименование</label >
        <div class="control" >
          <input class="input" type="text" placeholder="Наименование" name="title" value="{{ $product->title}}" >
        </div >
      </div >
      <div class="field" >
        <label class="label" >Производитель</label >
        <div class="control" >
          <input class="input" type="text" placeholder="Производитель" name="manufacturer"
                 value="{{ $product->manufacturer }}" >
        </div >
      </div >
      <div class=" field" >
        <label class="label" >Цена</label >
        <div class="control" >
          <input class="input" type="text" placeholder="Цена" name="price" value="{{ $product->price}}" >
        </div >
      </div >
      <div class=" field" >
        <label class="label" >Артикул</label >
        <div class="control" >
          <input class="input" type="text" placeholder="Артикул" name="vendorcode" value="{{$product->vendorcode}}" >
        </div >
      </div >

      <div class="category-props" >
        @foreach($product->properties as $param)
          <div class="field" >
            <label class="label" >{{$param->name_ru}}</label >
            <div class="control" >
              <input class="input" type="text" placeholder="{{$param->name}}"
                     name="{{$param->name}}" value="{{$param->pivot->value}}" >
            </div >
          </div >

        @endforeach
      </div >
      <div class="file-inputs is-flex is-flex-wrap-wrap py-2" >
        @foreach(explode(',',$product->images) as $image)
        <div class="file has-name  is-flex is-flex-direction-column is-align-items-center is-justify-content-flex-end
    my-3 mr-3" >
          <img class="file-image " src="{{ asset('storage/uploads/images/'.$product->id.'/225x225/' .
                                         $image )}}" alt="" >
          <label class="file-label my-3" >
            <input class="file-input" type="file" accept="image/gif, image/jpeg, image/png" name="image[]" >
            <span class="file-cta" >
        <span class="file-icon" >
          <i class="fas fa-upload" ></i >
        </span >
        <span class="file-label" >
          Выберите файл
        </span >
        </span >
            <span class="file-name" >
        </span >
          </label >
          <a id="add-file-input" class="button is-dark field" >
            Добавить
          </a >

        </div >
          @endforeach
      </div >

      <div class="field is-grouped" >
        <div class="control" >
          <button type="submit" class="button is-info " >Отправить</button >
        </div >
      </div >

    </form >

  </div >
@endsection
