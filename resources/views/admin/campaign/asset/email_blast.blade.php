<?php $asset_id = $data[0][0]->asset_id; $c_id = $data[0][0]->id; $a_type = $data[0][0]->type; ?>

<?php if(!empty($data[6]) && (auth()->user()->role == 'admin' || auth()->user()->role == 'creative director')) { ?>
<div class="card" style="background-color: #f5f6fe; margin-bottom: 3px; margin-top: 3px;">
    <form method="POST" action="{{ route('asset.assign') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Assignee</label>
            <select class="form-control" name="assignee">
                <option value="">Select</option>
                @foreach ($assignees as $designer)
                    <option value="{{ $designer->first_name }}" {{ $designer->first_name == $data[6] ? 'selected' : '' }}>
                        {{ $designer->first_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="a_id" value="{{ $asset_id }}">
        <input type="hidden" name="c_id" value="{{ $c_id }}">
        <input type="hidden" name="a_type" value="{{ $a_type }}">
        <div class=" text-right">
            <button class="btn btn-info">Change</button>
        </div>
    </form>
</div>
<?php } ?>

<form method="POST" action="{{ route('campaign.edit_email_blast', $asset_id) }}" enctype="multipart/form-data">
    @csrf

    <?php if (!empty($data[5])) { ?>
    <div class="form-group" style="padding-left: 10px;">
        <label style="color: #a50018; font-size: medium;"> * Decline Reason from Copy Review:</label>
        <textarea class="form-control" id="concept" name="concept" readonly style="height: 100px;">{{ $data[5] }}</textarea>
    </div>
    <?php } ?>

    <?php if (!empty($data[3])) { ?>
    <div class="form-group" style="padding-left: 10px;">
        <label style="color: #a50018; font-size: medium;"> * Decline Reason from Creative:</label>
        <textarea class="form-control" id="concept" name="concept" readonly style="height: 100px;">{{ $data[3] }}</textarea>
    </div>
    <?php } ?>

    <?php if (!empty($data[4])) { ?>
    <div class="form-group" style="padding-left: 10px;">
        <label style="color: #a50018; font-size: medium;"> * Decline Reason from KEC:</label>
        <textarea class="form-control" id="concept" name="concept" readonly style="height: 100px;">{{ $data[4] }}</textarea>
    </div>
    <?php } ?>

    <div class="form-group">
        <label>Main Concept:</label>
        <textarea class="form-control" id="concept" name="concept" rows="5" cols="100">{{ $data[0][0]->concept }}</textarea>
    </div>

    <div class="form-group">
        <label>Main Subject Line: <span class="req" title="Required">*</span></label>
        <a href="javascript:void(0)" class="kiss-info-icon" tabindex="-1" title="Use 8 words or less"></a>
        <input required type="text" name="main_subject_line" class="form-control" value="{{ $data[0][0]->main_subject_line }}"/>
    </div>

    <div class="form-group">
        <label>Main Preheader Line: <span class="req" title="Required">*</span></label>
        <input required type="text" name="main_preheader_line" class="form-control" value="{{ $data[0][0]->main_preheader_line }}"/>
    </div>

    <div class="form-group">
        <label>Email Subject Line:</label>
        <a href="javascript:void(0)" class="kiss-info-icon" tabindex="-1" title="To be used as A/B test OR to unopens. Use 8 words or less"></a>
        <input type="text" name="alt_subject_line" class="form-control" value="{{ $data[0][0]->alt_subject_line }}"/>
    </div>

    <div class="form-group">
        <label>Email Preheader Line:</label>
        <a href="javascript:void(0)" class="kiss-info-icon" tabindex="-1" tabindex="-1" title="To be used as A/B test OR to unopens"></a>
        <input type="text" name="alt_preheader_line" class="form-control" value="{{ $data[0][0]->alt_preheader_line }}"/>
    </div>

    <div class="form-group">
        <label>Body Copy:</label>
        {!! Form::textarea('body_copy', !empty($data[0][0]) ? $data[0][0]->body_copy : null, ['class' => 'form-control summernote']) !!}
    </div>

    <div class="form-group">
        <label>Secondary Message:</label>
        <textarea class="form-control" name="secondary_message" rows="5" cols="100">{{ $data[0][0]->secondary_message }}</textarea>
    </div>

    <div class="form-group">
        <label>Click Through Links:</label>
        <div class="input-group" title="">
            <div class="input-group-addon">
                <a href="{{ $data[0][0]->click_through_links }}" target="_blank">
                    <i class="fas fa-external-link-alt" title="Open link in a new tab"></i>
                    </a>
            </div>
            <input type="text" name="click_through_links" class="form-control" placeholder="https://www.example.com" value="{{ $data[0][0]->click_through_links }}"/>
        </div>
    </div>

    <div class="form-group">
        <label>Email List To Use:</label>
        <a href="javascript:void(0)" class="kiss-info-icon" tabindex="-1" title="(CTRL or ⌘) + click to add multiple"></a>
        <select multiple name="email_list[]" class="form-control" style="height:155px;">
            <?php
                $email_list = explode(', ', $data[0][0]->email_list);
                $options = array(
                    'KISS Master List',
                    'KISS VIP List',
                    'imPRESS Master List',
                    'imPRESS VIP List',
                    'JOAH Master List',
                    'JOAH VIP List',
                    'Bejour Master List',
                    'Bejour VIP List',
                );
            ?>
            <?php foreach ($options as $option): ?>
                <?php $selected = ''; ?>
                <?php if (in_array($option, $email_list)) $selected  = 'selected'; ?>
                    <option <?php echo $selected ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
            <?php endforeach ?>
        </select>
    </div>


    <div class="form-group">
        <label>Email Blast Date:</label>
            <input type="text" name="email_blast_date" id="{{$asset_id}}_email_blast_date"
                   class="form-control @error($asset_id.'_email_blast_date') is-invalid @enderror @if (!$errors->has($asset_id.'_email_blast_date') && old($asset_id.'_email_blast_date')) is-valid @endif"
                   value="{{ old($asset_id.'_email_blast_date', !empty($data[0][0]) ? $data[0][0]->email_blast_date : null) }}">
    </div>

    <div class="form-group">
        <table class="reminder_table">
            <tr>
                <td><label><b>CopyWriters Start:</b></label></td>
                <td style="color: #b91d19"><span><b><?php echo date('m/d/Y', strtotime($data[0][0]->email_blast_date . ' -12 weekday')); ?></b></span></td>
            </tr>
            <tr>
                <td><label><b>Creative Start:</b></label></td>
                <td style="color: #b91d19"><span><b><?php echo date('m/d/Y', strtotime($data[0][0]->email_blast_date . ' -10 weekday')); ?></b></span></td>
            </tr>
            <tr>
                <td><label><b>Review Start:</b></label></td>
                <td style="color: #b91d19"><span><b><?php echo date('m/d/Y', strtotime($data[0][0]->email_blast_date . ' -3 weekday')); ?></b></span></td>
            </tr>
            <tr>
                <td><label><b>Development Start:</b></label></td>
                <td style="color: #b91d19"><span><b></b></span></td>
            </tr>
            <tr>
                <td><label><b>E-Commerce Start:</b></label></td>
                <td style="color: #b91d19"><span><b><?php echo date('m/d/Y', strtotime($data[0][0]->email_blast_date . ' -1 weekday')); ?></b></span></td>
            </tr>
        </table>
    </div>

    <div class="form-group">
        <label>Video Link:</label> <span>(if to be featured)</span>
        <input type="text" name="video_link" class="form-control" value="{{ $data[0][0]->video_link }}"/>
    </div>
    {{--<?php if(!empty($data[1])) { ?>--}}
    {{--<?php foreach ($data[1] as $key => $attachment): ?>--}}
    {{--<?php echo $attachment->attachment; ?>--}}
    {{--<?php endforeach; ?>--}}
    {{--<?php } ?>--}}

    <?php if (!empty($data[1])): ?>
        <label>Attachments: </label>
        <br/>
        <?php foreach ($data[1] as $attachment): ?>
            <?php
                $file_ext = $attachment['file_ext'];
                if(strpos($file_ext, ".") !== false){
                    $file_ext = substr($file_ext, 1);
                }
                $not_image = ['pdf','doc','docx','pptx','ppt','mp4','xls','xlsx','csv'];
                $file_icon = '/storage/'.$file_ext.'.png';
                $attachment_link = '/storage' . $attachment['attachment'];
                $open_link = 'open_download';
            ?>
            <div class="attachment_wrapper">
                <?php $name = explode('/', $attachment['attachment']); ?>
                <?php $name = $name[count($name)-1]; ?>
                <?php $date = date('m/d/Y g:ia', strtotime($attachment['date_created'])); ?>
                <div class="attachement">{{ $name }}</div>
                <a onclick="remove_file($(this))"
                   class="delete attachement close"
                   title="Delete"
                   data-file-name="<?php echo $name; ?>"
                   data-attachment-id="<?php echo $attachment['attachment_id']; ?>">
                    <i class="fa fa-times"></i>
                </a>
                <img title="<?php echo $name . ' (' . date('m/d/Y g:ia', strtotime($date)) . ')'; ?>"
                     data-file-date="<?php echo $date; ?>"
                     <?php
                     if (!in_array($file_ext, $not_image)) {
                        $file_icon = $attachment_link;
                        $open_link = 'open_image';
                     ?>
                        data-toggle="modal"
                        data-target="#exampleModal_<?php echo $attachment['attachment_id']; ?>"
                     <?php
                     }
                     ?>
                     onclick="<?php echo $open_link; ?>('<?php echo $attachment_link; ?>')"
                     src="<?php echo $file_icon; ?>"
                     class="thumbnail"/>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-group">
        <label>Upload Visual References:</label>
        <input type="file" data-asset="default" name="c_attachment[]" class="form-control c_attachment last_upload" multiple="multiple"/>
        <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
    </div>

    <div class="form-group">
        <?php if (!empty($data[2]) && $data[2] == 'copy_requested') { ?>
        <?php if(auth()->user()->role == 'copywriter' || auth()->user()->role == 'admin') { ?>
        <input type="button"
               value="Copy Review"
               onclick="change_to_copy_review($(this))"
               data-asset-id="<?php echo $asset_id; ?>"
               style="margin-top:10px;"
               class="btn btn-success submit"/>
        <?php } ?>
        <?php }?>

        <?php if (!empty($data[2]) && $data[2] == 'copy_review') { ?>
        <?php if(auth()->user()->role == 'ecommerce specialist'
            || auth()->user()->role == 'marketing'
            || auth()->user()->role == 'social media manager'
            || auth()->user()->role == 'admin') { ?>
        <input type="button"
               value="Copy Complete"
               onclick="change_to_copy_complete($(this))"
               data-asset-id="<?php echo $asset_id; ?>"
               style="margin-top:10px;"
               class="btn btn-info submit"/>
        <?php } ?>
        <?php }?>

        <?php if (!empty($data[2]) && $data[2] == 'to_do') { ?>
            <?php if(auth()->user()->role == 'graphic designer' || auth()->user()->role == 'admin') { ?>
                <input type="button"
                       value="Start Asset"
                       onclick="work_start($(this))"
                       data-asset-id="<?php echo $asset_id; ?>"
                       style="margin-top:10px;"
                       class="btn btn-success submit"/>
            <?php } ?>
        <?php }?>

        <?php if (!empty($data[2]) && $data[2] == 'in_progress') { ?>
            <?php if(auth()->user()->role == 'graphic designer' || auth()->user()->role == 'admin') { ?>
                <input type="button"
                       value="Submit for Approval"
                       onclick="work_done($(this))"
                       data-asset-id="<?php echo $asset_id; ?>"
                       style="margin-top:10px;"
                       class="btn btn-info submit"/>
            <?php } ?>
        <?php }?>

        <?php if (!empty($data[2]) && $data[2] == 'done') { ?>
            <?php if(auth()->user()->role == 'ecommerce specialist'
            || auth()->user()->role == 'marketing'
            || auth()->user()->role == 'social media manager'
            || auth()->user()->role == 'admin') { ?>
                <input type="button"
                       value="Final Approval"
                       onclick="final_approval($(this))"
                       data-asset-id="<?php echo $asset_id; ?>"
                       style="margin-top:10px;"
                       class="btn btn-dark submit"/>
            <?php } ?>
        <?php }?>

        <?php if (!empty($data[2]) && $data[2] != 'final_approval') { ?>
            <input type="submit" name="submit" value="Save Changes" style="margin-top:10px;" class="btn btn-primary submit"/>
        <?php }?>
    </div>
</form>

<?php if (!empty($data[2]) && $data[2] == 'copy_review') { ?>
<?php if(auth()->user()->role == 'graphic designer'
|| auth()->user()->role == 'ecommerce specialist'
|| auth()->user()->role == 'marketing'
|| auth()->user()->role == 'social media manager'
|| auth()->user()->role == 'admin') { ?>
<form method="POST" action="{{ route('asset.decline_copy') }}" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label>Decline Reason for Copy Review:</label>
            <textarea class="form-control" id="decline_copy" name="decline_copy" rows="15" cols="100" style="min-height: 200px;"></textarea>
        </div>
    </div>
    <input type="hidden" name="a_id" value="{{ $asset_id }}">
    <input type="hidden" name="c_id" value="{{ $c_id }}">
    <input type="hidden" name="a_type" value="{{ $a_type }}">
    <div class="card-footer text-right">
        <button class="btn btn-primary">Decline</button>
    </div>
</form>
<?php } ?>
<?php } ?>

<?php if (!empty($data[2]) && $data[2] == 'done') { ?>
    <?php if(auth()->user()->role == 'graphic designer'
        || auth()->user()->role == 'ecommerce specialist'
        || auth()->user()->role == 'marketing'
        || auth()->user()->role == 'social media manager'
        || auth()->user()->role == 'admin') { ?>
        <form method="POST" action="{{ route('asset.decline_kec') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Decline Reason from KEC:</label>
                    <textarea class="form-control" id="decline_kec" name="decline_kec" rows="15" cols="100" style="min-height: 200px;"></textarea>
                </div>
            </div>
            <input type="hidden" name="a_id" value="{{ $asset_id }}">
            <input type="hidden" name="c_id" value="{{ $c_id }}">
            <input type="hidden" name="a_type" value="{{ $a_type }}">
            <div class="card-footer text-right">
                <button class="btn btn-primary">Decline</button>
            </div>
        </form>
    <?php } ?>
<?php } ?>


<?php if (!empty($data[1])): ?>
<?php foreach ($data[1] as $attachment): ?>
<div class="modal fade"
     id="exampleModal_<?php echo $attachment['attachment_id']; ?>"
     tabindex="-1"
     data-backdrop="false"
     role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                                    <span aria-hidden="true">
                                      ×
                                  </span>
                </button>
            </div>

            <!--Modal body with image-->
            <?php $name = explode('/', $attachment['attachment']); ?>
            <?php $name = $name[count($name)-1]; ?>
            <div class="modal-title text-lg-center" style="font-size: 18px; color: #1a1a1a; float: right;">{{ $name }} </div>
            <div class="modal-title text-sm-center">{{ $attachment['date_created'] }} </div>
            <div class="modal-body">
                <img class="img-fluid" src="<?php echo '/storage' . $attachment['attachment']; ?>">
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary"
                        data-dismiss="modal"
                        onclick="open_download('<?php echo '/storage' . $attachment['attachment']; ?>')"
                >
                    Download
                </button>
                <button type="button"
                        class="btn btn-danger"
                        data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<script type="text/javascript">
    // Lead time +20 days - Email Blast
    $(function() {
        var lead_time = "<?php echo $data[0][0]->email_blast_date; ?>"

        $('input[id="<?php echo $asset_id;?>_email_blast_date"]').daterangepicker({
            singleDatePicker: true,
            minDate:lead_time,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
    });
</script>
