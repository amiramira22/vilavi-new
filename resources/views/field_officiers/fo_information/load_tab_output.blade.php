

<?php
$admin = request()->session()->get('connected_user_id');

$ids = array();
$components = array();

//dd($events);
foreach ($events as $row) {
    $row = get_object_vars($row);
    //dd($row['id']);
    $id = $row['id'];
    if (!in_array($id, $ids)) {
        $ids[] = $id;
    }

    $components[$row['fo_id']][$id] = array($row['id'], $row['type'], $row['created_date'], $row['note'], $row['created_time'], $row['date_de_conge']);
}
//echo '<br>';
//echo '<br>';
//echo '<br>';
//
//print_r($components);
//echo '<br>';
//echo '<br>';
//echo '<br>';
?>
<br><br><br>

<div class="table-responsive">
    <table class="table table-bordered table-hover" id="">
        <thead>
            <tr>


                <?php if ((request()->session()->get('connected_user_id') == 1 || request()->session()->get('connected_user_id') == 10 || request()->session()->get('connected_user_id') == 32)) { ?>
                    <th  colspan="5">
                        <?php
                        echo reverse_format($date_js);
                        ?>
                    </th>
                <?php } else { ?>

                    <th  colspan="4">
                        <?php
                        echo reverse_format($date_js);
                        ?>
                    </th>
                <?php } ?>


            </tr>
            <tr>
                <th>Inserted</th>
                <th>FO</th>
                <th class ="text-center">Type</th>
                <th class ="text-center">Note</th>

                <?php if ((request()->session()->get('connected_user_id') == 1 || request()->session()->get('connected_user_id') == 10 || request()->session()->get('connected_user_id') == 32)) { ?>
                    <th class ="text-center">Action</th>
                <?php } ?>
            </tr>

        <thead>

        <tbody>
            <?php
            $i = 0;
            foreach ($components as $fo_id => $componentDates) {
                foreach ($ids as $id) {
                    if (isset($componentDates[$id])) {
//                    echo $fo_id;
//                    print_r($componentDates[$id]);
//                    echo '<br>';
//                    echo '<br>';

                        $i++;
                        if ((request()->session()->get('connected_user_id') == 1 || request()->session()->get('connected_user_id') == 10 || request()->session()->get('connected_user_id') == 32)) {
                            ?>
                            <tr>
                                <td width="100px"><?php
                                    $Time = strtotime("-60 minutes", strtotime($componentDates[$id][4]));
                                    echo reverse_format($componentDates[$id][2]) . " " . date('H:i:s', $Time);
                                    ?>
                                </td>

                                <td width="160px">

                                    <?php //echo form_dropdown('fo_id', $fo_ids, $fo_id, 'class=form-control id=fo_id' . $componentDates[$id][0] . ' onchange="update_fo_information_fo_id(' . $componentDates[$id][0] . ')"'); ?>
                                    {!! Form::select('fo_id', $fos , $fo_id ,['class' => 'form-control m-input','id'=>'fo_id'.$componentDates[$id][0],'onchange'=>'update_fo_information_fo_id('.$componentDates[$id][0].')']) !!}

                                </td>

                                <td width="125px">
                                    <select id="<?php echo 'type' . $componentDates[$id][0] ?>" 
                                            name="'type[' <?php $componentDates[$id][0] ?> ']'" 
                                            value="<?php echo $componentDates[$id][0] ?>" 
                                            class="form-control m-input" onchange="update_fo_information_type(<?php echo $componentDates[$id][0]; ?>)">

                                        <option value="Holiday" <?php
                                        if (($componentDates[$id][1]) == 'Holiday') {
                                            echo 'selected="selected"';
                                        }
                                        ?>>Holiday
                                        </option>

                                        <option value="Routing" <?php
                                        if (($componentDates[$id][1]) == 'Routing') {
                                            echo 'selected="selected"';
                                        }
                                        ?>> Routing
                                        </option>

                                        <option value="Authorization" <?php
                                        if (($componentDates[$id][1]) == 'Authorization') {
                                            echo 'selected="selected"';
                                        }
                                        ?>>  Authorization
                                        </option>
                                    </select>
                                </td>

                                <td width="90px"> 
                                    <a type="textarea rows='4' cols='50'" 
                                       title="<?php echo $componentDates[$id][3]; ?>"
                                       name="description" 
                                       onclick="setEditable(this);" 
                                       data-pk="<?php echo $componentDates[$id][0]; ?>" 
                                       data-placeholder="Enter comments" 
                                       data-name="description" 
                                       data-type="textarea" 
                                       data-url="{{ route('admin.fo_report.update_comment_fo_information') }}" 
                                       data-value="<?php echo $componentDates[$id][3]; ?>" 
                                       data-prev="admin"  
                                       data-title="Enter description">

                                        <i class="fa fa-comment" style="color: #F03434"></i>
                                    </a>
                                </td>

                                <td width="50px"> 
                                    <a href="{{ route('admin.fo_report.delete_fo_information',[$componentDates[$id][0],$date_js]) }}" onclick="return confirm('Are you sure you want to delete this visit?')"><i class="flaticon-delete"></i></a>
                                </td>
                            </tr>
                        <?php } else {// end foreach components              ?>
                            <tr>
                                <td width="100px"><?php
                                    $Time = strtotime("-60 minutes", strtotime($componentDates[$id][4]));
                                    echo reverse_format($componentDates[$id][2]) . " " . date('H:i:s', $Time);
                                    ?></td>
                                <td>

                                </td>
                                <td><?php echo $componentDates[$id][1]; ?></td>
                                <td><?php echo $componentDates[$id][3]; ?> </td>
                            </tr>
                        <?php } ?>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
    function setEditable(obj) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(obj).editable({

            emptytext: $(obj).attr('data-value'),
            toggle: 'click',
            mode: 'inline',
            anim: 200,
            onblur: 'cancel',
            validate: function (value) {
                /*Add Ur validation logic and message here*/
                if ($.trim(value) == '') {
                    return 'comment is required!';
                }

            },
            params: function (params) {
                /*originally params contain pk, name and value you can pass extra parameters from here if required */
                //eg . params.active="false";
                return params;
            },
            success: function (response, newValue) {
                var result = $.parseJSON(response);
                $(obj).parent().parent().find('.edit-box').show();
                $(obj).attr('data-value', result.description);
                $(obj).attr('data-prev', result.description);
            },
            error: function (response, newValue) {
                $(obj).parent().parent().find('.edit-box').hide();
                if (!response.success) {
                    return 'Service unavailable. Please try later.';
                } else {
                    return response.msg;
                }

            },
            display: function (value) {
                /*If you want to truncate*/
                var strName = '';
                strName = $(obj).attr('data-value');
                var shortText = '';
                if (strName.length > 16)
                {
                    shortText = jQuery.trim(strName).substring(0, 14).split("").slice(0, -1).join("") + "...";
                } else {
                    shortText = strName;
                }
                $(this).text(shortText);
            }
        });
        $(obj).editable('option', 'value', $(obj).attr('data-value'));
    }</script>

<script>
    function update_fo_information_type(id) {

        type = document.getElementById('type' + id).value;
        jQuery.ajax({

            url: '<?= route('admin.fo_report.update_fo_information_type') ?>',
            data: {_token: CSRF_TOKEN, id: id, type: type},
            type: "POST",
            success: function (data) {
                //alert('succes');
                document.getElementById('type' + id).style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('type' + id).style.backgroundColor = "#ffb2b2";
            }
        }
        );
    }
</script>

<script>
    function update_fo_information_fo_id(id) {

        fo_id = document.getElementById('fo_id' + id).value;
        jQuery.ajax({
            url: '<?= route('admin.fo_report.update_fo_information_fo_id') ?>',
            data: {_token: CSRF_TOKEN, id: id, fo_id: fo_id},
            type: "POST",
            cache: false,
            success: function (data) {
                //alert('succes');
                document.getElementById('fo_id' + id).style.backgroundColor = "#b2ffb2";
            },
            error: function (data) {
                document.getElementById('fo_id' + id).style.backgroundColor = "#ffb2b2";
            }
        }
        );
    }
</script>