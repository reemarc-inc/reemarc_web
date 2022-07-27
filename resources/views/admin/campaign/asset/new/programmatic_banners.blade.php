<?php $asset_type = 'programmatic_banners'; ?>

<form method="POST" action="{{ route('campaign.add_programmatic_banners') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="{{ $asset_type }}_c_id" value="{{ $campaign->id }}" />
    <input type="hidden" name="{{ $asset_type }}_asset_type" value="{{ $asset_type }}" />
    <input type="hidden" name="{{ $asset_type }}_author_id" value="{{ Auth::user()->id }}" />

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Run From: (Lead Time 18 Days)</label>
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


    <div class="form-group checkboxes">
        <label>Include Formats: </label>
        <a href="javascript:void(0)" class="kiss-info-icon" tabindex="-1" title="Choose one or more"></a><br/>
        <?php foreach($programmatic_banners_fields as $checkbox_field): ?>
            <input
                    type="checkbox"
                    name="{{ $asset_type }}_include_formats[]"
                    value="{{ $checkbox_field }}"
            />
            <span> <?php echo $checkbox_field; ?></span><br/>
        <?php endforeach; ?>
    </div>

    <div class="form-group">
        <label>Display Dimension:</label>
        <input type="text" name="{{ $asset_type }}_display_dimension" class="form-control" value="">
    </div>

    <div class="form-group">
        <label>Products Featured:</label>
        <input type="text" name="{{ $asset_type }}_products_featured" class="form-control" value="">
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
    // Lead time +18 days - Programmatic Banners
    $(function() {
        var lead_time = new Date();
        lead_time.setDate(lead_time.getDate()+18);

        $('input[name="<?php echo $asset_type; ?>_date_from"]').daterangepicker({
            singleDatePicker: true,
            minDate:lead_time,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
    });
</script>
