<?php if (isset($headerCols)) { ?>
    <div class="card-table">
        <table class="table tbl-skeleton">
            <thead>
                <tr>
                    <?php foreach ($headerCols as $col) { ?>
                        <th>
                            <?php echo $col; ?>
                        </th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <tr>
                        <?php for ($j = 0; $j < count($headerCols); $j++) { ?>
                            <td>
                                <div class="skeleton"></div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="card-body">
        <?php echo Labels::getLabel('LBL_LOADING...'); ?>
    </div>
<?php } ?>