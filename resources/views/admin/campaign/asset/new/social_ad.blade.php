<?php $asset_type = 'social_ad'; ?>

<form method="POST" action="{{ route('campaign.add_social_ad') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="{{ $asset_type }}_c_id" value="{{ $campaign->id }}" />
    <input type="hidden" name="{{ $asset_type }}_asset_type" value="{{ $asset_type }}" />
    <input type="hidden" name="{{ $asset_type }}_author_id" value="{{ Auth::user()->id }}" />

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Run From: (Lead Time 16 Days)</label>
                <input type="text" name="{{ $asset_type }}_date_from" id="date_from" placeholder="Start date"
                       class="form-control @error('date_from') is-invalid @enderror @if (!$errors->has('date_from') && old('date_from')) is-valid @endif"
                       value="{{ old('date_from', null) }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Run To: </label>
                <input type="text" name="{{ $asset_type }}_date_to" id="date_to" placeholder="End date"
                       class="form-control datepicker @error('date_to') is-invalid @enderror @if (!$errors->has('date_to') && old('date_to')) is-valid @endif"
                       value="{{ old('date_to', null) }}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Category:</label>
        <select class="form-control" name="category" onchange="select_category($(this))">
            <option value="">Select</option>
{{--            <option value="Awareness Social Ad" {{ $value == $promotion ? 'selected' : '' }}>{{ $value }}</option>--}}
            <option value="Awareness Social Ad">Awareness Social Ad</option>
            <option value="Traffic Social Ad">Traffic Social Ad</option>
            <option value="Conversion Social Ad">Conversion Social Ad</option>
            <option value="Organic Social Ad/Post">Organic Social Ad/Post</option>
        </select>
    </div>

    <div class="form-group checkboxes">
        <label>Include Formats: </label>
        <div class="awareness" hidden>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Video Ad"/>&nbsp;<span>FB/IG Video Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG GIF Ad"/>&nbsp;<span>FB/IG GIF Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Image Ad"/>&nbsp;<span>FB/IG Image Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Carousel Ad"/>&nbsp;<span>FB/IG Carousel Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="TT Video Ad"/>&nbsp;<span>TT Video Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="SC Video Ad"/>&nbsp;<span>SC Video Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="Other Ad"/>&nbsp;<span>Other Ad</span></br>
        </div>
        <div class="traffic" hidden>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Video Trfc Ad"/>&nbsp;<span>FB/IG Video Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG GIF Trfc Ad"/>&nbsp;<span>FB/IG GIF Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Image Trfc Ad"/>&nbsp;<span>FB/IG Image Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Carousel Trfc Ad"/>&nbsp;<span>FB/IG Carousel Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="TT Video Trfc Ad"/>&nbsp;<span>TT Video Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="SC Video Trfc Ad"/>&nbsp;<span>SC Video Trfc Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="Other Trfc Ad"/>&nbsp;<span>Other Trfc Ad</span></br>
        </div>
        <div class="conversion" hidden>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Video Conv Ad"/>&nbsp;<span>FB/IG Video Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Stories Conv Ad"/>&nbsp;<span>FB/IG Stories Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG GIF Conv Ad"/>&nbsp;<span>FB/IG GIF Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Image Conv Ad"/>&nbsp;<span>FB/IG Image Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Carousel Conv Ad"/>&nbsp;<span>FB/IG Carousel Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Catalog Conv Ad"/>&nbsp;<span>FB/IG Catalog Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="TT Video Conv Ad"/>&nbsp;<span>TT Video Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="SC Video Conv Ad"/>&nbsp;<span>SC Video Conv Ad</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="Other Conv Ad"/>&nbsp;<span>Other Conv Ad</span></br>
        </div>
        <div class="organic" hidden>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Video Organ Post"/>&nbsp;<span>FB/IG Video Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Stories Organ Post"/>&nbsp;<span>FB/IG Stories Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="IG Reels Organ Post"/>&nbsp;<span>IG Reels Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG GIF Organ Post"/>&nbsp;<span>FB/IG GIF Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Image Organ Post"/>&nbsp;<span>FB/IG Image Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB/IG Organ Grid"/>&nbsp;<span>FB/IG Organ Grid</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="TT Video Organ Post"/>&nbsp;<span>TT Video Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="SC Video Organ Post"/>&nbsp;<span>SC Video Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="Other Organ Post"/>&nbsp;<span>Other Organ Post</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="FB Cover Image"/>&nbsp;<span>FB Cover Image</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="YT Cover Image"/>&nbsp;<span>YT Cover Image</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="TW Cover Image"/>&nbsp;<span>TW Cover Image</span></br>
            <input type="checkbox" name="social_ad_include_formats[]" value="PIN Cover Image"/>&nbsp;<span>PIN Cover Image</span></br>
        </div>
    </div>

    <div class="form-group">
        <label>Text:</label>
        <input type="text" name="{{ $asset_type }}_text" class="form-control" value="">
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Headline: <b style="color: #b91d19">(Max 40 characters)</b></label>
        <input type="text" name="{{ $asset_type }}_headline" class="form-control" value="">
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Note:</label>
        <textarea class="form-control" id="{{ $asset_type }}_note" name="{{ $asset_type }}_note" rows="5" cols="100" style="height:100px;"></textarea>
    </div>

    <div class="form-group">
        <label>Newsfeed:</label>
        <input type="text" name="{{ $asset_type }}_newsfeed" class="form-control" value="">
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Products Featured:</label>
        <textarea class="form-control" name="{{ $asset_type }}_products_featured" rows="5" cols="100" style="height:100px;"></textarea>
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Destination URL:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_click_through_links" class="form-control" placeholder="https://www.example.com" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>UTM Code:</label>
        <input type="text" name="{{ $asset_type }}_utm_code" class="form-control" value="">
    </div>

    <div class="form-group">
        <label>Promo Code:</label>
        <input type="text" name="{{ $asset_type }}_promo_code" class="form-control" value="">
    </div>


    <div class="form-group">
        <label>Upload Visual References:</label>
        <input type="file" data-asset="default" name="{{ $asset_type }}_c_attachment[]" class="form-control c_attachment last_upload" multiple="multiple"/>
        <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
    </div>

    <div class="form-group">
        <input type="submit" name="submit" value="create asset" style="margin-top:10px;" class="btn btn-primary submit"/>
    </div>

</form>

<script type="text/javascript">
    // Lead time +16 days - Social Ads (exclude weekend)
    $(function() {
        var count = 16;
        var today = new Date();
        for (let i = 1; i <= count; i++) {
            today.setDate(today.getDate() + 1);
            if (today.getDay() === 6) {
                today.setDate(today.getDate() + 2);
            }
            else if (today.getDay() === 0) {
                today.setDate(today.getDate() + 1);
            }
        }
        $('input[name="<?php echo $asset_type; ?>_date_from"]').daterangepicker({
            singleDatePicker: true,
            minDate: today,
            locale: {
                format: 'YYYY-MM-DD'
            },
            isInvalidDate: function(date) {
                return (date.day() == 0 || date.day() == 6);
            },
        });
    });

    function select_category(e){
        $(".awareness").attr("hidden",true);
        $(".traffic").attr("hidden",true);
        $(".conversion").attr("hidden",true);
        $(".organic").attr("hidden",true);

        let category = $(e).val();
        if(category == 'Awareness Social Ad') {
            $('.awareness').removeAttr('hidden');
        }else if(category == 'Traffic Social Ad'){
            $('.traffic').removeAttr('hidden');
        }else if(category == 'Conversion Social Ad'){
            $('.conversion').removeAttr('hidden');
        }else if(category == 'Organic Social Ad/Post'){
            $('.organic').removeAttr('hidden');
        }

    }

</script>
