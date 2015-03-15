<form action="" method="POST">
    <div id="main-tab" class="main-tab">
        <div id="inner-tab" class="inner-tab"> 
            <div id="wo-update" class="main-tabs-panel">
                <div id="inner-tab1" class="inner-tab">
                    <div id="imex" class="inner-tabs-panel">
                        <div class="inner-content">
                            <div class="container-12-fluid">
                                <div class="container-12-row">
                                    <div class="large-12">
                                        <!-- Panel -->
                                        <div class="panel">
                                               <div class="panel-header" style="padding: 10px;">
                                                    <h4>Theme Update</h4>
                                               </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="form-label">Your Themeforest User Name</label>
                                                        <div class="controls">
                                                            <input type="text" name="username" value="<?php echo isset($aOptions['username']) ? $aOptions['username'] : ''; ?>" class="form-control">
                                                            <span class="help">Enter the Name of the User you used to purchase this theme</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Your Themeforest API Key</label>
                                                        <div class="controls">
                                                            <input type="text" name="apikey" value="<?php echo  isset($aOptions['apikey']) ? $aOptions['apikey'] : ''; ?>" class="form-control">
                                                            <span class="help">Enter the API Key of your Account here. You can <a href="http://premium.wpmudev.org/blog/wp-content/uploads/2012/07/WordPress-Envato-Auto-Updates-01.png" target="_blank">find your API Key here</a></span> 
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce("wo-update-save"); ?>">
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-footer">
    <div class="wo-wrap-button">
        <div class="form-group">
            <button type="submit" name="save-update" value="Save" class="btn btn-red">Save</button>
        </div>
    </div>
</div>
</form>