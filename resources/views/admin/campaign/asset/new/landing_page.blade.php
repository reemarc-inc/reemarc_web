<?php $asset_type = 'landing_page'; ?>

<form method="POST" action="{{ route('campaign.add_landing_page') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="{{ $asset_type }}_c_id" value="{{ $campaign->id }}" />
    <input type="hidden" name="{{ $asset_type }}_asset_type" value="{{ $asset_type }}" />
    <input type="hidden" name="{{ $asset_type }}_author_id" value="{{ Auth::user()->id }}" />
    <div class="form-group">
        <label>Launch Date: (Lead Time 47 Days)</label>
        <input type="text" name="{{ $asset_type }}_launch_date" id="{{ $asset_type }}_launch_date"
               class="form-control @error($asset_type.'_launch_date') is-invalid @enderror @if (!$errors->has($asset_type.'_launch_date') && old($asset_type.'_launch_date')) is-valid @endif"
               value="{{ old($asset_type.'_launch_date', null) }}">
    </div>

    <div class="form-group">
        <label>Details:</label>
        {!! Form::textarea($asset_type.'_details', null, ['class' => 'form-control summernote']) !!}
    </div>

    <div class="form-group">
        <label>Copy Needed:</label>
        <textarea class="form-control" id="{{ $asset_type }}_copy" name="{{ $asset_type }}_copy" rows="5" cols="100"></textarea>
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Products Featured:</label>
        <input type="text" name="{{ $asset_type }}_products_featured" class="form-control" value="">
        <input type="checkbox" onchange="copy_requested_toggle($(this))"/>
        <label style="color: #98a6ad">Request Copy</label>
    </div>

    <div class="form-group">
        <label>Landing Page URL:</label>
        <div class="input-group" title="">
            <input type="text" name="{{ $asset_type }}_landing_url" class="form-control" placeholder="https://www.example.com" value=""/>
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
    // Lead time +47 days - Landing Page
    $(function() {
        var lead_time = new Date();
        lead_time.setDate(lead_time.getDate()+47);

        $('input[name="<?php echo $asset_type; ?>_launch_date"]').daterangepicker({
            singleDatePicker: true,
            minDate:lead_time,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
    });
</script>
