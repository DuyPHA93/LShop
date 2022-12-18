@extends('layout/user')

@section('title')
Trang chủ
@endsection

@section('styles')
<link rel='stylesheet' type='text/css' href='plugins/flickity/css/flickity.css'>
<link rel='stylesheet' type='text/css' href='css/home.css'>
@endsection

@section('script')
<script src='plugins/flickity/js/flickity.pkgd.min.js'></script>
<script src='js/home.js'></script>
@endsection

@section('content')

<div class='wrapper'>
    <div class='row gx-0 mt-4 mb-5'>
        <div class='col-md-12 col-lg-9'>
            <div class='products-tab products-slide'>
                <div class='tabs'>
                    <a class='tab active' href='javascript:;' data-tabid='tab_1'>Sản
                        phẩm bán chạy</a> <a class='tab' href='javascript:;' data-tabid='tab_2'>Sản phẩm mới nhất</a> <a
                        class='tab' href='javascript:;' data-tabid='tab_3'>Sản phẩm khuyến mãi</a>
                </div>
                <div class='tab-content'>
                    <div class="content products-list show product-carousel flickity-outside-button large-columns-5 meidum-columns-4 small-columns-2"
                        id='tab_1'>
                        @foreach($featuredProducts as $item)
                        <div class="col">
                            <div class='product-box'>
                                <div class='photo'>
                                    <a href="{{ route('detail', $item->product->id) }}">
                                        <img alt='' src="{{ url('') }}/{{ $item->imgSrc }}">
                                    </a>
                                </div>
                                <div class='box-text text-center'>
                                    <p class='name'>
                                        <a href="{{ route('detail', $item->product->id) }}">{{ $item->product->name }}</a>
                                    </p>
                                    <p class='price'>
									@currency {{ $item->product->price }} @endcurrency
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class='content products-list large-columns-5 meidum-columns-4 small-columns-2' id='tab_2'>
                        @foreach($lastProducts as $item)
                        <div class="col">
                            <div class='product-box'>
                                <div class='photo'>
                                    <a href="{{ route('detail', $item->id) }}">
                                        <img alt='' src="{{ url('') }}/{{ $item->imgSrc }}">
                                    </a>
                                </div>
                                <div class='box-text text-center'>
                                    <p class='name'>
                                        <a href="{{ route('detail', $item->id) }}">{{ $item->name }}</a>
                                    </p>
                                    <p class='price'>
										@currency {{ $item->price }} @endcurrency
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class='content products-list large-columns-5 meidum-columns-4 small-columns-2' id='tab_3'>
                        @foreach($promotionProducts as $item)
                        <div class="col">
                            <div class='product-box'>
                                <div class='photo'>
                                    <a href="{{ route('detail', $item->id) }}">
                                        <img alt='' src="{{ url('') }}/{{ $item->imgSrc }}">
                                    </a>
                                </div>
                                <div class='box-text text-center'>
                                    <p class='name'>
                                        <a href="{{ route('detail', $item->id) }}">{{ $item->name }}</a>
                                    </p>
                                    <p class='price'>
										@currency {{ $item->price }} @endcurrency
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-3 d-none d-lg-block'>
            <div class='side-right'>
                <div class='featured-news'>
                    <div class='title'>Tin tức nổi bật</div>
                    <div class='news'>
                        <div class='post'>
                            <a href='#'>
                                <h5 class='post-title'>Trọn bộ hình nền Huawei Mate 10 đẹp
                                    “miễn chê” cho mọi smartphone</h5>
                                <div class='divider'></div>
                                <p>Bộ hình nền siêu đẹp từ Huawei Mate 10 đến với nhiều chủ
                                    đề trừu [...]</p>
                            </a>
                        </div>
                        <div class='post'>
                            <a href='#'>
                                <h5 class='post-title'>Rò rỉ thông tin Nokia 6 (2018): Màn
                                    hình tràn viền, tỉ lệ 18:9</h5>
                                <div class='divider'></div>
                                <p>Thông tin rò rỉ từ Trung Quốc cho biết dường như HMD
                                    Global đang có [...]</p>
                            </a>
                        </div>
                        <div class='post'>
                            <a href='#'>
                                <h5 class='post-title'>Meizu Note 8 bất ngờ xuất hiện trong
                                    diện mạo đẹp hoàn hảo</h5>
                                <div class='divider'></div>
                                <p>Hình ảnh thiết kế Meizu Note 8 lấy ý tưởng từ tương lai
                                    với cụm [...]</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


	@foreach($productBlocks as $block)
	<div class='row gx-0 mt-4 mb-5'>
        <div class='col-md-12 col-lg-9'>
            <div class='products-tab'>
                <div class='tabs'>
					@foreach($block->block as $tab)
					<a class="tab {{ $loop->first ? 'active' : '' }}" href='javascript:;' data-tabid='{{ $tab->tab->tabId }}'>{{ $tab->tab->tabName }}</a>
					@endforeach
                </div>
                <div class='tab-content'>
					@foreach($block->block as $tab)
					<div class="content products-list {{ $loop->first ? 'show' : '' }} large-columns-5 meidum-columns-4 small-columns-2" id='{{ $tab->tab->tabId }}'>
                        @foreach($tab->items as $item)
						<div class='col'>
                            <div class='product-box'>
                                <div class='photo'>
                                    <a href="{{ route('detail', $item->id) }}"> <img alt='' src="{{ url('') }}/{{ $item->imgSrc }}"></a>
                                </div>
                                <div class='box-text text-center'>
                                    <p class='name'>
                                        <a href="{{ route('detail', $item->id) }}">{{ $item->name }}</a>
                                    </p>
                                    <p class='price'>@currency {{ $item->price }} @endcurrency</p>
                                </div>
                            </div>
                        </div>
						@endforeach
                    </div>
					@endforeach
                </div>
            </div>
        </div>
        <div class='col-md-3 d-none d-lg-block'>
            <div class='side-right'>
                <div class='ad'>
                    <img alt='' src="{{ url('') }}/{{ $block->ads }}">
                </div>
            </div>
        </div>
    </div>
	@endforeach
</div>

@endsection