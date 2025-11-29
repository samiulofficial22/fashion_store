@extends('admin.layout')

@section('content')

<style>
    .settings-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }
    .nav-tabs .nav-link {
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 8px 8px 0 0;
        color: #555;
    }
    .nav-tabs .nav-link.active {
        background: #0d6efd;
        color: #fff;
    }
    label {
        font-weight: 600;
        margin-bottom: 6px;
    }
    .form-control, select {
        border-radius: 8px;
        padding: 10px 12px;
    }
    .preview-img {
        height: 70px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-top: 10px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 18px;
        border-left: 4px solid #0d6efd;
        padding-left: 12px;
    }

    .save-btn {
        background: #0d6efd;
        padding: 12px 26px;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
    }
</style>

<div class="container py-4">

    <h3 class="mb-4 fw-bold">⚙️ Site Settings</h3>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf


        {{-- TABS --}}
        <ul class="nav nav-tabs mb-4" id="settingTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#basic">🧩 Basic Info</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contact">📞 Contact</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#social">🌐 Social Links</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seo">🔍 SEO</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payment">💳 Payment</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#shipping">🚚 Shipping</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#homepage">🏠 Homepage</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#popup">📢 Popup</a></li>
        </ul>


        <div class="tab-content">

            {{-- BASIC INFO --}}
            <div class="tab-pane fade show active" id="basic">
                <div class="settings-card">
                    <div class="section-title">Basic Information</div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Website Name</label>
                            <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Website Tagline</label>
                            <input type="text" class="form-control" name="tagline" value="{{ $settings['tagline'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
							<label>Logo (Light)</label>
							<input type="file" class="form-control preview-input" data-preview="preview_logo_light">
							
							@if(!empty($settings['logo_light']))
								<img id="preview_logo_light" 
									src="{{ asset('storage/'.$settings['logo_light']) }}" 
									class="img-thumbnail mt-2" style="height:60px;">
							@else
								<img id="preview_logo_light" class="img-thumbnail mt-2" style="height:60px; display:none;">
							@endif
						</div>

                        <div class="col-md-6 mb-3">
                            <label>Logo (Dark)</label>
                            <input type="file" class="form-control" name="logo_dark">
                            @if(!empty($settings['logo_dark']))
                                <img src="{{ asset('storage/'.$settings['logo_dark']) }}" class="preview-img">
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Favicon</label>
                            <input type="file" class="form-control" name="favicon">
                            @if(!empty($settings['favicon']))
                                <img src="{{ asset('storage/'.$settings['favicon']) }}" class="preview-img">
                            @endif
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Preloader</label>
                            <select name="preloader" class="form-control">
                                <option value="on" {{ (setting('preloader')=='on')?'selected':'' }}>ON</option>
                                <option value="off" {{ (setting('preloader')=='off')?'selected':'' }}>OFF</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>


            {{-- CONTACT --}}
            <div class="tab-pane fade" id="contact">
                <div class="settings-card">
                    <div class="section-title">Contact Information</div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Support Email</label>
                            <input type="email" class="form-control" name="support_email" value="{{ $settings['support_email'] ?? '' }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>WhatsApp Number</label>
                            <input type="text" class="form-control" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}">
                        </div>

                        <div class="col-12 mb-3">
                            <label>Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Map Embed Code</label>
                            <textarea class="form-control" name="map_embed" rows="2">{{ $settings['map_embed'] ?? '' }}</textarea>
                        </div>

                    </div>
                </div>
            </div>


            {{-- SOCIAL --}}
            <div class="tab-pane fade" id="social">
                <div class="settings-card">
                    <div class="section-title">Social Media Links</div>
                    <div class="row">
                        @foreach(['facebook','instagram','youtube','tiktok','twitter','linkedin','pinterest'] as $social)
                            <div class="col-md-6 mb-3">
                                <label>{{ ucfirst($social) }} URL</label>
                                <input type="text" class="form-control" name="{{ $social }}" value="{{ $settings[$social] ?? '' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- SEO --}}
            <div class="tab-pane fade" id="seo">
                <div class="settings-card">
                    <div class="section-title">SEO Settings</div>

                    <div class="mb-3">
                        <label>Home Title</label>
                        <input type="text" class="form-control" name="seo_title" value="{{ $settings['seo_title'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="seo_description" rows="2">{{ $settings['seo_description'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Meta Keywords</label>
                        <textarea class="form-control" name="seo_keywords" rows="2">{{ $settings['seo_keywords'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Google Analytics ID</label>
                        <input type="text" class="form-control" name="ga_id" value="{{ $settings['ga_id'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label>Facebook Pixel ID</label>
                        <input type="text" class="form-control" name="fb_pixel" value="{{ $settings['fb_pixel'] ?? '' }}">
                    </div>

                </div>
            </div>


            {{-- PAYMENT --}}
            <div class="tab-pane fade" id="payment">
                <div class="settings-card">
                    <div class="section-title">Payment Gateway</div>

                    <div class="mb-3">
                        <label>Cash On Delivery</label>
                        <select name="cod" class="form-control">
                            <option value="on" {{ (setting('cod')=='on')?'selected':'' }}>Enable</option>
                            <option value="off" {{ (setting('cod')=='off')?'selected':'' }}>Disable</option>
                        </select>
                    </div>

                    <h5 class="fw-bold mt-3">SSLCommerz</h5>
                    <input class="form-control mb-2" type="text" name="ssl_store_id" placeholder="Store ID" value="{{ $settings['ssl_store_id'] ?? '' }}">
                    <input class="form-control mb-3" type="text" name="ssl_store_pass" placeholder="Store Password" value="{{ $settings['ssl_store_pass'] ?? '' }}">

                    <h5 class="fw-bold">Stripe</h5>
                    <input class="form-control mb-2" type="text" name="stripe_key" placeholder="Publishable Key" value="{{ $settings['stripe_key'] ?? '' }}">
                    <input class="form-control mb-3" type="text" name="stripe_secret" placeholder="Secret Key" value="{{ $settings['stripe_secret'] ?? '' }}">

                    <h5 class="fw-bold">Paypal</h5>
                    <input class="form-control mb-2" type="text" name="paypal_client" placeholder="Client ID" value="{{ $settings['paypal_client'] ?? '' }}">
                    <input class="form-control mb-3" type="text" name="paypal_secret" placeholder="Secret" value="{{ $settings['paypal_secret'] ?? '' }}">
                </div>
            </div>


            {{-- SHIPPING --}}
            <div class="tab-pane fade" id="shipping">
                <div class="settings-card">
                    <div class="section-title">Shipping Settings</div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Default Shipping Charge</label>
                            <input type="number" class="form-control" name="ship_default" value="{{ $settings['ship_default'] ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Inside City</label>
                            <input type="number" class="form-control" name="ship_inside" value="{{ $settings['ship_inside'] ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Outside City</label>
                            <input type="number" class="form-control" name="ship_outside" value="{{ $settings['ship_outside'] ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Free Shipping Min Amount</label>
                            <input type="number" class="form-control" name="ship_free_min" value="{{ $settings['ship_free_min'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- HOMEPAGE --}}
            <div class="tab-pane fade" id="homepage">
                <div class="settings-card">
                    <div class="section-title">Homepage Sections</div>

                    <div class="mb-3">
                        <label>Hero Slider Enable</label>
                        <select name="hero_slider" class="form-control">
                            <option value="on" {{ (setting('hero_slider')=='on')?'selected':'' }}>ON</option>
                            <option value="off" {{ (setting('hero_slider')=='off')?'selected':'' }}>OFF</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Slider Image</label>
                        <input type="file" class="form-control" name="slider_image">
                        @if(!empty($settings['slider_image']))
                            <img src="{{ asset('storage/'.$settings['slider_image']) }}" class="preview-img">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label>Banner 1</label>
                        <input type="file" class="form-control" name="banner1">
                    </div>

                    <div class="mb-3">
                        <label>Banner 2</label>
                        <input type="file" class="form-control" name="banner2">
                    </div>
                </div>
            </div>

            {{-- POPUP --}}
            <div class="tab-pane fade" id="popup">
                <div class="settings-card">
                    <div class="section-title">Popup Settings</div>

                    <div class="mb-3">
                        <label>Popup Enable</label>
                        <select name="popup_enable" class="form-control">
                            <option value="on" {{ (setting('popup_enable')=='on')?'selected':'' }}>ON</option>
                            <option value="off" {{ (setting('popup_enable')=='off')?'selected':'' }}>OFF</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Popup Title</label>
                        <input type="text" class="form-control" name="popup_title" value="{{ $settings['popup_title'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label>Popup Description</label>
                        <textarea class="form-control" name="popup_description" rows="2">{{ $settings['popup_description'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Popup Image</label>
                        <input type="file" class="form-control" name="popup_image">
                    </div>
                </div>
            </div>

        </div>

        <button class="btn btn-primary save-btn mt-3">💾 Save Settings</button>

    </form>

</div>
@push('script')
	<script>
	document.addEventListener("DOMContentLoaded", function () {
		const previewInputs = document.querySelectorAll(".preview-input");

		previewInputs.forEach(input => {
			input.addEventListener("change", function () {
				const previewId = this.getAttribute("data-preview");
				const previewImage = document.getElementById(previewId);

				if (this.files && this.files[0]) {
					const reader = new FileReader();
					reader.onload = function (e) {
						previewImage.src = e.target.result;
						previewImage.style.display = 'block';
					};
					reader.readAsDataURL(this.files[0]);
				}
			});
		});
	});
	</script>
@endpush
@endsection
