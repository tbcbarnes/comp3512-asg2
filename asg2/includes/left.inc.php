<aside class="col-md-2">
                <div class="panel panel-info">
                    <div class="panel-heading">Continents</div>
                    <ul class="list-group">
                        <?php
                        echo $help->genContinents();
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->
                <!-- choose sorting method by switching constant POPULARMODE in includes/db_constants.inc.php -->
                <div class="panel panel-info">
                    <div class="panel-heading">Popular</div>
                    <ul class="list-group">
                        <?php                         
                        echo $help->genCountries();
                        ?>
                    </ul>
                </div>
                <!-- end continents panel -->
            </aside>
