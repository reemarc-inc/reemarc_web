<?php $asset_type = 'topcategories_copy'; ?>

<form method="POST" action="{{ route('campaign.add_topcategories_copy') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="{{ $asset_type }}_c_id" value="{{ $campaign->id }}" />
    <input type="hidden" name="{{ $asset_type }}_asset_type" value="{{ $asset_type }}" />
    <input type="hidden" name="{{ $asset_type }}_author_id" value="{{ Auth::user()->id }}" />

    <div class="form-group">
    <label>Deadline Date: (Lead Time 3 Days)</label>
    <input type="text" name="{{ $asset_type }}_launch_date" id="launch_date"
           class="form-control @error($asset_type.'_launch_date') is-invalid @enderror @if (!$errors->has($asset_type.'_launch_date') && old($asset_type.'_launch_date')) is-valid @endif"
           value="{{ old($asset_type.'_launch_date', null) }}">
    </div>

    <div class="form-group">
        <label>Copy: (if applicable)</label>
        {!! Form::textarea($asset_type.'_copy', null, ['class' => 'form-control summernote']) !!}
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
        <label>Upload Visual References:</label>
        <input type="file" data-asset="default" name="{{ $asset_type }}_c_attachment[]" class="form-control c_attachment last_upload" multiple="multiple"/>
        <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
    </div>

    <div class="form-group">
        <input type="submit" name="submit" value="create asset" style="margin-top:10px;" class="btn btn-primary submit"/>
    </div>

</form>

<script type="text/javascript">
    // Lead time +3 days - Top Categories Copy
    $(function() {
        var lead_time = new Date();
        lead_time.setDate(lead_time.getDate()+3);

        $('input[name="<?php echo $asset_type; ?>_launch_date"]').daterangepicker({
            singleDatePicker: true,
            minDate:lead_time,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
    });
</script>
