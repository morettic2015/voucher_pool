<!DOCTYPE html>
<?php
$model = new PersistenceManager();
$status = $model->getStatus();
$list = $model->getList();
?>
<html>

    <head>
        <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
        <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
        <script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
        <script src="https://unpkg.com/jquery/dist/jquery.min.js"></script>
    </head>

    <body>
    <ons-page id="helloworld-page">
        <ons-toolbar>

            <div class="center">
                Voucher Pool
            </div>

        </ons-toolbar>

        <p style="text-align: center;margin-bottom: 40px">
            <b>Willkommensgutscheine</b>
        </p>
        <ons-row style="margin:1px">
            <ons-col width="33%" style="text-align: center;">
                <b><?php echo $status[0]['total']; ?></b>
                <br>Gesamte Gurscheine
            </ons-col>
            <ons-col width="33%" style="text-align: center;">
                <b><?php echo $status[0]['not_used']; ?></b>
                <br>Unbenutzte Gurscheine
            </ons-col>
            <ons-col width="33%" style="text-align: center;">
                <b><?php echo $status[0]['used']; ?></b>
                <br>Benutzte Gurscheine
            </ons-col>
        </ons-row>
        <ons-row>
            <ons-col width="100%" style="text-align: center;margin:30px;">
                <ons-input modifier="material underbar"  type="text"   placeholder="Search">                
                </ons-input>
                
                <ons-button>Search</ons-button>
                <ons-button>Options</ons-button>
            </ons-col>
        </ons-row>
        <ons-list>
            <?php
            foreach ($list as $voucher) {
                $icon = $voucher['enabled'] > 0 ? "md-check" : "md-off";
                ?>
                <ons-list-item>
                    <div class="left">
                        <ons-list-item tappable>
                            <ons-checkbox input-id="<?php echo $voucher['id_voucher_code']; ?>"></ons-checkbox>
                        </ons-list-item>
                    </div>
                    <div class="center">
                        <span class="list-item__title">
                            <ons-icon  icon="<?php echo $icon ?>"  size="40px" class=""></ons-icon>
                            <?php echo $voucher['email']; ?>
                            <br><small><?php echo $voucher['activation_date'] ; ?></small>
                        </span>
                        <span class="list-item__subtitle"><?php echo $voucher['token'] . ' ' . $voucher['enabled']; ?></span>

                    </div>
                    <div class="right">
                        
                        <ons-button  modifier="quiet">Edit</ons-button>
                    </div>
                </ons-list-item>
            <?php } ?>
        </ons-list>

    </ons-page>
</body>

</html>