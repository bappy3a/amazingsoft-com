@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Update your product')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('seller.products') }}">{{__('Products')}}</a></li>
                                            <li class="active"><a href="{{ route('seller.products.edit', $product->id) }}">{{__('Edit Product')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                            <input name="_method" type="hidden" value="POST">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            @csrf
                    		<input type="hidden" name="added_by" value="seller">

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('General')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Name')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="name" placeholder="{{__('Product Name')}}" value="{{ __($product->name) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Category')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-control mb-3 c-pointer" data-toggle="modal" data-target="#categorySelectModal" id="product_category">{{ $product->category->name.'>'.$product->subcategory->name.'>'.$product->subsubcategory->name }}</div>
                                            <input type="hidden" name="category_id" id="category_id" value="{{ $product->category_id }}" required>
                                            <input type="hidden" name="subcategory_id" id="subcategory_id" value="{{ $product->subcategory_id }}" required>
                                            <input type="hidden" name="subsubcategory_id" id="subsubcategory_id" value="{{ $product->subsubcategory_id }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Brand')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker" data-placeholder="Select a brand" id="brands" name="brand_id">
                                                    @foreach (json_decode($product->subsubcategory->brands) as $key => $brand_id)
                                                        <option value="{{ \App\Brand::find($brand_id)->id }}" <?php if($brand_id == $product->brand_id) echo "selected";?> >{{ \App\Brand::find($brand_id)->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Unit')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="unit" placeholder="Product unit" value="{{ $product->unit }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Tag')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3 tagsInput" name="tags[]" placeholder="Type & hit enter" data-role="tagsinput" value="{{ $product->tags }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Images')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="product-images">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Main Images')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    @foreach (json_decode($product->photos) as $key => $photo)
                                                        <div class="col-md-3">
                                                            <div class="img-upload-preview">
                                                                <img src="{{ asset($photo) }}" alt="" class="img-responsive">
                                                                <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                                                <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <input type="file" name="photos[]" id="photos-1" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                <label for="photos-1" class="mw-100 mb-3">
                                                    <span></span>
                                                    <strong>
                                                        <i class="fa fa-upload"></i>
                                                        {{__('Choose image')}}
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info mb-3" onclick="add_more_slider_image()">{{ __('Add More') }}</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Thumbnail Image')}} <small>(290x300)</small> <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                @if ($product->thumbnail_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->thumbnail_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_thumbnail_img" value="{{ $product->thumbnail_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="thumbnail_img" id="file-2" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-2" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Featured')}} <small>(290x300)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                @if ($product->featured_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->featured_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_featured_img" value="{{ $product->featured_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="featured_img" id="file-3" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-3" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Flash Deal')}} <small>(290x300)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                @if ($product->flash_deal_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->flash_deal_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_flash_deal_img" value="{{ $product->flash_deal_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="flash_deal_img" id="file-4" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-4" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Videos')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Video From')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="video_provider">
                                                    <option value="youtube" <?php if($product->video_provider == 'youtube') echo "selected";?> >{{__('Youtube')}}</option>
            										<option value="dailymotion" <?php if($product->video_provider == 'dailymotion') echo "selected";?> >{{__('Dailymotion')}}</option>
            										<option value="vimeo" <?php if($product->video_provider == 'vimeo') echo "selected";?> >{{__('Vimeo')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Video URL')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="video_link" placeholder="{{__('Video link')}}" value="{{ $product->video_link }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Meta Tags')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Meta Title')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" value="{{ $product->meta_title }}" placeholder="{{__('Meta Title')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Description')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="meta_description" rows="8" class="form-control mb-3">{{ $product->meta_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Meta Image')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                @if ($product->meta_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->meta_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_meta_img" value="{{ $product->meta_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" name="meta_img" id="file-5" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-5" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Customer Choice')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row mb-3">
                                        <div class="col-8 col-md-3 order-1 order-md-0">
        									<input type="text" class="form-control" value="{{__('Colors')}}" disabled>
        								</div>
        								<div class="col-12 col-md-7 col-xl-8 order-3 order-md-0 mt-2 mt-md-0">
        									<select class="form-control color-var-select" name="colors[]" id="colors" multiple>
                                                @foreach (\App\Color::orderBy('name', 'asc')->get() as $key => $color)
        											<option value="{{ $color->code }}" <?php if(in_array($color->code, json_decode($product->colors))) echo 'selected'?> >{{ $color->name }}</option>
        										@endforeach
        									</select>
        								</div>
        								<div class="col-4 col-xl-1 col-md-2 order-2 order-md-0 text-right">
        									<label class="switch" style="margin-top:5px;">
                                                <input value="1" type="checkbox" name="colors_active" <?php if(count(json_decode($product->colors)) > 0) echo "checked";?> >
        										<span class="slider round"></span>
        									</label>
        								</div>
                                    </div>
                                    <div id="customer_choice_options">
                                        @foreach (json_decode($product->choice_options) as $key => $choice_option)
        									<div class="row mb-3">
        										<div class="col-8 col-md-3 order-1 order-md-0">
        											<input type="hidden" name="choice_no[]" value="{{ explode('_', $choice_option->name)[1] }}">
        											<input type="text" class="form-control" name="choice[]" value="{{ $choice_option->title }}" placeholder="Choice Title">
        										</div>
        										<div class="col-12 col-md-7 col-xl-8 order-3 order-md-0 mt-2 mt-md-0">
        											<input type="text" class="form-control" name="choice_options_{{ explode('_', $choice_option->name)[1] }}[]" placeholder="Enter choice values" value="{{ implode(',', $choice_option->options) }}" data-role="tagsinput" onchange="update_sku()">
        										</div>
        										<div class="col-4 col-xl-1 col-md-2 order-2 order-md-0 text-right">
                                                    <button type="button" onclick="delete_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>
                                                </div>
        									</div>
        								@endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
        									<button type="button" class="btn btn-info" onclick="add_more_customer_choice_option()">{{ __('Add More Customer Choice Option') }}</button>
        								</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Price')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Unit Price')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="unit_price" placeholder="{{__('Unit Price')}} ({{__('Base Price')}})" value="{{$product->unit_price}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Purchase Price')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="purchase_price" placeholder="{{__('Purchase Price')}}" value="{{$product->purchase_price}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Tax')}}</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="tax" placeholder="{{__('Tax')}}" value="{{$product->tax}}">
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" name="tax_type" data-minimum-results-for-search="Infinity">
                                                    <option value="amount" <?php if($product->tax_type == 'amount') echo "selected";?> >$</option>
                                                    <option value="percent" <?php if($product->tax_type == 'percent') echo "selected";?> >%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Discount')}}</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="discount" placeholder="{{__('Discount')}}" value="{{$product->discount}}">
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" name="discount_type" data-minimum-results-for-search="Infinity">
                                                    <option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?> >$</option>
            	                                	<option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?> >%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" id="sku_combination">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Shipping')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Local Pickup')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="local_pickup_shipping_cost" value="{{ $product->shipping_cost }}" placeholder="{{__('Local Pickup Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="local_pickup" @if($product->shipping_type == 'local_pickup') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Flat Rate')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="flat_shipping_cost" value="{{ $product->shipping_cost }}" placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="flat_rate" @if($product->shipping_type == 'flat_rate') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Free Shipping')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="free_shipping_cost" value="0" disabled placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="free" @if($product->shipping_type == 'free') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Description')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Description')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <textarea class="editor" name="description">{{$product->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('PDF Specification')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('PDF')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="pdf" id="file-6" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="pdf/*" />
                                            <label for="file-6" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose PDF')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box mt-4 text-right">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Update This Product') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="categorySelectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{__('Select Category')}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="target-category heading-6">
                        <span class="mr-3">{{__('Target Category')}}:</span>
                        <span>{{__('Category')}} > {{__('Subcategory')}} > {{__('Sub Subcategory')}}</span>
                    </div>
                    <div class="row no-gutters modal-categories mt-4 mb-2">
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="Search Category" onkeyup="filterListItems(this, 'categories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="categories">
                                        @foreach ($categories as $key => $category)
                                            <li onclick="get_subcategories_by_category(this, {{ $category->id }})">{{ __($category->name) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar" id="subcategory_list">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="Search SubCategory" onkeyup="filterListItems(this, 'subcategories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="subcategories">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar" id="subsubcategory_list">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="Search SubSubCategory" onkeyup="filterListItems(this, 'subsubcategories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list">
                                    <ul id="subsubcategories">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="button" class="btn btn-primary" onclick="closeModal()">{{__('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        var category_name = "";
        var subcategory_name = "";
        var subsubcategory_name = "";

        var category_id = null;
        var subcategory_id = null;
        var subsubcategory_id = null;

        $(document).ready(function(){
            $('#subcategory_list').hide();
            $('#subsubcategory_list').hide();
            update_sku();

            $('.remove-files').on('click', function(){
                $(this).parents(".col-md-3").remove();
            });
        });

        function list_item_highlight(el){
            $(el).parent().children().each(function(){
                $(this).removeClass('selected');
            });
            $(el).addClass('selected');
        }

        function get_subcategories_by_category(el, cat_id){
            list_item_highlight(el);
            category_id = cat_id;
            subcategory_id = null;
            subsubcategory_id = null;
            category_name = $(el).html();
            $('#subcategories').html(null);
            $('#subsubcategory_list').hide();
            $.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
                for (var i = 0; i < data.length; i++) {
                    $('#subcategories').append('<li onclick="get_subsubcategories_by_subcategory(this, '+data[i].id+')">'+data[i].name+'</li>');
                }
                $('#subcategory_list').show();
            });
        }

        function get_subsubcategories_by_subcategory(el, subcat_id){
            list_item_highlight(el);
            subcategory_id = subcat_id;
            subsubcategory_id = null;
            subcategory_name = $(el).html();
            $('#subsubcategories').html(null);
            $.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
                for (var i = 0; i < data.length; i++) {
                    $('#subsubcategories').append('<li onclick="confirm_subsubcategory(this, '+data[i].id+')">'+data[i].name+'</li>');
                }
                $('#subsubcategory_list').show();
            });
        }

        function confirm_subsubcategory(el, subsubcat_id){
            list_item_highlight(el);
            subsubcategory_id = subsubcat_id;
            subsubcategory_name = $(el).html();
    	}

        function get_brands_by_subsubcategory(subsubcat_id){
            $('#brands').html(null);
    		$.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
    		    for (var i = 0; i < data.length; i++) {
    		        $('#brands').append($('<option>', {
    		            value: data[i].id,
    		            text: data[i].name
    		        }));
    		    }
    		});
    	}

        function filterListItems(el, list){
            filter = el.value.toUpperCase();
            li = $('#'+list).children();
            for (i = 0; i < li.length; i++) {
                if ($(li[i]).html().toUpperCase().indexOf(filter) > -1) {
                    $(li[i]).show();
                } else {
                    $(li[i]).hide();
                }
            }
        }

        function closeModal(){
            if(category_id > 0 && subcategory_id > 0 && subsubcategory_id > 0){
                $('#category_id').val(category_id);
                $('#subcategory_id').val(subcategory_id);
                $('#subsubcategory_id').val(subsubcategory_id);
                $('#product_category').html(category_name+'>'+subcategory_name+'>'+subsubcategory_name);
                $('#categorySelectModal').modal('hide');
                get_brands_by_subsubcategory(subsubcategory_id);
            }
            else{
                alert('Please choose categories...');
                console.log(category_id);
                console.log(subcategory_id);
                console.log(subsubcategory_id);
                //showAlert();
            }
        }

        var i = $('input[name="choice_no[]"').last().val();
        if(isNaN(i)){
    		i =0;
    	}

    	function add_more_customer_choice_option(){
            i++;
    		$('#customer_choice_options').append('<div class="row mb-3"><div class="col-2"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title"></div><div class="col-9"><input type="text" class="form-control tagsInput" name="choice_options_'+i+'[]" placeholder="Enter choice values" onchange="update_sku()"></div><div class="col-1"><button type="button" onclick="delete_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button></div></div>');
            $('.tagsInput').tagsinput('items');
    	}

    	$('input[name="colors_active"]').on('change', function() {
    	    if(!$('input[name="colors_active"]').is(':checked')){
    			$('#colors').prop('disabled', true);
    		}
    		else{
    			$('#colors').prop('disabled', false);
    		}
    		update_sku();
    	});

    	$('#colors').on('change', function() {
    	    update_sku();
    	});

    	$('input[name="unit_price"]').on('keyup', function() {
    	    update_sku();
    	});

        $('input[name="name"]').on('keyup', function() {
    	    update_sku();
    	});

    	function delete_row(em){
    		$(em).closest('.row').remove();
    		update_sku();
    	}

    	function update_sku(){
            $.ajax({
    		   type:"POST",
    		   url:'{{ route('products.sku_combination_edit') }}',
    		   data:$('#choice_form').serialize(),
    		   success: function(data){
    			   $('#sku_combination').html(data);
    		   }
    	   });
    	}

        var photo_id = 2;
        function add_more_slider_image(){
            var photoAdd =  '<div class="row">';
            photoAdd +=  '<div class="col-2">';
            photoAdd +=  '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            photoAdd +=  '</div>';
            photoAdd +=  '<div class="col-10">';
            photoAdd +=  '<input type="file" name="photos[]" id="photos-'+photo_id+'" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            photoAdd +=  '<label for="photos-'+photo_id+'" class="mw-100 mb-3">';
            photoAdd +=  '<span></span>';
            photoAdd +=  '<strong>';
            photoAdd +=  '<i class="fa fa-upload"></i>';
            photoAdd +=  "{{__('Choose image')}}";
            photoAdd +=  '</strong>';
            photoAdd +=  '</label>';
            photoAdd +=  '</div>';
            photoAdd +=  '</div>';
            $('#product-images').append(photoAdd);

            photo_id++;
            imageInputInitialize();
        }
        function delete_this_row(em){
            $(em).closest('.row').remove();
        }


    </script>
@endsection
