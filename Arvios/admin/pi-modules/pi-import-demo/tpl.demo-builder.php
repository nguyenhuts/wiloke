 <div id="pi-importdemo" class="main-tabs-panel">
            <div id="inner-tab1" class="inner-tab">

            <div id="imex" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <!-- Panel -->
                                <div class="panel">
                                       
                                        <div class="panel-body">
                                            <div class="notice">
                                                If you are new to Wordpress or have problems  creating   posts, pages look like the Theme Preview, Import demo data will definitely help to understand how those tasks are done. When you import the data following things will happen: 
                                                <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                                                    <li>Pages, Posts, Images, Categories, Custom post types and other data will be deleted or modifed</li>
                                                    <li>No Wordpress settings will be modifed</li>
                                                    <li>A few pages, posts, and 10+ images, some widgets and menu will get imported </li>
                                                    <li>Images will be dowloaded from our server, these images are copyrighted and are for demo only use</li>
                                                    <li>Please click import demo button and wait, it can take a couple of minutes</li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="panel-body"> 

                                            <div class="form-control processbar hidden">
                                                <div class="progress"> 
                                                      <div class="progress-bar progress-bar-danger progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        <span class="sr-only">100% Complete</span>
                                                      </div>
                                                </div>
                                            </div>


                                            <div class="form-control">
                                                <input type="hidden" name="_wp_nonce" value="<?php echo  wp_create_nonce("wo-nonce"); ?>">
                                                <?php wp_referer_field();  ?>
                                                <button class="btn btn-danger import-demo-data" type="button">Import</button> 
                                            </div>

                                            <div class="wo-alert">

                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>