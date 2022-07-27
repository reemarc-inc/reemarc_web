<?php $asset_type = 'image_request'; ?>

<form method="POST" action="{{ route('campaign.add_image_request') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="{{ $asset_type }}_c_id" value="{{ $campaign->id }}" />
    <input type="hidden" name="{{ $asset_type }}_asset_type" value="{{ $asset_type }}" />
    <input type="hidden" name="{{ $asset_type }}_author_id" value="{{ Auth::user()->id }}" />

    <div class="form-group">
        <label>Client:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_client" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
    <label>Launch Date: (Lead Time 7 Days)</label>
    <input type="text" name="{{ $asset_type }}_launch_date" id="launch_date"
           class="form-control @error($asset_type.'_launch_date') is-invalid @enderror @if (!$errors->has($asset_type.'_launch_date') && old($asset_type.'_launch_date')) is-valid @endif"
           value="{{ old($asset_type.'_launch_date', null) }}">
    </div>

    <div class="form-group">
        <label>Image Dimensions:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_image_dimensions" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>Image Ratio:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_image_ratio" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>Image Format:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_image_format" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>Max Filesize:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_max_filesize" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>SKU:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_sku" class="form-control" value=""/>
        </div>
    </div>

    <div class="form-group">
        <label>Description</label>
        {!! Form::textarea($asset_type.'_description', null, ['class' => 'form-control summernote']) !!}
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
    // Lead time +7 days - Image Request
    $(function() {
        var lead_time = new Date();
        lead_time.setDate(lead_time.getDate()+7);

        $('input[name="<?php echo $asset_type; ?>_launch_date"]').daterangepicker({
            singleDatePicker: true,
            minDate:lead_time,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
    });
</script>
