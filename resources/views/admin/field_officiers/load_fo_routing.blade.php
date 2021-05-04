<style>
    .table th, .table td {
        padding: .10rem;
        vertical-align: top;
        border-top: 1px solid #f4f5f8;
    }

</style>
<div class="m-portlet__body">
    <!--begin::Section-->
    <div class="m-section">
        <div class="m-section__content">
            <div class="table-responsive">

                <table class="table m-table m-table--head-separator-danger">
                    <thead>
                        <tr>

                            <?php for ($i = 0; $i <= 6; $i++) { ?>
                                <th>
                                    <?php
                                    echo date('l', strtotime("+$i day", strtotime("$first_day_of_week")));
                                    ?>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php for ($i = 0; $i <= 6; $i++) { ?>
                                <td style="text-align:left">
                                    <?php
                                    $date = date('l', strtotime("+$i day", strtotime("$first_day_of_week")));
//                                echo $date;
//                                echo '<br>'; 
                                    ?>
                                    <div class="m-list-timeline">
                                        <div class="m-list-timeline__items">
                                            <?php
                                            foreach ($outlets as $row) {
                                                if (strpos($row['visit_day'], $date)) {
                                                    ?>
                                                    <div class="m-list-timeline__item">
                                                        <span class="m-list-timeline__badge"></span>
                                                        <span class="m-list-timeline__text">{{$row['name']}}</span>
                                                        <br>         
                                                        <br>
                                                    </div>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>



                                </td>
                            <?php }
                            ?>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::Section-->
</div>